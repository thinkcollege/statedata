<?php
class user {
	protected $userid = 0, $fname = '', $lname = '', $region = '', $county = '', $provider = '',
		$email = '', $password = '', $loggedIn = false, $supervisor = false, $disabled = false;
	
	private function __construct($username = '', $password = '') {
		$this->login($username, $password);
	}
	
	static public function getInstance($email = '', $password = '') {
		static $instance = null;
		if (has_value($_SESSION, 'user')) {
			$instance = $_SESSION['user'];
		}
		if ($instance === null) {
			$_SESSION['user'] = $instance = new self;
			
			if (!empty($email) && !empty($password))
				$instance->login($email, $password);
		}
		return $instance;
	}
	
	public function login($username, $password) {
		global $msgs, $t;
		if (!$username || !$password) {
			return $this->loggedIn();
		}
		$username = e($username);
		$password = e($password);
		if (has_value('userid', $_SESSION, 0, COMP_GT)) {
			$where = 'id = ' . intval($_SESSION['userid']);
		} else {
			$where = "username = '$username' AND password = SHA1(CONCAT('$password', salt))";
		}
		$msgs[] = 'Set to Query: ' . (microtime(true) - $t);
		$rs = fQuery('SELECT id,FirstName, LastName, username, RegionCode, CountyCode, ProviderNumber,disabled,Supervisor FROM '
					. TABLE_USER . ' WHERE ' . $where);
		$msgs[] = 'Queried: ' . (microtime(true) - $t);
		if ($rs->queriedRows() == 1) {
			$row = $rs->fetchAssoc();
			if ($row['disabled'] === false) {
				$this->setId($row['id']);
				$this->setFirstName($row['FirstName']);
				$this->setLastName($row['LastName']);
				$this->setEmail($row['username']);
				$this->setRegion($row['RegionCode']);
				$this->setCounty($row['CountyCode']);
				$this->setProvider($row['ProviderNumber']);
				$this->supervisor($row['Supervisor']);
				$this->loggedIn = true;
			} else {
				error('Your account has been disabled.');
			}
		} else if (!empty($username) && !empty($password)) {
			error('Unknown username and password.');
		}
		$msgs[] = "Set attributes: " . (microtime(true) - $t);
		return $this->loggedIn();
	}
	
	public function loggedIn() {
		return $this->loggedIn;
	}
	
	public function logout() {
		$this->userid = 0;
		$this->fname = $this->lname = $this->region = $this->county = $this->provider = $this->email = $this->password = '';
		$this->loggedIn = $this->supervisor = $this->disabled = false;
		$_SESSION = array();
		if (isset($_COOKIE[session_name()])) {
    		setcookie(session_name(), '', time()-42000, '/');
		}
		header('Location: http' . (LIVE ? 's' : '') . '://' . DOMAIN . DIR, true, 302);
			// Finally, destroy the session.
		session_destroy();
		exit;
	} 
	
	public function isSupervisor() {
		return $this->supervisor;
	}
	
	protected function supervisor($super) {
		$this->supervisor = $super && 1;
		return true;
	}
	
	public function isDisabled() {
		return $this->disabled;
	}
	
	protected function disabled($disabled) {
		$this->disabled = $disabled && 1;
	}
	
	public function getID() {
		return $this->userid;
	}
	
	protected function setID($id) {
		if (intval($id) > 0) {
			$this->userid = intval($id);
			return true;
		}
		return false;
	}
	
	public function getFirstName() {
		return $this->fname;
	}
	
	protected function setFirstName($fname) {
		if (valid($fname)) {
			$this->fname = $fname;
			return true;
		}
		return false;
	}
	
	public function getLastName() {
		return $this->lname;
	}
	
	protected function setLastName($lname) {
		if (valid($lname)) {
			$this->lname = $lname;
			return true;
		}
		return false;
	}
	
	public function getRegion() {
		return $this->region;
	}
	
	protected function setRegion($region) {
		if (preg_match(REGEX_REGION_CODE, $region) || $region == '') {
			$this->region = $region;
			$this->county = '';
			$this->provider = ''; 
			return true;
		}
		return false;
	}
	
	public function getCounty() {
		return $this->county;
	}
	
	protected function setCounty($county) {
		if (preg_match(REGEX_COUNTY_CODE, $county)) {
			$ret = getVar('SELECT 1 FROM ' . TABLE_BILLING . ' WHERE RegionCode = \'' . e($this->region) . '\' AND CountyCode = \'' . e($county) . '\' LIMIT 0,1');
			if ($ret == 1) {
				$this->county = $county;
				$this->provider = '';
				return true;
			} else {
				error('This county is not in the user\'s region.');
				return false;
			}
		} else if ($county != '') {
			error('Invalid County.');
		}
		return false;
	}
	
	public function getProvider() {
		return $this->provider;
	}
	
	protected function setProvider($provider) {
		if (preg_match(REGEX_PROVIDER_NUMBER, $provider)) {
			$ret = getVar('SELECT 1 FROM ' . TABLE_BILLING 
						. ' WHERE RegionCode = \'' . e($this->region) . '\' AND CountyCode = \'' . e($county) . '\' AND ProviderNumber = \'' . e($provider) . '\' LIMIT 0,1');
			if ($ret == 1) {
				$this->provider = $provider;
				return true;
			} else {
				error('This provider is not in the User\'s region and county.');
				return false;
			}
		} else if ($provider != '') {
			error('Invalid Provider.');
		}
		return false;
	}
	
	public function getEmail() {
		return $this->email;
	}
		
	protected function setEmail($email) {
		if (valid_email($email)) {
			$this->email = $email;
			return true;
		}
		return false;
	}
	
	public function getPassword() {
		return $this->password;
	}
	
	protected function setPassword($pass) {
		if (checkPasswordComplexity($pass)) {
			$this->password = $pass;
			return true;
		}
		return false;
	}
	
	public function save($fname, $lname, $email, $pass, $region, $county, $provider, $super, $disabled) {
		$cUser = user::getInstance();	// Current User
		$id = $this->getID();
		$update = $id > 0;
		
		if ($id != $cUser->getID() && !$cUser->isSupervisor()) {
			error('You are not a supervisor, you cannot create or update users.');
			return false;
		}
				
		if (!$this->setFirstName($fname)) {
			error('Invalid First Name.');
		}
		if (!$this->setLastName($lname)) {
			error('Invalid Last Name.');
		}
		if (!$this->setEmail($email)) {
			error('Invalid E-mail address.');
		}
		if (($id == 0 || $pass !== null) && !$this->setPassword($pass)) {
			error('The password given doesn\'t meet the UMass Boston password complexity requirements.');
		}
		if ($cUser !== $this && $cUser->getRegion() != '') {
			$this->setRegion($cUser->getRegion());
		} else if ($cUser->isSupervisor()) {
			$this->setRegion($region);
		}
		if ($cUser !== $this && $cUser->getCounty() != '') {
			$this->setCounty($cUser->getCounty());
		} else if ($cUser->isSupervisor()) { 
			$this->setCounty($county);
		}
		if ($cUser !== $this && $cUser->getProvider() != '') {
			$this->setProvider($cUser->getProvider());
		} else if ($cUser->isSupervisor()) {
			$this->setProvider($provider);
		}
		if ($update && !$this->setID($id)) {
			error('Invalid User id for upadte.');
		}
		$this->supervisor($super && $cUser->isSupervisor());
		$this->disabled($disabled && $cUser->isSupervisor());
		
		if (!hasError()) {
			$rs = fQuery($update ? $this->generateUpdateQuery() : $this->generateInsertQuery());
			if (!$update) {
				$this->setID($rs->insert_id());
			}
			return $rs->affectedRows() == 1;
		}
		return false;
	}
	
	public function delete($id) {
		$cUser = user::getInstance();
		if (!$cUser->isSupervisor()) {
			error('You cannot delete a user because you are not a supervisor!');
			return;
		}
		
	}
	
	/**
	 * returns user
	 */
	static public function getUser($id) {
		$cUser = user::getInstance();
		if (intval($id) == 0) {
			return new user();
		}
		if (!$cUser->isSupervisor()) {
			error('You are not a supervisor, you cannot access other user\'s information!');
			return;
		}
		$rs = fQuery('SELECT id,username,password, FirstName, LastName, RegionCode, CountyCode, ProviderNumber, Supervisor, disabled
						fROM ' . TABLE_USER
				   . ' WHERE id = ' . intval($id)
				   . ($cUser->getRegion() != '' ? ' AND `RegionCode` = \'' . e($cUser->getRegion()) . '\'' : '')
				   . ($cUser->getCounty() != '' ? ' AND `CountyCode` = \'' . e($cUser->getCounty()) . '\'' : '')
				   . ($cUser->getProvider() != '' ? ' AND `ProviderNumber` = \'' . e($cUser->getProvider()) . '\'' : ''));
		if ($rs->queriedRows() == 1) {
			$row = $rs->fetchAssoc();
			$user = new user();
			$user->setID($row['id']);
			$user->setFirstName($row['FirstName']);
			$user->setLastName($row['LastName']);
			$user->setEmail($row['username']);
			$user->setPassword($row['password']);
			$user->setRegion($row['RegionCode']);
			$user->setCounty($row['CountyCode']);
			$user->setProvider($row['ProviderNumber']);
			$user->supervisor($row['Supervisor']);
			$user->disabled($row['disabled']);
			return $user;
		} else {
			error('This user doesn\'t exist in this geographic area.');
		}
	}
	
	protected function generateInsertQuery() {
		$cols = array('getFirstName', 'getLastName', 'getRegion', 'getCounty', 'getProvider', 'getEmail', 'isSupervisor');
		$salt = '';
		
		for ($i = 0; $i < count($cols); $i++) {
			$salt .= $this->$cols[mt_rand(0, count($cols) - 1)]();
		}
		$salt = sha1(uniqid('', true) . $salt);
		return 'INSERT INTO ' . TABLE_USER
			. ' (`FirstName`, `LastName`, `RegionCode`, `CountyCode`, `ProviderNumber`, `username`, `password`, Supervisor, `disabled`, `salt`) VALUE (\''
			. e($this->getFirstName()) . '\', \'' . e($this->getLastName()) . '\', \''
			. e($this->getRegion()) . '\', \'' . e($this->getCounty()) . '\', \''
			. e($this->getProvider()) . '\', \'' . e($this->getEmail()) .'\', \''
			. e(sha1($this->getPassword() . $salt)) . '\', \'\\' . ($this->isSupervisor() ? 1 : 0)
			. '\', \'\\' . e($this->isDisabled() ? 1 : 0) . '\', \'' . e($salt) . '\')';
	}
	
	protected function generateUpdateQuery() {
		return 'UPDATE ' . TABLE_USER . ' SET `Firstname` = \'' . e($this->getFirstName()) . '\', `Lastname` = \''
			. e($this->getLastName()) . '\', `RegionCode` = \'' . e($this->getRegion()) . '\', `CountyCode` = \''
			. e($this->getCounty()) . '\', `ProviderNumber` = \'' . e($this->getProvider()) . '\', `username` = \''
			. e($this->getEmail())
			. (valid($this->getPassword()) ? '\', `password` = SHA1(CONCAT(\'' . e($this->getPassword()) . '\', salt))' : '\'')
			. ', `Supervisor` = \'\\' . ($this->isSupervisor() ? 1 : 0) .'\', disabled = \'\\' . ($this->isDisabled() ? 1 : 0)
			. '\' WHERE id = ' . $this->getID();
	}
	
 }
<?php    
/*
class: user
purpose: user management
*/
class user extends base{
	protected $is_admin = 0, $userid = 0, $extension = array();
	
	protected function User($userid = 0) {
		if (intval($userid) == 0) {
			$this->userid = (isset($_SESSION['userid'])) ? intval($_SESSION['userid']) : 0;
		} else {
			$this->userid = $userid;
		}

		write_debug("in user id:" . $this->userid);
		if ($this->userid != 0) {
			write_debug("getting extension data");
			$this->extension = $this->get_extension_data();
		}
		write_debug("done with user create");
	}
	
	static function getUser($userid = 0) {
		static $user = null;
		if ($user == null) {
			$user = new User($userid);
		}
		return $user;
	}

	function getUserId() {
		return $this->userid;
	}

	function isAdmin() {
		return $this->is_admin;
	}

	function getExtension($key = '') {
		return (has_value($key, $this->extension) ? $this->extension[$key] : null);
	}
	
	/*
	function: log_in
	purpose: attempt to log in
	*/
	function log_in($email, $password, $camefrom = "", $remember = ""){
		$database = Database::getDatabase();
		setcookie("userid", "", 0, $this->user_cookie_path, $this->user_cookie_domain);
		$return['success'] = 'false';
		if ($email != "" and $password != "") {
			$email = $database->escape($email);
			$password = $database->escape($password);
			$result = $database->query("SELECT userid, is_admin FROM users
										 WHERE email = '$email' and password='$password'");
			if (($row = $database->fetch_assoc($result)) != null) {
				if ($remember == "true") {
					setcookie("userid",$row['userid'],time()+142200000,$this->user_cookie_path,$this->user_cookie_domain);
				} else {
					setcookie("userid",$row['userid'],0,$this->user_cookie_path,$this->user_cookie_domain);
				}
				$return["camefrom"] = $camefrom;
				$return["success"] = "true";
				$return["userid"] = $this->userid = $_SESSION['userid'] = $row['userid'];
				$this->is_admin = $row['is_admin'];
			} else {
				$return["camefrom"] = $camefrom;
				$return["success"] = "false";
			}
		}
		if ($this->userid != 0) {
			$this->extension = $this->get_extension_data();
		}
		return $return;
	}

	/*
	 * function: log_out
	 * purpose: log a user out of system
	 */
	function log_out() {
		setcookie ("userid", $this->userid, -1, $this->user_cookie_path, $this->user_cookie_domain);
		$_SESSION['userid'] = $this->userid = "";
		$this->extension = array();
	}
/*
function: get_account
purpose: get user account information
*/
function get_account() {
		$check = $this->logged_in();
		if ($check["success"] == "false") {
			$return["message"] = "Sorry, but you must be logged in";
			$return["success"] = "false";
		} else {
			$database = Database::getDatabase();
			$result = $database->query("SELECT userid,first_name,last_name,email,password,is_admin, address1,address2,city,state,zip,phone, 'true' AS success
										  FROM users WHERE userid = $this->userid");
			if ($database->num_rows($result) == 1) {
				$return = $database->fetch_assoc($result);
				$return["extension"] = $this->get_extension_data();
			}
		}
		return $return;
	}

//need to add saving of user extension data
/*
function: edit_account
purpose: edit user account
*/
static function edit_account($userid, $password, $newpassword = '', $first_name, $last_name, $email, $address1 = '', $address2 = '', $city = '', $state = '', $zip = '', $phone = '', $is_admin, $extension = '') {
    $userid = intval($userid);
    $database = Database::getDatabase();
    if ($newpassword == ""){
        $newpassword = $password;
    }
    $check = $database->query("select userid from users where userid=$userid and password='$password';");
    if ($database->num_rows($check) == 1) {
        $database->query("update users set first_name='$first_name',last_name='$last_name',email='$email',password='$newpassword', is_admin='$is_admin', address1='$address1',address2='$address2',city='$city',state='$state',zip='$zip',phone='$phone' where userid=$userid");
        $user = new user($userid);
        $user->save_extension_data($extension);
        $return["success"] = "true";
    } else{
        $return["success"] = "false";
    }
    return $return;
}
/*
function: register
purpose: register user
*/
static function register($password, $first_name, $last_name, $email, $address1, $address2, $city, $state, $zip, $phone, $is_admin, $extension = '') {
	$database = Database::getDatabase();
	if ($first_name <> "" and $last_name <> "" and $email <> "" and $password <> "") {
		$database->query("insert into users (first_name,last_name,email,password,is_admin,address1,address2,city,state,zip,phone) values('$first_name','$last_name','$email','$password','$is_admin','$address1','$address2','$city','$state','$zip','$phone')");
		$id = $database->insert_id;
		if ($id > 0){
			$user = new user($id);
			$user->save_extension_data($extension);
			//$user->log_in($email,$password,"","false");
			$return["success"] = "true";
			$return["message"] = "User has been added. Congratulations.";
		} else {
			$return["success"]="false";
		}
	}
	return $return;
}

/*
function: deleteUser
purpose: delete user
*/
function deleteUser($uid){
	$database = Database::getDatabase();
	$database->query("delete from users where userid = $uid");
	$database->query("delete from users_ext where user_id = $uid");
	if ($this->userid == $uid) {
		$this->log_out();
		header('Location: '.$this->mre_base_webpath);
		exit;
	}
	return $return;
}

/*
function: logged_in
purpose: check if logged in
*/
function logged_in() {
	$database = Database::getDatabase();
	if ($this->userid == 0) {
		write_debug("nope not logged in a");
		$this->is_admin = 0;
		$return["success"] = "false";
		return $return;
	}
	$check = $database->query("SELECT userid, is_admin FROM users WHERE userid = $this->userid");
	if ($row = $database->fetch_assoc($check)){
		write_debug("yepp, logged in a". $row['is_admin'] . "a");
		$return["success"] = "true";
		$this->is_admin = $row['is_admin'];
		if ($this->userid != 0) {
			$this->extension = $this->get_extension_data();
		}
	} else {
		write_debug("nope not logged in a");
		$this->user_id = $this->is_admin = 0;
		$return["success"] = "false";
	}
	return $return;
}

/*
function: get_users
purpose: get users
*/
static function get_users(){
	$database = Database::getDatabase();
	$result = $database->query("select userid,first_name,last_name,email,password,address1,address2,city,state,zip,phone from users where userid > 0 order by last_name asc;");
	$users = $database->mysql_fetch_rowsassoc($result);
	mysql_free_result($result);
	for ($user = 0; $user < count($users); $user++) {
		$user = new User($users[$user]['userid']);
		$users[$user]["extension"] = $user->get_extension_data();
		unset($user);
	}
	return $users;
}

/*
function: get_activity_all
purpose: get activity for all
*/
function get_activity_all($tables = "") {
	if ($tables == "") {
		$tables = $this->user_tables;
	}
	$database = Database::getDatabase();
	$return["success"] = "false";
	$tables = explode(",", $tables);
	$users = $database->query("SELECT userid FROM users");
	for ($user = 0; $user < $database->num_rows($users); $user++){
		$num = 0;
		$theuserid = $database->fetch_result($users, $user, 'userid');
		for ($i = 0; $i < count($tables); $i++){
			$rows = $database->query("SELECT userid FROM ".$tables[$i]." WHERE userid = $theuserid");
			$num += $database->num_rows($rows);
			$total += $database->num_rows($rows);
		}
		$activity[$theuserid] = $num;
		$count++;
	}
	if ($count > 0) {
		arsort($activity);
		$i = -1;
		foreach ($activity as $theuserid => $num) {
			$i++;
			$user = new User($theuserid);
			$info = $user->get_account();
			$return["userid[$i]"] = $info["userid"];
			$return["first_name[$i]"] = $info["first_name"];
			$return["last_name[$i]"] = $info["last_name"];
			$return["email[$i]"] = $info["email"];
			$return["total[$i]"] = $num;
			$return["count"]++;
			if ($total==0){
				$return["percent[$i]"] = round(100*0,3)."%";
			}else{
				$return["percent[$i]"] = round(100*($num/$total),3)."%";
			}
			if ($count == 1) {
				$return["percentile[$i]"] = round(100*1,3)."%";
			}else{
				$return["percentile[$i]"] = round(100*($count-($return["count"]))/($count-1),3)."%";
			}
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: get_activity
purpose: get activity
*/
function get_activity($userid, $tables=""){
	if ($tables == ""){
		$tables = $this->user_tables;
	}
	$database = Database::getDatabase();
	$return["success"] = "false";
	$tables = explode(",",$tables);
	$users=$database->query("SELECT userid from users");
	for ($user=0;$user<$database->num_rows($users);$user++){
		$num=0;
		$theuserid=$database->fetch_result($users,$user,'userid');
		for ($i=0;$i<count($tables);$i++){
			$rows=$database->query("select userid from ".$tables[$i]." where userid=$theuserid;");
			$num+=$database->num_rows($rows);
			$total+=$database->num_rows($rows);
		}
		$activity[$theuserid]=$num;
		$count++;
	}
	if ($count>0){
		arsort ($activity);
		$i = -1;
		foreach ($activity as $theuserid => $num){
			$i++;
			$user=$this->get_account($theuserid);
			if ($user["userid"]==$userid){
				$thisuser=$i;
			}
			$return["userid[$i]"]=$user["userid"];
			$return["first_name[$i]"]=$user["first_name"];
			$return["last_name[$i]"]=$user["last_name"];
			$return["email[$i]"]=$user["email"];
			$return["total[$i]"]=$num;
			$return["count"]++;
			if ($total==0){
				$return["percent[$i]"]=round(100*0,3)."%";
			}else{
				$return["percent[$i]"]=round(100*($num/$total),3)."%";
			}
			if ($count==1){
				$return["percentile[$i]"]=round(100*1,3)."%";
			}else{
				$return["percentile[$i]"]=round(100*($count-($return["count"]))/($count-1),3)."%";
			}
			$return["success"]="true";
		}
	}
	if ($thisuser>-1){
		$allusers=$return;
		$return="";
		$return["userid"]=$allusers["userid[$thisuser]"];
		$return["first_name"]=$allusers["first_name[$thisuser]"];
		$return["last_name"]=$allusers["last_name[$thisuser]"];
		$return["email"]=$allusers["email[$thisuser]"];
		$return["total"]=$allusers["total[$thisuser]"];
		$return["percent"]=$allusers["percent[$thisuser]"];
		$return["percentile"]=$allusers["percentile[$thisuser]"];
		$return["place"]=$thisuser+1;
		$return["success"]="true";
	}
	return $return;
}


function get_extension_data($force = false) {
	if (count($this->extension) > 0 && !$force) {
		return $this->extension;
	}
	
	$query = 'select user_id,key, value from users_ext where user_id = ' . $this->userid;
	$userext_results = $database->query($query);
	write_debug("userext_results rows: ". $database->num_rows($results));

	write_debug("userext_results fields: ". $database->num_fields($results));
	for ($result = 0; $result < $database->num_rows($userext_results); $result++) {
		$key = $database->fetch_result($userext_results, $result, 1);
		$value = $database->fetch_result($userext_results, $result, 2);
		
		write_debug("key ". $key);
		write_debug("value ". $value);
		$cols[$key] = $value;
	}
	return $cols;
}

function save_extension_data($extension = '') {
	write_debug("in save_extension_data");

	$database = Database::getDatabase();

	if (is_array($extension)) {
		$check = $database->query("select user_id from users_ext where user_id = $userid and key= '$key';");

		if ($database->num_rows($check) == 1) {
			$query = "Update users_ext set ";
			foreach ($extension as $key => $value) {
				$query .= "`value` = '$value' ,";
			}

			$query = substr($query, 0, -1)."where user_id = $this->userid  and key= '$key'";
		} else {
			$query_stub = "insert into users_ext (`user_id`,`key`,`value`) values ('$this->userid',  ";
			foreach ($extension as $key => $value) {
				$query  = $query_stub + "'$key','$value')";
				$check = $database->query($query);
			}
		}
		//write_debug($query);
		
	}
}
}
?>
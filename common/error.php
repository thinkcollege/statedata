<?php    
/*
class: error
purpose: track and display page errors
*/
class error extends mre_base{


	function error () {
		$this->errors = array();
	}
	
	
	/*
	function: add_error
	purpose: add an error to the error array
	*/
	function add_error($error_code) { 
		array_push($this->errors,$error_code);
	}
	
	function display_error($error_code, $error_message) {
		if (in_array($error_code, $this->errors)) {
			return "<span class=\"error\">$error_message</span>";
		}
	}
	
	function does_exist($error_code) {
		if (in_array($error_code, $this->errors)) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function error_count() {
		return(count($this->errors));
	}
	
	function write_error_heading() {
		if ($this->error_count() > 0) {
			return "<span class=\"error\">There were problems with the data you entered so it could not be saved. 
				Please correct the errors listed in the form below.</span>";
		} else {
			return "";
		}
	}
	
	//the error array
	var $errors = array();
	
	// validation functions below
	function validate_string($string, $error_code) {
		$string = trim($string);
		if (!empty($string)) {
			return 1;
		} else {
			$this->add_error($error_code);
			return 0;
		}
	}

	function validate_number($number, $error_code) {
		$number = trim($number);

		if (empty($number)) {
			$this->add_error($error_code);
			return 0;
		} elseif (!is_numeric($number)) {
			$this->add_error($error_code);
			return 0;
		} else {
			return 1;
		}
	}
	
	function validate_username($username, $error_code) {
		$username = trim($username);
		$return_value = 0;
		/*	usename may not have any nonalpha-numeric characters.
		*/
		if (!empty($username)) {
			if (!preg_match('/^\w*(?=\w*[\da-zA-Z])\w*$/', $username)) {
					//not valid
					$this->add_error($error_code);
					$return_value = 0;
			} else {
					//format is valid, now is it unique in the database?
					$database = Database::getDatabase();
					$query = "select username from users where username='". $username . "'";
					$results = $database->query($query);
					if ($database->num_rows($results) > 0) {
						//the username is already in the database
						$this->add_error($error_code);
						$return_value = 0;
					} else {
						$return_value = 1;
					}
					$database->close();
			}
		} else {
			$this->add_error($error_code);
			$return_value = 0;
		}
		return $return_value;
	}

	
	function validate_password($pwd, $error_code) {
		$pwd = trim($pwd);
		/*	password has at least one number, one uppercase letter and 
				one nonalpha-numeric character.
		*/
		if (!empty($pwd)) {
			if(strlen($pwd) < 6 ) { 
				$this->add_error($error_code);
				return 0;
			} else {
				if (!preg_match('/^[\W_\w]*(?=[\W_\w]*\d)(?=[\W_\w]*[A-Z])[\w_\W]*$/', $pwd)) {
					//not valid
					$this->add_error($error_code);
					return 0;
				} else {
					if (!preg_match('/^[\W_\w]*(?=[\W_])[\w_\W]*$/', $pwd)) {
						//not valid
						$this->add_error($error_code);
						return 0;
					} else {
						return 1;
					}
				}
			}
		} else {
			$this->add_error($error_code);
			return 0;
		}
	}
	
	
	function validate_email( $email, $error_code ) { 
  	$email = trim( $email );
	  if (!empty($email) ) {
	    //  validate email address syntax 
	    if (!preg_match('/^[A-Za-z0-9\\_\\.]+@[A-Za-z0-9\\-]+\\.[A-Za-z]+\\.?[A-Za-z]{2,4}$/i', $email) ) {
	      $this->add_error($error_code);
				$return_value = -1; # NOT valid! 
	    } else {
				//valid format, now make sure it is not in the database already
				$database = Database::getDatabase();
				$query = "select email from users where email='". $email . "'";
				$results = $database->query($query);
				if ($database->num_rows($results) > 0) {
					//the email address is already in the database
					$this->add_error($error_code);
					$return_value = 0;
				} else {
					$return_value = 1;
				}
				$database->close();
			}
	  } else {
			$this->add_error($error_code);
		  $return_value = 0; # NOT valid! 
		}
		return $return_value;
	} 

	function validate_projectname($projectname, $error_code) {
		$projectname = trim($projectname);
		$return_value = 0;
		/*	projectname may not be already in use.
		*/
		if (!empty($projectname)) {
				//format is valid, now is it unique in the database?
				$database = Database::getDatabase();
				$query = "select name from projects where name='". $projectname . "' and user_id=" . $_COOKIE['user_id'];
				
				$results = $database->query($query);
				if ($database->num_rows($results) > 0) {
					
					//the projectname is already in the database for this user.
					$this->add_error($error_code);
					$return_value = 0;
				} else {
					$return_value = 1;
				}
				$database->close();
		} else {
			$this->add_error($error_code);
			$return_value = 0;
		}
		return $return_value;
	}

	
	function debug() {
		$oConfig =  new RDVO_base;
		$html = "";
		if ($oConfig->debug) {
			$html = $this->error_count() ."<br>";
			foreach ($this->errors as $key => $val) {
				$this->errors[$key] = $val;
				$html = $html . $val . "<br>";
			}
		}
	}

}


?>
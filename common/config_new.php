<?php
/**
 * Base configuration class.
 */
class mre_base {
	/**
	 * Configuration for all classes
	 */
	function mre_base() {
		//mre_base Configuration
		$this->mre_base_version="2.3";
		$this->mre_base_sitename="StateData.info";
		$this->mre_base_path=dirname(__FILE__);
		$this->mre_base_webpath="http://statedata.info/";

		//Database Configuration
		$this->database_type="mysql"; //postgresql,mysql,mssql
		$this->database_host="localhost";
		$this->database_port="";
		$this->database_dbname="corduroy";
		$this->database_username="statedata";
		$this->database_password="icistatedata99";

		//Template Configuration
		$this->template_dir="templates/";
		$this->template_tempdir="temp/";
		$this->template_debug="false";
		//User Configuration
		$this->user_cookie_path="/";
		$this->user_cookie_domain=".statedata.info";
		#$this->user_cookie_domain="www.communityinclusion.org";
		$this->user_tables="articles,schedule,posts";
		//Permission Configuration
		$this->permission_read="true";
		$this->permission_write="false";
		$this->permission_admin="false";
		//Email Configuration
		$this->email_from="elugardo@gmail.com";
	}

	//mre_base
	var $mre_base_version;
	var $mre_base_sitename;
	var $mre_base_path;
	var $mre_base_webpath;
	//Database
	protected $database_conn;
	protected $database_type;
	protected $database_host;
	protected $database_port;
	protected $database_dbname;
	protected $database_username;
	protected $database_password;
	//Template
	var $template_dir;
	var $template_tempdir;
	//User
	var $user_cookie_path;
	var $user_cookie_domain;
	var $user_tables;
	//Permission
	var $permission_read;
	var $permission_write;
	var $permission_admin;
	//Email
	var $email_from;
}?>

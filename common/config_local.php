<?php  
/*
class: mre_base
purpose: configuration
*/
class mre_base {

/*
function: mre_base
purpose: configuration for all classes
*/
function mre_base(){
	//mre_base Configuration
	$this->mre_base_version="2.3";
	$this->mre_base_sitename="ICI";
	$this->mre_base_path="h:/Inetpub/wwwroot/castiron/clients/ici/development/";
	$this->mre_base_webpath="http://127.0.0.1:8080/";
	//Database Configuration
	$this->database_type="mysql"; //postgresql,mysql,mssql
	$this->database_host="localhost";
	
	$this->database_port="";
	$this->database_dbname="corduroy";
	$this->database_username="marconik";
	$this->database_password="poh&nika";
	
	//Template Configuration
	$this->template_dir="templates/";
	$this->template_tempdir="temp/";
	$this->template_debug="true";
	//User Configuration
	$this->user_cookie_path="/";
	$this->user_cookie_domain="127.0.0.1";
	$this->user_tables="articles,schedule,posts";
	//Permission Configuration
	$this->permission_read="true";
	$this->permission_write="false";
	$this->permission_admin="false";
	//Email Configuration
	$this->email_from="marcos@castirondesign.com";
	//Article Configuration
	$this->article_emailid="1";
	$this->article_url="articles/article.php";
	$this->article_treeid="1";
	//Forum Configuration
	$this->forum_emailid="2";
	$this->forum_url="forum/forum.php";
	//Calendar Configuration
	$this->calendar_emailid="3";
	$this->calendar_url="calendar/event.php";
	//Filesystem Configuration
	$this->filesystem_path="h:/Inetpub/wwwroot/castiron/clients/ici/development/filesystem/files/";
	$this->filesystem_webpath="http://127.0.0.1:8080/filesystem/files";	
	//Poll Configuration
	$this->poll_percentimage="images/poll/percent.gif";
}

	//mre_base
	var $mre_base_version;
	var $mre_base_sitename;
	var $mre_base_path;
	var $mre_base_webpath;
	//Database
	var $database_conn;
	var $database_type;
	var $database_host;
	var $database_port;
	var $database_dbname;
	var $database_username;
	var $database_password;
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
	//Article
	var $article_emailid;
	var $article_url;
	var $article_tree;
	//Forum
	var $forum_emailid;
	var $forum_url;
	//Calendar
	var $calendar_emailid;
	var $calendar_url;
	//Filesystem
	var $filesystem_path;
	var $filesystem_webpath;
	//Poll
	var $poll_percentimage;
}
?>
<?php  
ini_set("include_path","../../");
include("common/classes.php");
$database=new database;
?>
<html>
<head>
<title>Install mre_base</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF" text="#000000">
<h3>Install mre_base </h3>
<form name="form1" method="post" action="index.php">
  <b><u>Database</u></b>:<br>
  <b>Host</b>: 
  <input type="text" name="database_host" value="<?php echo $database->database_host?>">
  <br>
  <b>Port</b>: 
  <input type="text" name="database_port" value="<?php echo $database->database_port?>">
  <br>
  <b>Database name</b>: 
  <input type="text" name="database_dbname" value="<?php echo $database->database_dbname?>">
  <br>
  <b>Username</b>: 
  <input type="text" name="database_username" value="<?php echo $database->database_username?>">
  <br>
  <b>Password</b>: 
  <input type="text" name="database_password" value="<?php echo $database->database_password?>">
  <br>
  <b>Type</b>:<br>
  <input type="radio" name="database_type" value="postgresql" <?php if (function_exists('pg_connect')<>TRUE){?>disabled<?php }?> <?php if ($database->database_type=="postgresql"){?> checked<?php }?>>
  Postgresql <br>
  <input type="radio" name="database_type" value="mysql" <?php if (function_exists('mysql_connect')<>TRUE){?>disabled<?php }?> <?php if ($database->database_type=="mysql"){?> checked<?php }?>>
  MySQL <br>
  <input type="submit" name="Submit" value="Install">
  <input type="hidden" name="install" value="true">
</form>
<br>
<br>
<?php
if ($_POST["install"]=="true"){
	echo "<b><u>Installing...</u></b><br>";
	if ($_POST["database_type"]=="postgresql"){
		//POSTGRESQL DATABASE
		$connstring="";
		if ($_POST["database_host"]<>""){$connstring.=" host=".$_POST["database_host"];}
		if ($_POST["database_port"]<>""){$connstring.=" port=".$_POST["database_port"];}
		if ($_POST["database_username"]<>""){$connstring.=" user=".$_POST["database_username"];}
		if ($_POST["database_password"]<>""){$connstring.=" password=".$_POST["database_password"];}
		$template=pg_connect("$connstring dbname=template1");
		pg_query($template,"drop database ".$_POST["database_dbname"]);
		pg_query($template,"create database ".$_POST["database_dbname"]);
		if ($_POST["database_host"]<>""){$connstring.=" host=".$_POST["database_host"];}
		if ($_POST["database_port"]<>""){$connstring.=" port=".$_POST["database_port"];}
		if ($_POST["database_dbname"]<>""){$connstring.=" dbname=".$_POST["database_dbname"];}
		if ($_POST["database_username"]<>""){$connstring.=" user=".$_POST["database_username"];}
		if ($_POST["database_password"]<>""){$connstring.=" password=".$_POST["database_password"];}
		$mre_base=pg_connect($connstring);
		echo "<b>Postgresql Database...</b><br />";
		$file = @fopen("mre_base_postgresql.sql","r");
		while (!feof ($file)) {
    		$sql=stripslashes(fgets($file, 4096));
			echo $sql."<br />";
			pg_query($mre_base,$sql);
		}
		fclose ($file);
	}elseif ($_POST["database_type"]=="mysql"){
		//MYSQL DATABASE
		$connstring="";
		mysql_connect($_POST["database_host"].":".$_POST["database_port"],$_POST["database_username"],$_POST["database_password"]);
		mysql_select_db($_POST["database_dbname"]);
		mysql_query("drop database ".$_POST["database_dbname"]);
		mysql_query("create database ".$_POST["database_dbname"]);
		mysql_select_db($_POST["database_dbname"]);
		echo "<b>MySQL Database...</b><br />";
		$file = @fopen("mre_base_mysql.sql","r");
		while (!feof ($file)) {
    		$sql=stripslashes(fgets($file, 4096));
			echo $sql."<br />";
			mysql_query(str_replace(";\n","",$sql));
		}
		fclose ($file);
	}
}
?>
</body>
</html>
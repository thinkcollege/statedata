<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Untitled</title>
</head>

<body>
a
<?php
include("config.php"); 	
include("database.php");
include("downloads.php");
$downloads = new downloads;
echo $downloads->downloadsAry[0]["downloadid"] ."<BR>";
echo $downloads->downloadsAry[1]["tablename"] ."<BR>";
echo $downloads->downloadsAry[3]["displayname"] ."<BR>";
echo $downloads->downloadsAry[4]["downloadFile"] ."<BR>";
echo $downloads->downloadsAry[5]["descriptionFile"] ."<BR>";
echo "b";
?>

c
</body>
</html>

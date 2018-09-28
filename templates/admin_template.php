<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html>
<head>
<?php 
ini_set("include_path","../");
$database = Database::getDatabase();
$pages=new page;
$pages->add_page($_SERVER["PHP_SELF"]);

?>
<title>{title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL='stylesheet' TYPE='text/css' HREF='/common/styles.css'>
<script language="JavaScript" src="/common/rollovers.js"></script>
<script language="JavaScript" src="/common/common.js"></script>
<script language="JavaScript" src="/common/functions.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td width="1"><a href="../index.php"><img src="../images/logo.gif"  border="0" alt="mre_base Community System"></a></td>
	<td valign="middle" align="right" width="50000"> logos</td>
  </tr>
  <tr> 
	<td colspan="2" valign="top" align="center" height="1" class="headerbar"><img src="../images/spacer.gif" width="100%" height="11" alt="spacer"></td>
  </tr>
  <tr> 
	<td><img src="../images/spacer.gif" width="200" height="1" alt="spacer"></td>
	<td><img src="../images/spacer.gif" width="400" height="1" alt="spacer"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td class="nav" valign="middle" height="20"><a href="../index.php"><font color="#FFFFFF">Home</font></a> 
	  | </td>
  </tr>
  <tr> 
	<td><img src="../images/spacer.gif" width="600" height="1" alt="spacer"></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td width="160" height="260" valign="top" class="side">
	  <b><?php echo date("F j, Y"); ?></b><br>
	  <?$userid=$_COOKIE["userid"]+0;
		$logged_in+=0;
		
		if ($userid=="1") {
?>
	  <br>

	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="side">
		<tr> 
		  <td valign="middle" align="left" bgcolor="#CCCCCC"><b>User Managment</b></td>
		</tr>
		<tr> 
		  <td valign="middle" align="left" class="sideseparator" height="0"><img src="../images/spacer.gif" width="160" height="4" border="0" alt="spacer"></td>
		</tr>
		<tr> 
		  <td valign="top" align="left" bgcolor="#EEEEEE" height="1">
		  <!-- <a href="../calendar/index.php">Calendar</a> -->

			 <a class=mainmenu href="../user/user.php?userinfo=all">View users</a><br>
			 <a class=mainmenu href="../user/register.php">add user</a>
			  
			</td>
		</tr>
	  </table>
<br>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="side">
		<tr> 
		  <td valign="middle" align="left" bgcolor="#CCCCCC"><b>Database</b></td>
		</tr>
		<tr> 
		  <td valign="middle" align="left" class="sideseparator" height="0"><img src="../images/spacer.gif" width="160" height="4" border="0" alt="spacer"></td>
		</tr>
		<tr> 
		  <td valign="top" align="left" bgcolor="#EEEEEE" height="1">
		  <!-- <a href="../calendar/index.php">Calendar</a> -->

			 <a class=mainmenu href="/charts/trends_1.php">Manage Database</a>
			  
			</td>
		</tr>
	  </table>
	 <?} //if userid == "1" ?>
	  <br>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="side">
		<tr> 
		  <td valign="middle" align="left" bgcolor="#CCCCCC"><b>Reports</b></td>
		</tr>
		<tr> 
		  <td valign="middle" align="left" class="sideseparator" height="0"><img src="../images/spacer.gif" width="160" height="4" border="0" alt="spacer"></td>
		</tr>
		<tr> 
		  <td valign="top" align="left" bgcolor="#EEEEEE" height="1">
		  	<a class=mainmenu href="/admin/reports.php?report_id=1">State report</a><br>
			<a class=mainmenu href="/admin/reports.php?report_id=2">Dataset report</a><br>
			<a class=mainmenu href="/admin/reports.php?report_id=3">Variable Report</a><br>
			<a class=mainmenu href="/admin/reports.php?report_id=4">Download Report</a><br>
			
		  
		</tr>
	  </table>
	  <br>
	 	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="side">
		<tr> 
		  <td valign="middle" align="left" bgcolor="#CCCCCC"><b>Misc</b></td>
		</tr>
		<tr> 
		  <td valign="middle" align="left" class="sideseparator" height="0"><img src="../images/spacer.gif" width="160" height="4" border="0" alt="spacer"></td>
		</tr>
		<tr> 
		  <td valign="top" align="left" bgcolor="#EEEEEE" height="1">
		  <a class=mainmenu href="/">Live site</a><br>
			<?php   
//echo $logged_in;
if ($userid=="" && $logged_in == 0) {?>
			<a class=mainmenu href="../user/login.php">Log in</a><br>
			<!-- <a href="../user/register.php">Register</a><br> -->
			<?php 
} else  { ?>
	
			<a class=mainmenu href="../user/login.php?logout=1">Log out</a><br>
	<?php $result=$database->query("select first_name,last_name from users where userid=$userid");
	if ($database->num_rows($result) <> 0) {
		$first_name=$database->fetch_result($result,0,"first_name");
		$last_name=$database->fetch_result($result,0,"last_name");
		$loggedin="true";
	}?>
	<!--Welcome, <b>
	<?php echo $first_name?>
	<?php echo $last_name?>
	</b> <br>-->
	<?php if ($userid == "1") {?>
		<!--<a class=mainmenu href="../bugs/index.php">Report a Bug</a><br>
		<a class=mainmenu href="../user/myaccount.php">My Account</a><br> 
		<a class=mainmenu href="../user/editaccount.php?uid=<?php echo $userid ?>">Edit Account</a><br>
		<a class=mainmenu href="../user/email.php">Email Preferences</a><br> 
		<a class=mainmenu href="../admin/permissions.php">Permissions</a><br> 
		<a class=mainmenu href="../user/user.php?userinfo=all">Users</a><br> 
	--><?}?>
	<!--<a class=mainmenu href="../admin/reports.php">Reports</a><br>
	<a class=mainmenu href="../user/login.php?logout=1">Log out</a> <br>-->
<?php 
}?>
	  </td>
		</tr>
	  </table>
<br>
	</td>
	<td width="5" bgcolor="#FFFFFF" nowrap><img src="../images/spacer.gif" width="10" height="4" border="0" alt="spacer"></td>
	<td width="10000" valign="top" > <span class="mainheading">{heading}</span><br>
	  <br>
	  
	  <?php  
	  $pages=new page;
	  $pageinfo=$pages->get_page($_SERVER["PHP_SELF"]);
	  $permission=new permission;
	  $check=$permission->get_permission($userid,$pageinfo["itemid"]);
	  if ($check["admin"]<>"true") {?>
	  You don't have permission to view this page 
	  <?php   }else{?>
	  {content} 
	  <?php   }?>
	 </td>
  </tr>
  <tr> 
	<td height="1"><img height="1" width="160" src="../images/spacer.gif" alt="spacer"></td>
	<td height="1"><img height="1" width="5" src="../images/spacer.gif" alt="spacer"></td>
	<td height="1"><img height="1" width="435" src="../images/spacer.gif" alt="spacer"></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td width="100%" height="19" valign="middle" class="copyright">Copyright 2006</td>
  </tr>
  <tr> 
	<td><img src="../images/spacer.gif" width="600" height="1" alt="spacer"></td>
  </tr>
</table>
<?php   
$database->close();
?>
</body>
</html>

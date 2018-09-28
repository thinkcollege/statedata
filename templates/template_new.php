<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html>
<head>
<?php 
ini_set("include_path","/");
$database = Database::getDatabase();
$pages=new page;
$pages->add_page($_SERVER["PHP_SELF"]);
?>
<title>{title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL='stylesheet' TYPE='text/css' HREF='../common/styles.css'>
<script language="JavaScript" src="../common/rollovers.js"></script>
<script language="JavaScript" src="../common/common.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
	  <br>
	  
<?php   
$userid=$_COOKIE["userid"]+0;
?>
		 
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="side">
		<tr> 
		  <td valign="middle" align="left" bgcolor="#CCCCCC"><b>Content</b></td>
		</tr>
		<tr> 
		  <td valign="middle" align="left" class="sideseparator" height="0"><img src="../images/spacer.gif" width="160" height="4" border="0" alt="spacer"></td>
		</tr>
		<tr> 
		  <td valign="top" align="left" bgcolor="#EEEEEE" height="1">
		  <!-- <a href="../calendar/index.php">Calendar</a> -->

			 <a class=mainmenu href="../charts/trends_1.php">State Trend Data</a>
			  <br><a class=mainmenu href="../charts/comparison_1.php">State comparision data</a>
			  <br><a class=mainmenu href="../charts/individual_1.php">Individual data</a>
			  <br><a class=mainmenu href="../index.php">Download raw data</a>
			  
			</td>
		</tr>
	  </table>
	  <br>
	 
	  <br>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="side">
		<tr> 
		  <td valign="middle" align="left" bgcolor="#CCCCCC"><b>About this site</b></td>
		</tr>
		<tr> 
		  <td valign="middle" align="left" class="sideseparator" height="0"><img src="../images/spacer.gif" width="160" height="4" border="0" alt="spacer"></td>
		</tr>
		<tr> 
		  <td valign="top" align="left" bgcolor="#EEEEEE" height="1"> <a class=mainmenu href="../common/index.php">About 
			ICI</a> <br>
			<a class=mainmenu href="../common/support.php">Support ICI</a> <br>
			<a class=mainmenu href="../common/link.php">Link to ICI</a></td>
		</tr>
	  </table>
	 
	</td>
	<td width="5" bgcolor="#FFFFFF" nowrap><img src="../images/spacer.gif" width="10" height="4" border="0" alt="spacer"></td>
	<td width="10000" valign="top" > <span class="mainheading">{heading}</span><br>
	  <br>
	  
	  <?php  
	  $pages=new page;
	  $pageinfo=$pages->get_page($_SERVER["PHP_SELF"]);
	  $permission=new permission;
	  $check=$permission->get_permission($userid,$pageinfo["itemid"]);
	  if ($check["read"]=="false"){?>
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

<?php   
$database->close();
?>
</body>
</html>

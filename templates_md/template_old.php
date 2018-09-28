<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html>
<head>
<?php 
ini_set("include_path","../");
$database=new database;
$database->connect();
$pages=new page;
$pages->add_page($_SERVER["PHP_SELF"]);
?>
<title>{title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL='stylesheet' TYPE='text/css' HREF='../common/styles_md.css'>
<script language="JavaScript" src="../common/rollovers.js"></script>
<script language="JavaScript" src="../common/common.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height=100% border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><div id="sidebar">
			{sidebar}
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td ><img src="../images/spacer.gif" width="1" height="14" alt="" border="0"></td>
				</tr>
				<tr>
					<td class="sidebarContent"><a class=mainmenu href="../charts/trends_1.php">State trend data <img src="../images/arrow_<?if ($area == "trends") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="8" alt="" border="0"></a></td>
				</tr>
				<tr>
					<td background="../images/sidebarLine.gif"><img src="../images/spacer.gif" width="1" height="1" alt="" border="0"></td>
				</tr>
				<tr>
					<td class="sidebarContent"><a class=mainmenu href="../charts/comparison_1.php">State comparision data <img src="../images/arrow_<?if ($area == "comparison") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="7" alt="" border="0"></a></td>
				</tr>
				<tr>
					<td background="../images/sidebarLine.gif"><img src="../images/spacer.gif" width="1" height="1" alt="" border="0"></td>
				</tr>
				<tr>
					<td class="sidebarContent"><a class=mainmenu href="../charts/individual_1.php">Individual data <img src="../images/arrow_<?if ($area == "individual") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="7" alt="" border="0"></a></td>
				</tr>
				<tr>
					<td background="../images/sidebarLine.gif"><img src="../images/spacer.gif" width="1" height="1" alt="" border="0"></td>
				</tr>
				<tr>
					<td class="sidebarContent"><a class=mainmenu href="../index.php">Download raw data <img src="../images/arrow_<?if ($area == "download") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="7" alt="" border="0"></a></td>
				</tr>
				<tr>
					<td background="../images/sidebarLine.gif"><img src="../images/spacer.gif" width="1" height="1" alt="" border="0"></td>
				</tr>
			</table>
			<P>&nbsp;</p>
			</div>
			<div id="sidebarLogos">
			<table align=center>
				<tr>
					<td align=center><img src="../images/icigreendark.gif" width="72" height="72" alt="" border="0">
					<P><img src="../images/UMB_informal.gif" width="54" height="60" alt="" border="0">
					</td>
				</tr>
			</table>
			<table align=center>
				<tr>
					<td align=center>
					<P><br>This project is funded by:
			<P><a href="http://www.acf.hhs.gov/programs/add/" target="_new"><img src="http://216.71.91.226/statedatas/images/tinyadd.gif" width="80" height="108" alt="" border="0"></a>
		
			<p><a href="http://www.ed.gov/about/offices/list/osers/nidrr/index.html" target="_new"><img src="http://216.71.91.226/statedatas/images/nidrr.jpg" width="80" height="43" alt="" border="0"></a>
	
			<P><a href="http://www.dol.gov/odep/" target="_new"><img src="http://216.71.91.226/statedatas/images/odep_logo.jpg" width="65" height="70" alt="" border="0"></a>
					</td>
				</tr>
			</table>
			</div>
		<td><img src="../images/spacer.gif" width="1" height="1" alt="" border="0"></td>
		<td class="sidebarSeperator"><img src="../images/spacer.gif" width="1" height="1" alt="" border="0"></td>
		<td width=100% valign=top><div id=content>
		<span class="mainheading">{heading}</span><br>
		 <?php  
		 $userid=$_COOKIE["userid"]+0;
	  $pages=new page;
	  $pageinfo=$pages->get_page($_SERVER["PHP_SELF"]);
	  $permission=new permission;
	  $check=$permission->get_permission($userid,$pageinfo["itemid"]);
	  if ($check["read"]=="false"){?>
	  You don't have permission to view this page 
	  <?php   }else{?>
	  {content} 
	  <?php   }?>
		
		</div></td>
	</tr>
</table>

<?php   
$database->close();
?>


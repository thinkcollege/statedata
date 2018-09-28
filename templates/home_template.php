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
<LINK REL='stylesheet' TYPE='text/css' HREF='common/styles.css'>
<LINK REL='stylesheet' TYPE='text/css' HREF='common/side_menu.css'>
<script language="JavaScript" src="../common/rollovers.js"></script>
<script language="JavaScript" src="../common/common.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="skip"><a href="#side_menu">Skip to navigation and funders</a></div>
<div id="top">
<a href="http://www.communityinclusion.org/">
<img src="http://216.71.91.226/statedatas/images/banner.gif" alt="ICI: Institute for Community Inclusion"></a></div>

<div id="home_main">
<table width="774" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><img src="../images/spacer.gif" width="60" height="75" alt="" border="0"></td>
		<td valign=center width=135><span class="welcome">STATE AGENCY DATA PROFILES</span></td>
		<td valign=center>This website generates customized charts of state, national, and 
individual disability data. Accessible text versions are automatically 
created by the charting software. The site currently has data sets from 
vocational rehabilitation(RSA-911) andmental retardation/developmental 
disabilitiesagencies. New agencies and years will be added as they 
become available.

		</td>
	</tr>
</table>
<img src="../images/spacer.gif" width="1" height="20" alt="" border="0">
<table width="648" border="0" cellspacing="4" cellpadding="0">
	<tr>
		<td width=370><div class="SectionDiv">
				<table width=100% border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td class="sectionHeadBackground">STATE TREND</td>
					</tr>
					<tr>
						<td class="sectionIndent">Examine state progress in integrated employment, other day/employment 
services, funding levels, and Social Security benefits use.</td>
					</tr>
					<tr>
						<td class="sectionRightIndent" align=right><a class="sectionLink" href="charts/trends_1.php">Generate charts >></a></td>
					</tr>
				</table></div></td>
		<td ><div class="SectionDiv">
				<table width=100% border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td class="sectionHeadBackground">STATE COMPARISON</td>
					</tr>
					<tr>
						<td class="sectionIndent">Compare two to four states on their MR/DD outcomes. </td>
					</tr>
					<tr>
						<td class="sectionRightIndent" align=right><a class="sectionLink" href="charts/comparison_1.php">Generate charts >></a></td>
					</tr>

				</table></div></td>
	</tr>
	<tr>
		<td ><div class="SectionDiv">
				<table width=100% border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td class="sectionHeadBackground">INDIVIDUAL OUTCOMES</td>
					</tr>
					<tr>
						<td class="sectionIndent">View individual progress in the VR system on hours, earnings, and other 
variables. Data can be organized by factors such as demographics, 
education level, and benefit status.
</td>
					</tr>
					<tr>
						<td class="sectionRightIndent" align=right><a class="sectionLink" href="charts/individual_1.php">Generate charts  >></a></td>
					</tr>
				</table></div></td>
		<td ><div class="SectionDiv">
				<table width=100% border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td class="sectionHeadBackground">DOWNLOAD RAW DATA</td>
					</tr>
					<tr>
						<td class="sectionIndent">Complete data sets in Microsoft Excel allow users to conduct analysis 
on your own computer.</td>
					</tr>
					<tr>
						<td class="sectionRightIndent" align=right><a class="sectionLink" href="download/download_1.php">Go Explore Data >></a></td>
					</tr>
				</table></div></td>
	</tr>
</table>
<table width="648" border="0"  cellspacing="4" cellpadding="0">
	<tr>
		<td><img src="../images/spacer.gif" width="60" height="75" alt="" border="0"></td>

		<td valign=center>The state profiles project is part of the National Data Collection on 
Day and Employment Services for Individuals with Developmental 
Disabilities at the Institute for Community Inclusion/UMass Boston
<P align=center><a href="http://www.macromedia.com/go/getflashplayer/" target="_new"><img src="http://www.macromedia.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Macromedia Flash Player" border="0" /></a>

		</td>
	</tr>
</table>
</div> 
<div id="home_footer"><table width="100%" border="0" cellpadding="0" cellspacing="0">
<!--  <tr> 
	<td width="100%" height="19" valign="middle" class="copyright">Copyright 2004
	  <a href="mailto:melugardo@htomail.com"><font color="#FFFFFF">Community Inclusion</font></a></td>
  </tr>
  -->
  <tr> 
	<td width="100%" height="19" valign="middle" class="copyright">&nbsp;&nbsp;This project is funded by:</td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td>&nbsp;</td>
	<td><a href="http://www.acf.hhs.gov/programs/add/" target="_new"><img src="images/tinyadd.gif" width="80" height="108" alt="" border="0"></a></td>
	<td>&nbsp;</td>
	<td><a href="http://www.ed.gov/about/offices/list/osers/nidrr/index.html" target="_new"><img src="images/nidrr.jpg" width="80" height="43" alt="" border="0"></a></td>
	<!-- <td>&nbsp;</td>
	<td><a href="http://www.dol.gov/odep/" target="_new"><img src="images/odep_logo.jpg" width="65" height="70" alt="" border="0"></a></td> -->
  </tr>
  <tr> 
	<td colspan=6><img src="../images/spacer.gif" width="600" height="1" alt="spacer"></td>
  </tr>


</table>
</div>
<?php   
$database->close();
?>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-962830-8";
urchinTracker();
</script>
</body>
</html>

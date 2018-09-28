<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html>
<head>
<?php 
//ini_set("include_path","../");
$database = Database::getDatabase();
$pages=new page;
$pages->add_page($_SERVER["PHP_SELF"]);
?>
{sidebar}
<?php
if (!$file_path) {
	$file_path="../";
}
?>
<title>{title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL='stylesheet' TYPE='text/css' HREF='<?php echo $file_path ?>common/styles.css'>
<LINK REL='stylesheet' TYPE='text/css' HREF='<?php echo $file_path ?>common/side_menu.css'>
<script language="JavaScript" src="<?php echo $file_path ?>common/rollovers.js"></script>
<script language="JavaScript" src="<?php echo $file_path ?>common/common.js"></script>
<script language="JavaScript" src="<?php echo $file_path ?>common/functions.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<div id="skip"><a href="#side_menu">Skip to navigation and funders</a></div>
<div id=main>
	<h1>{heading}</h1>
	<?php  
	$userid=$_COOKIE["userid"]+0;
	$pages=new page;
	$pageinfo=$pages->get_page($_SERVER["PHP_SELF"]);
	$permission=new permission;
	if (!$pageinfo["itemid"]) {
		$pageinfo["itemid"] = 0;
	}
	$check=$permission->get_permission($userid,$pageinfo["itemid"]);
	if ($check["read"]=="false"){?>
	You don't have permission to view this page 
	<?php   }else{?>
	{content} 
	<?php   }?>

<?php if ($show_flash_link == 1) { ?>
<p style="color:dark-gray;"><span style="border-bottom: red dashed 1px;"><strong>Have data you want customized? Want help finding the data you need on this site?</span>
 <br /><a class="sectionLink" href="<?php echo $file_path ?>about/inquiry.php">Contact us to see what ICI can do for you >></a></p>
<p><blockquote style="border:gray 1px dashed; padding:1em;">If you are having difficulty using the site, please <a href="<?php echo $file_path ?>about/feedback.php">contact us</a>.</blockquote></p>
<div id="footer">
<br />
<p>
This is a project of the Institute for Community Inclusion at UMass Boston supported in part 
by the U.S. Department of Health and Human Services under cooperative agreement #90DN0126 with additional support from 
the National Institute on Disability and Rehabilitation Research of 
the U.S. Department of Education under grant #H133A021503. The opinions contained in this 
website are those of the grantee and do not necessarily reflect those of the funders.</p>
<br />
<p style="text-align:center;">
<!-- Creative Commons License -->
<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.0/"><img alt="Creative Commons License" border="0" src="http://creativecommons.org/images/public/somerights20.gif" /></a><br />
This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.0/">Creative Commons License</a>.
<!-- /Creative Commons License -->


<!--

<rdf:RDF xmlns="http://web.resource.org/cc/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
<Work rdf:about="">
   <license rdf:resource="http://creativecommons.org/licenses/by-nc-nd/2.0/" />
</Work>

<License rdf:about="http://creativecommons.org/licenses/by-nc-nd/2.0/">
   <permits rdf:resource="http://web.resource.org/cc/Reproduction" />
   <permits rdf:resource="http://web.resource.org/cc/Distribution" />
   <requires rdf:resource="http://web.resource.org/cc/Notice" />
   <requires rdf:resource="http://web.resource.org/cc/Attribution" />
   <prohibits rdf:resource="http://web.resource.org/cc/CommercialUse" />
</License>

</rdf:RDF>

-->
</p>
<?} ?>


</div>
</div> <!--end main div-->

<div id="top">
<table width="100%" >
	<tr>
		<td width="100%" class="bannertext"><br><h1>State Employment Outcomes System&nbsp;</h1></td>
		<td align=right width="100%"><!--<a href="http://statedata.info/"><img src="<?php echo $file_path ?>images/logo.gif" hspace=30 border=0></a>--></td>
	</tr>
</table></div>


<div id="side_menu">
<ul>
<li><a href="<?php echo $file_path ?>sample">Project Home <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "home") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="8" alt="" border="0"></a></li>
<li><a href="<?php echo $file_path ?>sample/charts/activity_1.php">Summary by Activity <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "activity") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="8" alt="" border="0"></a></li>
<li><a href="<?php echo $file_path ?>sample/charts/region_1.php">Summary by Region <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "region") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="8" alt="" border="0"></a></li>
<li><a href="<?php echo $file_path ?>sample/charts/provider_1.php">Provider Report <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "provider") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="8" alt="" border="0"></a></li><li><a href="<?php echo $file_path ?>sample/charts/provider_individual_1.php">Provider individual report <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "provider") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="8" alt="" border="0"></a></li>
<li><a href="<?php echo $file_path ?>sample/feedback.php">Feedback <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "Feedback") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="7" alt="" border="0"></a></li>
</ul>
<div id="funders" style="text-align:center; padding-top:1em;" >
<p>
<a href="http://communityinclusion.org/"><img src="/images/icigreendark.gif" width="72" height="72" alt=""  /></a></p>
<p>
<a href="http://statedata.info/"><img src="/images/logosmall.gif" width="200" height="146" alt="statedata.info"  /></a></p>
<p>
<a href="http://www.umb.edu"><img src="/images/UMB_informal.gif" width="54" height="60" alt="" /></a>
	
	<!--		<p><a href="http://www.dol.gov/odep/" target="_new"><img src="http://216.71.91.226/statedata/images/odep_logo.jpg" width="65" height="70" alt="" /></a></p> -->
					
</div><!--end funders div-->
</div><!--end sidemenu div-->




<?php   
$database->close();
?>


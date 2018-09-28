<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html>
<head>
<?php 
//ini_set("include_path","../");
$database=new database;
$database->connect();
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
<LINK REL='stylesheet' TYPE='text/css' HREF='<?php echo $file_path ?>common/styles_md.css'>
<LINK REL='stylesheet' TYPE='text/css' HREF='<?php echo $file_path ?>common/side_menu.css'>
<script language="JavaScript" src="<?php echo $file_path ?>common/rollovers.js"></script>
<script language="JavaScript" src="<?php echo $file_path ?>common/common.js"></script>
<script language="JavaScript" src="<?php echo $file_path ?>common/functions.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<div id="skip"><a href="#side_menu">Skip to navigation and funders</a></div>
<div id=main>
	<h1>{heading}</h1>
	{content}

<?php if ($show_flash_link == 1) { ?>
<p style="color:dark-gray;"><span style="border-bottom: red dashed 1px;"><strong>Have data you want customized? Want help finding the data you need on this site?</span>
 <br /><a class="sectionLink" href="<?php echo $file_path ?>about/inquiry.php">Contact us to see what ICI can do for you >></a></p>
<p><blockquote style="border:gray 1px dashed; padding:1em;">To fully experience StateData.info you should have a modern browser (Internet Explorer 5.0 and above, Netscape/Mozilla/Firefox), with the <a href="http://www.macromedia.com/go/getflashplayer/" target="_new">Macromedia Flash Player</a> installed and Javascript enabled. If you are having difficulty using the site, please <a href="<?php echo $file_path ?>about/feedback.php">contact us</a>.</blockquote></p>
<div id="footer">
<p>
The recommended citation for these charts and data is: Institute for Community Inclusion. (n.d.) <em>StateData.info</em>. Retrieved [today's 
date] from http://www.statedata.info.</p>
<br />
<p>
This is a project of the Institute for Community Inclusion at UMass Boston supported in part by the Administration on Developmental Disabilities, U.S. Department of Health and Human Services under cooperative agreement #90DN0126 with additional support from the National Institute on Disability and Rehabilitation Research of the U.S. Department of Education under grant #H133A021503. The opinions contained in this website are those of the grantee and do not necessarily reflect those of the funders.</p>
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
<a href="http://www.statedata.info/">
<img src="/images/banner.gif" alt="ICI: Institute for Community Inclusion"></a></div>


<div id="side_menu">
<ul>
<li><a href="<?php echo $file_path ?>">Project home <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "home") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="8" alt="" border="0"></a></li>
<li><a href="<?php echo $file_path ?>charts/trends_1.php">State trend data <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "trends") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="8" alt="" border="0"></a></li>
<li><a href="<?php echo $file_path ?>charts/comparison_1.php">State comparison data <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "comparison") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="7" alt="" border="0"></a></li>
<li><a href="<?php echo $file_path ?>charts/individual_1.php">Individual data <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "individual") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="7" alt="" border="0"></a></li>
<li><a href="<?php echo $file_path ?>download/download_1.php">Download raw data <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "download") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="7" alt="" border="0"></a></li>
<li><a href="<?php echo $file_path ?>datanotes/">Data Notes and publications <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "datanotes") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="7" alt="" border="0"></a></li>
<li><a href="<?php echo $file_path ?>about/about.php">About the project <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "about") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="7" alt="" border="0"></a></li>
<li><a href="<?php echo $file_path ?>about/data_sources.php">Data sources <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "data_sources") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="7" alt="" border="0"></a></li>
<li><a href="<?php echo $file_path ?>about/d_link.php">What is the "d" link? <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "D Link") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="7" alt="" border="0"></a></li>
<li><a href="<?php echo $file_path ?>about/feedback.php">Feedback <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "Feedback") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="7" alt="" border="0"></a></li>
<li><a href="<?php echo $file_path ?>about/inquiry.php">Consultation <img src="<?php echo $file_path ?>images/arrow_<?if ($area == "Consultation") { echo "on"; } else {echo "off";} ?>.gif" width="4" height="7" alt="" border="0"></a></li>
</ul>
<div id="funders" style="text-align:center; padding-top:1em;" >
<p>
<a href="http://communityinclusion.org/">
<img src="/images/icigreendark.gif" width="72" height="72" alt=""  /></a></p>
<p>
<a href="http://www.umb.edu">
<img src="/images/UMB_informal.gif" width="54" height="60" alt="" /></a>
<p>
This project is funded by:</p>
			<p><a href="http://www.acf.hhs.gov/programs/add/" target="_new"><img src="/images/tinyadd.gif" width="80" height="108" alt="" /></a></p>
		
			<p><a href="http://www.ed.gov/about/offices/list/osers/nidrr/index.html" target="_new"><img src="/images/nidrr.jpg" width="80" height="43" /></a>

	
	<!--		<p><a href="http://www.dol.gov/odep/" target="_new"><img src="http://216.71.91.226/statedata/images/odep_logo.jpg" width="65" height="70" alt="" /></a></p> -->
					
</div><!--end funders div-->
</div><!--end sidemenu div-->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-962830-8";
urchinTracker();
</script>



<?php   
$database->close();
?>


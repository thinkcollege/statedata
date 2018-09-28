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
<script language="JavaScript" src="<?php echo $file_path ?>common/prototype.js"></script>
</head>
<body  bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id=dmrMainPrint><div class="provider_heading">{heading}</div>


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
<div id="dmrfootersmall">
<!-- p style="text-align:center;" -->

<!-- Creative Commons License -->
<!--<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.0/"><img alt="Creative Commons License" border="0" src="http://creativecommons.org/images/public/somerights20.gif" /></a><br />
This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.0/">Creative Commons License</a>.
--><!-- /Creative Commons License -->


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
<!--</p>
<br />-->
<img src="../images/statedata.gif" width="169" height="46" alt="" border="0"> A project of the Institute for Community Inclusion, UMass Boston

</div>
</div> <!--end main div-->


<div id="dmrSmalltop"><nobr><h1>&nbsp;&nbsp;Massachusetts Department of Developmental Services&nbsp;</h1></nobr></div>

<?php   
$database->close();
?>


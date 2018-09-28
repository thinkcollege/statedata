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
<div id=mainPrint>
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

<div id="footer">
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
<br />
<p>
The recommended citation for these charts and data is: Institute for Community Inclusion. (n.d.). /StateData.info/. Retrieved [today's 
date] from http://www.statedata.info.</p>
<br />
<p>
<p>
This is a project of the Institute for Community Inclusion at UMass Boston supported in part 
by the U.S. Department of Health and Human Services under cooperative agreement #90DN0126 with additional support from 
the National Institute on Disability and Rehabilitation Research of 
the U.S. Department of Education under grant #H133A021503. The opinions contained in this 
website are those of the grantee and do not necessarily reflect those of the funders.</p> </p>


</div>
</div> <!--end main div-->


<div id="top">
<table width="100%" >
	<tr>
		<td class="bannertext" style="color:#FFFFFF"><nobr>State Employment Outcomes System&nbsp;</nobr>
<p><a class="printlink" href="javascript:window.close();">[close window]</a></td>
		<td align=right width="100%"><!-- <a href="http://statedata.info/"><img src="<?php echo $file_path ?>images/logo.gif" hspace=30 border=0></a>--></td>
	</tr>
</table>

</div>

<?php   
$database->close();
?>


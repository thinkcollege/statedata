<?php
ini_set("include_path","/");
include("common/classes.php");
$template=new template;
//$template->debug();
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Home');
$template->add_region('heading','Welcome to Cordury'); 
$template->add_region('sidebar','<?php 
									$area="" ;
									$show_flash_link=0;
									?>');
$template->add_region('content',' 
  <br>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr align="center" valign="top"> 
	<td width="80%"> 
	  <table width="100%" cellspacing="0" cellpadding="0" height="70">
		<tr align="left" valign="bottom"> 
		  <td width="50%" bgcolor="#EEEEEE" height="1"> <b>Welcome to mre_base</b><br>
			<img src="images/extras/gradual2.gif" width="100%" height="8"></td>
		</tr>
		<tr align="left" valign="top"> 
		  <td width="50%">This site is here for you to use and enjoy.<br>
			<ul>
			  <li><a href="charts/trends_1.php">State Trend Data</a></li>
			  <li><a href="charts/comparison_1.php">State comparision data</a></li>
			  <li><a href="charts/individual_1.php">Individual data</a></li>
			  <li><a href="about/link.php">Download raw data</a></li>
			</ul>
		  </td>
		</tr>
	  </table>
	</td>
	
  </tr>
</table>

<br>
'); 

//write page
//include("header.php");
$template->make_template(); 
//include("footer2.php");
?> 


<?php
//ini_set("include_path","./");
include("init.php");
include("common/classes.php");
$mre_base=new mre_base;

$title = $mre_base->mre_base_sitename . "- Institute for Community Inclusion"; 
$area="home" ;
$show_flash_link=1;
$file_path ="./";

include("header.php");
?>

  	<div id="home_main2">
		<h1>WELCOME</h1>
		
		               <h2>VIEW STATE TRENDS FOR EMPLOYMENT OF PEOPLE WITH DISABILITIES</h2>
		               <p>This module allows users to examine descriptive information on state characteristics, services, or outcomes using the data sets offered on the site.  <br />
		                   <a class="sectionLink"
		href="charts/trends_1.php">Generate state trends charts >></a></p>

		                   <h2>COMPARE STATES ON DISABILITY AND EMPLOYMENT OUTCOMES</h2>
		                   <p>Compare up to three states on any single descriptive or outcome variable in any of our state level data sets. Users may also choose to select a national total to benchmark their state or other states against the overall trend of what is happening nationally. Most data elements are available the national level. <br /> <a class="sectionLink"
		href="charts/comparison_1.php">Generate state comparison charts >></a></p>

		                   <h2>GENERATE INFORMATION FROM INDIVIDUAL LEVEL DISABILITY DATA SETS</h2>
		               <p>View trends in individual outcomes on hours, earnings, and employee benefits. Data queries allow the user to choose a combination of individual characteristics, including disability, age, gender, and level of education. This option currently includes the vocational rehabilitation and workforce development systems data.<br />
		<a class="sectionLink" href="charts/individual_1.php">Generate individual outcome charts >></a></p>

		               <h2>DOWNLOAD RAW DATA</h2>
		               <p>Complete state-level data sets that can be downloaded in Comma Separated Value (.csv) format so you can conduct your own analyses.<br />
		<a class="sectionLink" href="download/download_1.php">Download raw data >></a></p>
		<br />


	</div> 
<?php

//write page
include("footer.php");
?> 


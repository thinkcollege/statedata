<?php 
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Data Note - No. 6, 2006');
$template->add_region('sidebar','<?php 
									$area="datanotes" ;
									$show_flash_link=0;
									?>');
$template->add_region('heading','StateData.info: Data Note - No. 6, 2006');
$template->add_region('content','

<h2>WIA Employment Outcomes</h2>
<h3>Data set: WIA</h3>

<p><a href="dn6.pdf">Download this Data Note (pdf).</a></p>

<p>The Workforce Investment Act (WIA) requires One-Stop system partners who provide employment services funded by the U.S. Department of Labor to report data on performance measures. These data include the rate of customers entering employment, their employment retention rate, and their rate of earning a work credential. WIA tracks a number of funding streams for different audiences. This Data Note focuses on adults in the general population and dislocated workers (people who have either recently or will soon be laid off).</p>
<p></p>
<p>Results from five years of data collection show improvement in serving customers with disabilities for both funding streams. From program year (PY) 2000 to 2004, WIA program participants with disabilities showed net increases in entering employment, retaining employment, and earning a credential. Progress was particularly good for earning a credential, where success rates increased over 20% for each group. In most areas, One-Stops were more successful at serving dislocated workers with disabilities than their counterparts from the general population.</p>
<p></p>
<div class="callout">
<h3>Entered Employment Rate: </h3>
<p>Rate of entry into unsubsidized employment for adults who exit services during the quarter. </p>
<h3>Employment Retention Rate: </h3>
<p>Rate at which customers retain unsubsidized employment six months after entry. </p>
<h3>Credential Rate: </h3>
<p>Rate of attainment of a recognized credential relating to the achievement of educational skills by participants who enter unsubsidized employment. This may include attainment of a secondary school diploma or its recognized equivalent, or occupational skills.</p>
</div>
<p></p>
<table class="data" cellspacing="0" cellpadding="0">
	<caption>Percentage of Program Participants with Disabilities who Achieved Desired Outcomes</caption>
	<tr>
		<th id="" rowspan="2"></th>
		<th id="entered" colspan="2">Entered Employment (%)</th>
		<th id="retained" colspan="2">Retained Employment (%)</th>
		<th id="earned" colspan="2">Earned a Credential; (%)</th>
	</tr>
	<tr>
		<th id="gen">General pop.</th>
		<th id="dis">Dislocated</th>
		<th id="gen">General pop.</th>
		<th id="dis">Dislocated</th>
		<th id="gen">General pop.</th>
		<th id="dis">Dislocated</th>
	</tr>
	<tr>
		<th id="fy2000">PY2000</th>
		<td headers="fy2000 entered gen">60.5</td>
		<td headers="fy2000 entered dis">67.6</td>
		<td headers="fy2000 retained gen">76.6</td>
		<td headers="fy2000 retained dis">83.2</td>
		<td headers="fy2000 earned gen">37.0</td>
		<td headers="fy2000 earned dis">41.8</td>
	</tr>
	<tr>
		<th id="fy2001">PY2001</th>
		<td headers="fy2001 entered gen">67.4</td>
		<td headers="fy2001 entered dis">78.0</td>
		<td headers="fy2001 retained gen">78.5</td>
		<td headers="fy2001 retained dis">84.1</td>
		<td headers="fy2001 earned gen">49.7</td>
		<td headers="fy2001 earned dis">60.2</td>
	</tr>
	<tr>
		<th id="fy2002">PY2002</th>
		<td headers="fy2002 entered gen">66.1</td>
		<td headers="fy2002 entered dis">78.5</td>
		<td headers="fy2002 retained gen">78.6</td>
		<td headers="fy2002 retained dis">86.1</td>
		<td headers="fy2002 earned gen">54.5</td>
		<td headers="fy2002 earned dis">63.1</td>
	</tr>
	<tr>
		<th id="fy2003">PY2003</th>
		<td headers="fy2003 entered gen">69.5</td>
		<td headers="fy2003 entered dis">77.5</td>
		<td headers="fy2003 retained gen">82.3</td>
		<td headers="fy2003 retained dis">89.7</td>
		<td headers="fy2003 earned gen">55.6</td>
		<td headers="fy2003 earned dis">61.5</td>
	</tr>
	<tr>
		<th id="fy2004">PY2004</th>
		<td headers="fy2004 entered gen">70.3</td>
		<td headers="fy2004 entered dis">81.1</td>
		<td headers="fy2004 retained gen">83.6</td>
		<td headers="fy2004 retained dis">91.0</td>
		<td headers="fy2004 earned gen">57.9</td>
		<td headers="fy2004 earned dis">66.8</td>
	</tr>
</table>

<p>Source: WIA national summaries of performance data, program years 2000 through 2004 </p>
<p>This is a publication of StateData.info, funded in part by the Administration on Developmental Disabilities, U.S. Department of Health and Human Services (#90DN0204). This Data Note was written by Frank A. Smith.</p>
');
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>

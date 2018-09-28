<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$print = $_REQUEST["print"];
if ($print == 1) {
	$template->define_file('dmr_print_template.php');
} else {
	$print = 0;
	$template->define_file('dmr_template.php');
}
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Provider Report');
$template->add_region('heading','<?php 
				echo "Provider Report ";
				$year = $_REQUEST["year"];
				if ($year =="ALL") {
					echo " for all years";
				} else {
					echo " for 20$year";
				}
				?>
				');
if ($print == 1) {
	$template->add_region('sidebar','<?php 
									$area="provider" ;
									$show_flash_link=0;
									$file_path = "../../";
									?>');
} else {
	$template->add_region('sidebar','<?php 
									$area="provider" ;
									$show_flash_link=1;
									$file_path = "../../";
									?>');
}

$template->add_region('content','
	<?php
		$print = $_REQUEST["print"];
		if ($print != 1) {
			$print = 0;
		}
		
		$functions=new functions;
		$dmr=new dmr;
		$region = $_REQUEST["region"];
		$report = $_REQUEST["report"];
		$year = $_REQUEST["year"];

		$arProviders = $dmr->getProvidersArray ($region);
		$arColumnNames = $dmr->getRegionColumnNamesArray ($year);
		//$axis = $dmr->getRegionAxisLabel($variable);
		//$legend = $dmr->getRegionLegendName($variable);

		
		$colors = array();
		$colors[] = "9900CC"; //purple
		$colors[] = "FF9900"; //orange
		$colors[] = "993333"; //brown
		
		$database = Database::getDatabase();
		$colSpan = "5";
		if ($year =="ALL" || $year =="07" || $year =="08" || $year =="09")
		{
			$colSpan = "6";
		}		
		echo "<table border=1>\n";
		if ($report=="number") {
			
			echo "<tr><td rowspan=2>Provider</td>\n";
			echo "<td rowspan=2>Total Served <BR>(unduplicated count)</td>\n";
			if ($year !="ALL" && $year !="04" && $year !="05" && $year !="06") {
				echo "<td rowspan=2>Number entered a <BR>new individual job in the <BR>previous 12 months</td>\n";
			}
			echo "<td colspan=".$colSpan." align=center>Number Participating in activity</td>\n";
			echo "<td colspan=".$colSpan." align=center>Percent participating in activity</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td align=center>Individual Supported Job</td>\n";
			echo "<td align=center>Group Supported Job</td>\n";
			echo "<td align=center>Facility Based Work</td>\n";
			if ($year !="07" && $year !="08" && $year !="09")
			{
				echo "<td align=center>Volunteer<br>or Non-Work<br>Activity</td>\n";
			}
			else
			{
				echo "<td align=center>Volunteer<br>Work</td>\n";
			}
			echo "<td align=center>In Transition</td>\n";
			if ($year =="ALL" || $year =="07" || $year =="08" || $year =="09")
			{
				echo "<td align=center>Other<br>Non-Paid<br>Service</td>\n";
			}
			
			echo "<td align=center>Individual Supported Job</td>\n";
			echo "<td align=center>Group Supported Job</td>\n";
			echo "<td align=center>Facility Based Work</td>\n";
			if ($year !="07" && $year !="08" && $year !="09")
			{
				echo "<td align=center>Volunteer<br>or Non-Work<br>Activity</td>\n";
			}
			else
			{
				echo "<td align=center>Volunteer<br>Work</td>\n";
			}
			echo "<td align=center>In Transition</td>\n";
			if ($year =="ALL" || $year =="07" || $year =="08" || $year =="09")
			{
				echo "<td align=center>Other<br>Non-Paid<br>Service</td>\n";
			}
			echo "</tr>\n";
		} elseif ($report=="hours") {

			echo "<tr><td rowspan=2>Provider</td>\n";
			echo "<td rowspan=2>Total Served <BR>(unduplicated count)</td>\n";
			if ($year !="ALL" && $year !="04" && $year !="05" && $year !="06") {
				echo "<td rowspan=2>Number entered a <BR>new individual job in the <BR>previous 12 months</td>\n";
			}
			echo "<td colspan=".$colSpan." align=center>Mean hours per person participating in activity for month</td>\n";
			echo "<td colspan=".$colSpan." align=center>Percent of total hours in activity for month</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td align=center>Individual Supported Job</td>\n";
			echo "<td align=center>Group Supported Job</td>\n";
			echo "<td align=center>Facility Based Work</td>\n";
			if ($year !="07" && $year !="08" && $year !="09")
			{
				echo "<td align=center>Volunteer<br>or Non-Work<br>Activity</td>\n";
			}
			else
			{
				echo "<td align=center>Volunteer<br>Work</td>\n";
			}
			echo "<td align=center>In Transition</td>\n";
			if ($year =="ALL" || $year =="07" || $year =="08" || $year =="09")
			{
				echo "<td align=center>Other<br>Non-Paid<br>Service</td>\n";
			}
			echo "<td align=center>Individual Supported Job</td>\n";
			echo "<td align=center>Group Supported Job</td>\n";
			echo "<td align=center>Facility Based Work</td>\n";
			if ($year !="07" && $year !="08" && $year !="09")
			{
				echo "<td align=center>Volunteer<br>or Non-Work<br>Activity</td>\n";
			}
			else
			{
				echo "<td align=center>Volunteer<br>Work</td>\n";
			}
			echo "<td align=center>In Transition</td>\n";
			if ($year =="ALL" || $year =="07" || $year =="08" || $year =="09")
			{
				echo "<td align=center>Other<br>Non-Paid<br>Service</td>\n";
			}
			echo "</tr>\n";
		} elseif ($report=="wage") {

			echo "<tr><td rowspan=2>Provider</td>\n";
			echo "<td rowspan=2>Total Served <BR>(unduplicated count)</td>\n";
			if ($year !="ALL" && $year !="04" && $year !="05" && $year !="06") {
				echo "<td rowspan=2>Number entered a <BR>new individual job in the <BR>previous 12 months</td>\n";
			}
			echo "<td colspan=3 align=center>Mean monthly wage</td>\n";
			echo "<td colspan=3 align=center>Percent earning above minimum wage</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td align=center>Individual Supported Job</td>\n";
			echo "<td align=center>Group Supported Job</td>\n";
			echo "<td align=center>Facility Based Work</td>\n";
			
			echo "<td align=center>Individual Supported Job</td>\n";
			echo "<td align=center>Group Supported Job</td>\n";
			echo "<td align=center>Facility Based Work</td>\n";
			echo "</tr>\n";
		} 
		$yearParam = "none";
		if ($year !="ALL") {
			$yearParam = $year;
		} 
		for($j=0; $j<count($arProviders); $j++) {
			echo $dmr->getRowData($arProviders[$j], $report, $region, $yearParam);
		}
		echo "</table>\n";
	?>
        <br>
');
include("header.php");
$template->make_template(); 
include("footer.php");
?>

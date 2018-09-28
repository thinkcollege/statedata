<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$print = $_REQUEST["print"];
if ($print == 1) {
//	$template->define_file('dmr_print_template.php');
} else {
	$print = 0;
//	$template->define_file('dmr_template.php');
}
$template->define_file('dmr_print_template.php');
$template->add_region('title','Employment Supports Performance Outcome System Provider Report');
$template->add_region('heading','<?php
									$region = $_REQUEST["region"];
									$provider = $_REQUEST["provider"];
									$year = $_REQUEST["year"];
									echo "<i>Employment Supports Performance Outcome System Provider Report</i><br>$provider<br>20$year";
									?>');
if ($print == 1) {
	$template->add_region('sidebar','<?php 
									$area="providerindividual" ;
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
		$provider = $_REQUEST["provider"];
		$year = $_REQUEST["year"];
		
		//$arProviders = $dmr->getProvidersArray ($region);
		$arProviders = array();
		$arProviders[] = $provider;
		
		$arColumnNames = $dmr->getRegionColumnNamesArray ($variable);
		$axis = $dmr->getRegionAxisLabel($variable);
		$legend = $dmr->getRegionLegendName($variable);



		$report = array();
		$report[] = "number";
		$report[] = "hours";
		$report[] = "wage";
		
		$colors = array();
		$colors[] = "9900CC"; //purple
		$colors[] = "FF9900"; //orange
		$colors[] = "993333"; //brown
		
		$database = Database::getDatabase();
		for ($i = 0; $i < 3 ; $i++) {
			
			
			if ($report[$i]=="number") {
				echo "<P>&nbsp;<br><span class=\"mainheading\">Number Participating by Activity</span>";
				echo "<table border=1>\n";
				echo "<tr><td rowspan=2>Region</td>\n";
				echo "<td rowspan=2>Total Served <BR>(unduplicated count)</td>\n";
				echo "<td colspan=5 align=center>Number Participating in activity</td>\n";
				echo "<td colspan=5 align=center>Percent participating in activity</td>\n";
				echo "</tr>\n";
				echo "<tr>\n";
				echo "<td align=center>Individual Supported Job</td>\n";
				echo "<td align=center>Group Supported Job</td>\n";
				echo "<td align=center>Facility Based Work</td>\n";
				echo "<td align=center>Volunteer or Non-Work Activity</td>\n";
				echo "<td align=center>In Transition</td>\n";
				
				echo "<td align=center>Individual Supported Job</td>\n";
				echo "<td align=center>Group Supported Job</td>\n";
				echo "<td align=center>Facility Based Work</td>\n";
				echo "<td align=center>Volunteer or Non-Work Activity</td>\n";
				echo "<td align=center>In Transition</td>\n";
				echo "</tr>\n";
			} elseif ($report[$i]=="hours") {
				echo "<P>&nbsp;<br><span class=\"mainheading\">Hours of Participation by Activity</span>";
				echo "<table border=1>\n";
				echo "<tr><td rowspan=2>Region</td>\n";
				echo "<td rowspan=2>Total Served <BR>(unduplicated count)</td>\n";
				echo "<td colspan=5 align=center>Mean hours per person participating in activity for month</td>\n";
				echo "<td colspan=5 align=center>Percent of total hours in activity for month</td>\n";
				echo "</tr>\n";
				echo "<tr>\n";
				echo "<td align=center>Individual Supported Job</td>\n";
				echo "<td align=center>Group Supported Job</td>\n";
				echo "<td align=center>Facility Based Work</td>\n";
				echo "<td align=center>Volunteer or Non-Work Activity</td>\n";
				echo "<td align=center>In Transition</td>\n";
				
				echo "<td align=center>Individual Supported Job</td>\n";
				echo "<td align=center>Group Supported Job</td>\n";
				echo "<td align=center>Facility Based Work</td>\n";
				echo "<td align=center>Volunteer or Non-Work Activity</td>\n";
				echo "<td align=center>In Transition</td>\n";
				echo "</tr>\n";
			} elseif ($report[$i]=="wage") {
				echo "<P>&nbsp;<br><span class=\"mainheading\">Monthly Wages</span>";
				echo "<table border=1>\n";
				echo "<tr><td rowspan=2>Region</td>\n";
				echo "<td rowspan=2>Total Served <BR>(unduplicated count)</td>\n";
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
		
			if ($region == "ALL") {
				$arRegions = $dmr->getRegionArray($arProviders[0]);
				
			} else {
				$arRegions = array();
				$arRegions[0] = $region;
			}
			

			
			for($j=0; $j<count($arProviders); $j++) {

				for($k=0; $k<count($arRegions); $k++) {

					echo "p". $arProviders[$j] . "p re" . $report[$i] . "re r" . $arRegions[$k] . "r y" . $year ."y<BR>";
					if ($arRegions[$k] != ""){
						echo $dmr->getRowData($arProviders[$j], $report[$i], $arRegions[$k], $year, 1);
					}
				}
			}
			echo "</table>\n";
		
		}
	?>
');
include("header.php");
$template->make_template(); 
include("footer.php");
?>

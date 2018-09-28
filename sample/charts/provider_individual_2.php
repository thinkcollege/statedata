<?php
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$print = $_REQUEST["print"];
if ($print == 1) {
//	$template->define_file('sample_print_template.php');
} else {
	$print = 0;
//	$template->define_file('sample_template.php');
}
$template->define_file('sample_print_template.php');
$template->add_region('title','Employment Supports Performance Outcome System Provider Report');
$template->add_region('heading','<?php
									$region = $_REQUEST["region"];
									$provider = $_REQUEST["provider"];
									$year = $_REQUEST["year"];


									if (substr_count($region, "x_") > 0 ) {
										$sRegion = substr($region,2);
									} else {
										$sRegion = $region;
									}
									if ($sRegion == "ALL") {
										echo "<i>Employment Supports Performance Outcome System Provider Report<br>$provider<br>20$year for all regions</i>";
									} else {
										echo "<i>Employment Supports Performance Outcome System Provider Report<br>$provider<br>20$year for " . $sRegion ."</i>";
									}
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
		$sample=new sample;
		$region = $_REQUEST["region"];
		$provider = urldecode($_REQUEST["provider"]);
		$year = $_REQUEST["year"];

		//$arProviders = $sample->getProvidersArray ($region);
		$arProviders = array();
		$arProviders[] = $provider;

		$arColumnNames = $sample->getRegionColumnNamesArray ($variable);
		$axis = $sample->getRegionAxisLabel($variable);
		$legend = $sample->getRegionLegendName($variable);

		if ($region == "ALL") {
			$arRegions = $sample->getRegionArray($arProviders[0]);
		} else {
			$arRegions = array();
			$arRegions[0] = $region;
		}

		$sRegion = $region;


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
				echo "<P><span class=\"mainheading\">Number Participating by Activity</span>";
				echo "<table border=1 cellspacing=0 cellpadding=0 class=sampledata>\n";
				echo "<tr><td rowspan=2>&nbsp;</td>\n";
				echo "<td rowspan=2>Total Served <BR>(unduplicated count)</td>\n";
				echo "<td colspan=5 align=center>Number Participating in activity</td>\n";
				echo "<td colspan=5 align=center>Percent participating in activity</td>\n";
				echo "</tr>\n";
				echo "<tr>\n";
				echo "<td align=center>Individual<br>Supported<br>Job</td>\n";
				echo "<td align=center>Group<br>Supported<br>Job</td>\n";
				echo "<td align=center>Facility<br>Based<br>Work</td>\n";
				echo "<td align=center>Volunteer<br>or Non-Work<br>Activity</td>\n";
				echo "<td align=center>In<br>Transition</td>\n";

				echo "<td align=center>Individual<br>Supported<br>Job</td>\n";
				echo "<td align=center>Group<br>Supported<br>Job</td>\n";
				echo "<td align=center>Facility<br>Based<br>Work</td>\n";
				echo "<td align=center>Volunteer<br>or Non-Work<br>Activity</td>\n";
				echo "<td align=center>In<br>Transition</td>\n";
				echo "</tr>\n";
			} elseif ($report[$i]=="hours") {
				echo "<P><span class=\"mainheading\">Hours of Participation by Activity</span>";
				echo "<table border=1 cellspacing=0 cellpadding=0 class=sampledata>\n";
				echo "<tr><td rowspan=2>&nbsp;</td>\n";
				echo "<td rowspan=2>Total Served <BR>(unduplicated count)</td>\n";
				echo "<td colspan=5 align=center>Mean hours per person participating in activity for month</td>\n";
				echo "<td colspan=5 align=center>Percent of total hours in activity for month</td>\n";
				echo "</tr>\n";
				echo "<tr>\n";
				echo "<td align=center>Individual<br>Supported<br>Job</td>\n";
				echo "<td align=center>Group<br>Supported<br>Job</td>\n";
				echo "<td align=center>Facility<br>Based<br>Work</td>\n";
				echo "<td align=center>Volunteer<br>or Non-Work<br>Activity</td>\n";
				echo "<td align=center>In<br>Transition</td>\n";

				echo "<td align=center>Individual<br>Supported<br>Job</td>\n";
				echo "<td align=center>Group<br>Supported<br>Job</td>\n";
				echo "<td align=center>Facility<br>Based<br>Work</td>\n";
				echo "<td align=center>Volunteer<br>or Non-Work<br>Activity</td>\n";
				echo "<td align=center>In<br>Transition</td>\n";
				echo "</tr>\n";
			} elseif ($report[$i]=="wage") {
				echo "<P><span class=\"mainheading\">Monthly Wages</span>";
				echo "<table border=1 cellspacing=0 cellpadding=0 class=sampledata>\n";
				echo "<tr><td rowspan=2>&nbsp;</td>\n";
				echo "<td rowspan=2 align=center>Total Served <BR>(unduplicated count)</td>\n";
				echo "<td colspan=3 align=center>Mean monthly wage</td>\n";
				echo "<td colspan=3 align=center>Percent earning above minimum wage</td>\n";
				echo "</tr>\n";
				echo "<tr>\n";
				echo "<td align=center>Individual<br>Supported Job</td>\n";
				echo "<td align=center>Group<br>Supported Job</td>\n";
				echo "<td align=center>Facility Based<br>Work</td>\n";

				echo "<td align=center>Individual<br>Supported Job</td>\n";
				echo "<td align=center>Group<br>Supported Job</td>\n";
				echo "<td align=center>Facility Based<br>Work</td>\n";
				echo "</tr>\n";
			}


			for($j=0; $j<count($arProviders); $j++) {
				if ($region != "ALL") {
					for($k=0; $k<count($arRegions); $k++) {
						if ($arRegions[$k] != ""){
	echo "<!-- " . $arProviders[$j] .", " . $report[$i] . ", " . $arRegions[$k] . ", " . $year ." <BR>-->";
							if ($region != "ALL") {
								echo $sample->getRowData($arProviders[$j], $report[$i], $arRegions[$k], $year, 0); //for provider
							}
							echo $sample->getRowData("", $report[$i], $arRegions[$k], $year, 1); //for region
							if ($region != "ALL") {
								echo $sample->getRowData("", $report[$i], "", $year, 0); //for state
							}
						}
					}
				} else {
					echo $sample->getRowData($arProviders[$j], $report[$i], "", $year, 0); //for provider
					echo $sample->getRowData("", $report[$i], "", $year, 0); //for state
				}
			}

			echo "</table>\n";

		//echo "<span style=\'font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:Arial;";
		//echo "mso-fareast-font-family:\"Times New Roman\";mso-bidi-font-family:\"Times New Roman\"";
		//echo "mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA\'><br";
		//echo "clear=all style=\'page-break-before:always\'>";
		//echo "</span>";
		}
	?>
');
include("header.php");
$template->make_template();
include("footer.php");
?>

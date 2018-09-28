<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$print = $_REQUEST["print"];
if ($print == 1) {
	$template->define_file('sample_print_template.php');
} else {
	$print = 0;
	$template->define_file('sample_template.php');
}
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Provider Report');
$template->add_region('heading','Provider Report');
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
		$sample=new sample;
		$region = $_REQUEST["region"];
		$report = $_REQUEST["report"];


		$arProviders = $sample->getProvidersArray ($region);
		$arColumnNames = $sample->getRegionColumnNamesArray ($variable);
		$axis = $sample->getRegionAxisLabel($variable);
		$legend = $sample->getRegionLegendName($variable);

		
		$colors = array();
		$colors[] = "9900CC"; //purple
		$colors[] = "FF9900"; //orange
		$colors[] = "993333"; //brown
		
		$database = Database::getDatabase();
		
		echo "<table border=1>\n";
		if ($report=="number") {
			
			echo "<tr><td rowspan=2>Provider</td>\n";
			echo "<td rowspan=2>Total served <BR>(unduplicated count)</td>\n";
			echo "<td colspan=5 align=center>Number participating in activity</td>\n";
			echo "<td colspan=5 align=center>Percent participating in activity</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td align=center>Individual supported job</td>\n";
			echo "<td align=center>Group supported job</td>\n";
			echo "<td align=center>Facility-based work</td>\n";
			echo "<td align=center>Volunteer or non-work activity</td>\n";
			echo "<td align=center>In transition</td>\n";
			
			echo "<td align=center>Individual supported job</td>\n";
			echo "<td align=center>Group supported job</td>\n";
			echo "<td align=center>Facility-based work</td>\n";
			echo "<td align=center>Volunteer or non-work activity</td>\n";
			echo "<td align=center>In transition</td>\n";
			echo "</tr>\n";
		} elseif ($report=="hours") {

			echo "<tr><td rowspan=2>Provider</td>\n";
			echo "<td rowspan=2>Total served  <BR>(unduplicated count)</td>\n";
			echo "<td colspan=5 align=center>Mean hours per person in activity for month</td>\n";
			echo "<td colspan=5 align=center>Percent of total hours in activity for month</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td align=center>Individual supported job</td>\n";
			echo "<td align=center>Group supported job</td>\n";
			echo "<td align=center>Facility-based work</td>\n";
			echo "<td align=center>Volunteer or non-work activity</td>\n";
			echo "<td align=center>In transition</td>\n";
			
			echo "<td align=center>Individual supported job</td>\n";
			echo "<td align=center>Group supported job</td>\n";
			echo "<td align=center>Facility-based work</td>\n";
			echo "<td align=center>Volunteer or non-work activity</td>\n";
			echo "<td align=center>In transition</td>\n";
			echo "</tr>\n";
		} elseif ($report=="wage") {

			echo "<tr><td rowspan=2>Provider</td>\n";
			echo "<td rowspan=2>Total served <BR>(unduplicated count)</td>\n";
			echo "<td colspan=3 align=center>Mean monthly wage</td>\n";
			echo "<td colspan=3 align=center>Percent earning above minimum wage</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td align=center>Individual supported job</td>\n";
			echo "<td align=center>Group supported job</td>\n";
			echo "<td align=center>Facility-based work</td>\n";
			
			echo "<td align=center>Individual supported job</td>\n";
			echo "<td align=center>Group supported job</td>\n";
			echo "<td align=center>Facility-based work</td>\n";
			echo "</tr>\n";
		} 
		
		for($j=0; $j<count($arProviders); $j++) {
			echo $sample->getRowData($arProviders[$j], $report, $region);
		}
		echo "</table>\n";
	?>
        <br>
');
include("header.php");
$template->make_template(); 
include("footer.php");
?>

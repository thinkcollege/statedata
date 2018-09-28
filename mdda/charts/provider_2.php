<?php
ini_set("include_path","../../");
include("common/classes_md.php");
$template = new template;
$template->debug();
$print = !empty($_REQUEST["print"])  && strlen($_REQUEST["print"]) < 3 ? htmlentities($_REQUEST["print"]) : '';
$template->define_file($print ? 'mdda_print_template.php' : 'mdda_template.php');
$template->add_region('title', '<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Provider Report');

$report = isset($_REQUEST["report"]) ? $_REQUEST["report"] : '';
$f		= mdda::getFilterValues();
$cols	= mdda::getRegionColumnNamesArray($f['year']);
$colors = array("9900CC", "FF9900", "993333"); //purple, orange, brown
$rep_period = mdda::getReportingDates($f['year']);
$template->add_region('heading', "Provider Report: " . ($report == 'number' ?  "Numbers in Activity": ($report == 'hours' ? "Hours in Activity Over Two Weeks" : ($report == 'wage' ? "Wages Over Two Weeks by Activity" : "Paid Time Off") )) . (!$f['year'] ? " - for all years," : " - Reporting Period: " . $f['year']) . (!$f['region'] ? " - for all regions," : " - for {$f['region']} region,") . (!$f['areaOffice'] ? " all counties" : " county of  {$f['areaOffice']}") . (!$f['from'] ? "" : ", consumer ages from  {$f['from']} to {$f['to']}"));

$template->add_region('sidebar', '<?php $area = "provider"; $show_flash_link = ' . ($print + 0) . '; ?>');

$colspan = !$f['year'] || $f['year'] >= 2007 ? 6 : 5;
if((!$f['from'] && $f['to']) || ($f['from'] && !$f['to'])) { $html =  "<p style=\"font-size: 125%\"><a href=\"" . $_SERVER['HTTP_REFERER'] . "\">Go back and enter both 'To' and 'From' ages</a>.</p>";
$template->add_region('content', $html); } else {


   $html = '';

  $html .= '<form class="printbut clearfix" action="charts/provider_2.php" method="post"><input type="hidden" name="print" value="'. ($print ? '' : 1) .'" />     <input type="hidden" name="y" value="' . $f['year'] . '" /><input type="hidden" name="r" value="' . ($f['region'] ? $f['region'] : 'all') . '" /><input type="hidden" name="ao" value="' . ($f['areaOffice'] ? $f['areaOffice'] : 0) . '" /><input type="hidden" name="age[from]" value="' . $f['from'] . '" /><input type="hidden" name="age[to]" value="' . $f['to'] . '" /><input type="hidden" name="report" value="' . $report . '" /><input type="submit" name="submit" value="' .($print ? 'Back to normal version of page' : 'Click for print-friendly version'). '" /></form>';
 //    $html = "<a class=\"getfile\" style='display:block; height: 12px;' >Download spreadsheet of this data.</a>";
$html .= "<table id=\"tablehold\" class=\"sortable\" border=\"1\"><thead>";

if ($report == "number") {
	$html  .= "<tr><th rowspan=\"2\">Provider</th>"
	 		. "<th rowspan=\"2\">Total Served<br />(unduplicated count)</th>";



	$html  .= "<th colspan=\"8\" align=\"center\">Number participating by activity</th>"
			. "<th colspan=\"8\" align=\"center\">Percent participating by activity</th>"
			. "</tr><tr><th align=\"center\">Individual<br />competitive<br />job</th>"
			. "<th align=\"center\">Individual contracted job</th>"
			. "<th align=\"center\">Self<br />employment</th>"
			. "<th align=\"center\">Group<br />integrated<br />job</th>"

	 		. "<th align=\"center\">Facility based job</td>"

. "<th align=\"center\">Community<br />based<br />non work</th>"
. "<th align=\"center\">Volunteer<br />job</th>"
. "<th align=\"center\">Facility<br />based<br />non work</th>"

. "<th align=\"center\">Individual<br />competitive<br />job</th>"
			. "<th align=\"center\">Individual contracted job</th>"
			. "<th align=\"center\">Self<br />employment</th>"
			. "<th align=\"center\">Group<br />integrated<br />job</th>"

	 		. "<th align=\"center\">Facility based job</td>"

. "<th align=\"center\">Community<br />based<br />non work</th>"
. "<th align=\"center\">Volunteer<br />job</th>"
. "<th align=\"center\">Facility<br />based<br />non work</th>";

	$html .= "</tr>";
} elseif ($report == "hours") {
	$html  .= "<tr><th rowspan=\"2\">Provider</th><th rowspan=\"2\">Total Served <br />(unduplicated count)</th>";

	$html  .= "<th colspan=\"6\" align=\"center\">Mean hours of participation by activity</th>"
			. "<th colspan=\"6\" align=\"center\">Percent of total paid work hours</th>"
			. "</tr><tr><th align=\"center\">Individual<br />competitive<br />job</th>"
			. "<th align=\"center\">Individual contracted job</th>"
			. "<th align=\"center\">Self<br />employment</th>"
			. "<th align=\"center\">Group<br />integrated<br />job</th>"

			 . "<th align=\"center\">Facility based job</td>"
			 . "<th align=\"center\">Community based non work</td>"



. "<th align=\"center\">Individual<br />competitive<br />job</th>"
			. "<th align=\"center\">Individual contracted job</th>"
			. "<th align=\"center\">Self<br />employment</th>"
			. "<th align=\"center\">Group<br />integrated<br />job</th>"

			 . "<th align=\"center\">Facility based job</td>"		 
			 . "<th align=\"center\">Community based non work</td>";



	$html .= "</tr>";
} elseif ($report == "wage") {
	$html  .= "<tr><th rowspan=\"2\">Provider</th><th rowspan=\"2\">Total Served<br />(unduplicated count)</th>"

			. "<th colspan=\"4\" align=\"center\">Mean wage for reporting period</th>"
			. "<th colspan=\"4\" align=\"center\">Total wages for reporting period</th>"
			. "</tr><tr><th align=\"center\">Individual<br />competitive<br />job</th>"
			. "<th align=\"center\">Individual contracted job</th>"
			. "<th align=\"center\">Group<br />integrated<br />job</th>"


	 		. "<th align=\"center\">Facility based job</td>"

. "<th align=\"center\">Individual<br />competitive<br />job</th>"
			. "<th align=\"center\">Individual contracted job</th>"
			. "<th align=\"center\">Group<br />integrated<br />job</th>"


	 		. "<th align=\"center\">Facility based job</td>";

}
elseif ($report == "pto") {
	$html  .= "<tr><th rowspan=\"2\">Provider</th><th rowspan=\"2\">Total Served<br />(unduplicated count)</th>"

			. "<th colspan=\"4\" align=\"center\">Total receiving paid time off</th>"
			. "<th colspan=\"4\" align=\"center\">Percent receiving paid time off</th>"
			. "</tr><tr><th align=\"center\">Individual<br />competitive<br />job</th>"
			. "<th align=\"center\">Individual contracted job</th>"
			. "<th align=\"center\">Group<br />integrated<br />job</th>"


	 		. "<th align=\"center\">Facility based job</td>"

. "<th align=\"center\">Individual<br />competitive<br />job</th>"
			. "<th align=\"center\">Individual contracted job</th>"
			. "<th align=\"center\">Group<br />integrated<br />job</th>"

	 		. "<th align=\"center\">Facility based job</td>";

}
$html  .= "</thead><tbody>" . mdda::getRowData('provider', $report)
		. "</tbody></table><br /><script type=\"text/javascript\" src=\"../common/sorttable.js\"></script>";

$template->add_region('content', $html); }
include("header.php");
$template->make_template();
include("footer.php");

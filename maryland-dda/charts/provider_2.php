<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template = new template;
$template->debug();
$print = !empty($_REQUEST["print"])  && strlen($_REQUEST["print"]) < 3 ? htmlentities($_REQUEST["print"]) : '';
$template->define_file($print ? 'dds_print_template.php' : 'dds_template.php');
$template->add_region('title', '<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Provider Report');

$report = isset($_REQUEST["report"]) ? $_REQUEST["report"] : '';
$f		= dda::getFilterValues();
$cols	= dda::getRegionColumnNamesArray($f['year']);
$colors = array("9900CC", "FF9900", "993333"); //purple, orange, brown

$template->add_region('heading', "Provider Report " . ($f['year'] ? "for all years" : "for {$f['year']}"));
$template->add_region('sidebar', '<?php $area = "provider"; $show_flash_link = ' . ($print + 0) . '; ?>');

$colspan = !$f['year'] || $f['year'] >= 2007 ? 6 : 5;
$html = "<table class=\"sortable\" border=\"1\"><thead>";
//$html = '<pre>' . print_r($f, true) . "</pre><table class=\"sortable\" border=\"1\"><thead>";
if ($report == "number") {
	$html  .= "<tr><th rowspan=\"2\">Provider</th>"
	 		. "<th rowspan=\"2\">Total Served<br>(unduplicated count)</th>";
	if ($f['year'] > 2006) {
		$html .= "<th rowspan=\"2\">Number entered a <BR>new individual job in the <br />previous 12 months</th>";
	}
	$html  .= "<th colspan=\"$colspan\" align=\"center\">Number Participating in activity</th>"
			. "<th colspan=\"$colspan\" align=\"center\">Percent participating in activity</th>"
			. "</tr><tr><th align=\"center\">Individual Supported Job</th>"
			. "<th align=\"center\">Group Supported Job</th>"
			. "<th align=\"center\">Facility Based Work</th>"
			. "<th align=\"center\">Volunteer<br>" . ($f['year'] < 2007 ? "or Non-Work<br>Activity" : "Work") . "</th>"
	 		. "<th align=\"center\">In Transition</td>";
	if ($f['year'] == "ALL" || $f['year'] >= 2007) {
		$html .= "<th align=\"center\">Other<br>Non-Paid<br>Service</th>";
	}
	$html  .= "<th align=\"center\">Individual Supported Job</th>"
			. "<th align=\"center\">Group Supported Job</th>"
			. "<th align=\"center\">Facility Based Work</th>"
			. "<th align=center>Volunteer<br />" . ($f['year'] < 2007 ? 'or Non-Work<br />Activity' : 'Work') . "</th>"
			. "<th align=\"center\">In Transition</th>";
	if ($f['year'] == "ALL" || $f['year'] >= 2007) {
		$html .= "<th align=\"center\">Other<br>Non-Paid<br>Service</th>";
	}
	$html .= "</tr>";
} elseif ($report == "hours") {
	$html  .= "<tr><th rowspan=\"2\">Provider</th><th rowspan=\"2\">Total Served <br>(unduplicated count)</th>";
	if ($f['year'] != "ALL" && $f['year'] >= 2007) {
		$html .= "<th rowspan=\"2\">Number entered a<br>new individual job in the<br>previous 12 months</th>";
	}
	$html  .= "<th colspan=\"$colspan\" align=\"center\">Mean hours per person participating in activity for month</th>"
			. "<th colspan=\"$colspan\" align=\"center\">Percent of total hours in activity for month</th>"
	 		. "</tr><tr><th align=\"center\">Individual Supported Job</th>"
			. "<th align=\"center\">Group Supported Job</th><th align=\"center\">Facility Based Work</th>"
			. "<th align=\"center\">Volunteer<br>" . ($f['year'] < 2007 ? 'or Non-Work<br>Activity' : 'Work') . "</th>"
			. "<th align=\"center\">In Transition</th>";
	if ($f['year'] == "ALL" || $f['year'] >= 2007) {
		$html .= "<th align=\"center\">Other<br>Non-Paid<br>Service</th>";
	}
	$html  .= "<th align=\"center\">Individual Supported Job</th><th align=\"center\">Group Supported Job</th>"
			. "<th align=\"center\">Facility Based Work</th>"
			. "<th align=\"center\">Volunteer<br>" . ($f['year'] < 2007 ? 'or Non-Work<br>Activity' : 'Work') . "</th>"
			. "<th align=\"center\">In Transition</th>";
	if ($f['year'] == "ALL" || $f['year'] >= 2007) {
		$html .= "<th align=\"center\">Other<br>Non-Paid<br>Service</th>";
	}
	$html .= "</tr>";
} elseif ($report == "wage") {
	$html  .= "<tr><th rowspan=\"2\">Provider</th><th rowspan=\"2\">Total Served<br>(unduplicated count)</th>"
			. ($f['year'] !="ALL" && $f['year'] >= 2007
				? "<th rowspan=\"2\">Number entered a<br>new individual job in the<br>previous 12 months</th>" : '')
			. "<th colspan=\"3\" align=\"center\">Mean monthly wage</th>"
			. "<th colspan=\"3\" align=\"center\">Percent earning above minimum wage</th>"
			. "</tr><tr><th align=\"center\">Individual Supported Job</th>"
			. "<th align=\"center\">Group Supported Job</th><th align=\"center\">Facility Based Work</th>"
			. "<th align=\"center\">Individual Supported Job</th><th align=\"center\">Group Supported Job</th>"
			. "<th align=\"center\">Facility Based Work</th></tr>";
} 
$html  .= "</thead><tbody>" . dda::getRowData('provider', $report)
		. "</tbody></table><br><script type=\"text/javascript\" src=\"../common/sorttable.js\"></script>";

$template->add_region('content', $html);
include("header.php");
$template->make_template(); 
include("footer.php");
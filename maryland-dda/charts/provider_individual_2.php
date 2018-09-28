<?php
ini_set("include_path","../../");
include("common/classes_md.php");
$template = new template;
$template->debug();
$print = !empty($_REQUEST["print"])  && strlen($_REQUEST["print"]) < 3 ? htmlentities($_REQUEST["print"]) : '';
$template->define_file('dds_print_template.php');
$template->add_region('title','Employment Supports Performance Outcome System Provider Report');

$f			= dda::getFilterValues();
$sRegion	= strpos($f['region'], "x_") === 0 ? substr($f['region'], 2) : $f['region'];

$template->add_region('heading', "<em>Employment Supports Performance Outcome System Provider Report<br>"
	. dda::getProviderName($f['provider']) . "<br>{$f['year']} for "
	. (!$sRegion ? 'all regions' : $sRegion) . '</em>');
$template->add_region('sidebar', '<?php $area = "providerindividual"; $show_flash_link = ' . ($print + 0) . '; ?>');

$html		= '';
$providers	= array($f['provider']);
sort($providers);
//print "\n<!-- " . var_dump ($f) . "\n-->\n";
$regions	= !$f['region'] ? dda::getRegionArrayById($f['provider']) : array($f['region']);

$reports	= array("number", "hours", "wage");
$colSpan	= $f['year'] == "ALL" || $f['year'] >= 2007 ? 6 : 5;
foreach ($reports as $report) {
	if ($report == "number") {
		$html  .= '<p><span class="mainheading">Number Participating by Activity</span>'
				. '<table border="1" cellspacing="0" cellpadding="0" class="dmrdata">'
				. '<tr><td rowspan="2">&nbsp;</td>';
		//if (!$f['region'] || $f['region'] == 'all' || 1==1) {
		//	$html  .= '<td rowspan="2">Region</td>';
		//}
		$html  .= '<td rowspan="2">Total Served<BR>(unduplicated count)</td>'
				. ($f['year'] != "ALL" && $f['year'] >= 2007
					? '<td rowspan="2">Number entered<BR>a new individual job<BR>in the previous<BR>12 months</td>' : '')
				. "<td colspan=\"$colSpan\" align=\"center\">Number Participating in activity</td>"
				. "<td colspan=\"$colSpan\" align=\"center\">Percent participating in activity</td>"
				. '</tr><tr><td align="center">Individual<br>Supported<br>Job</td>'
				. '<td align="center">Group<br>Supported<br>Job</td><td align="center">Facility<br>Based<br>Work</td>'
				. '<td align="center">Volunteer<br>' . ($f['year'] < 2007 ? 'or Non-Work<br>Activity' : 'Work')
				. '</td><td align="center"">In<br>Transition</td>'
				. ($f['year'] == "ALL" || $f['year'] >= 2007
					? '<td align="center">Other<br>Non-Paid<br>Service</td>' : '')
				. '<td align="center">Individual<br>Supported<br>Job</td>'
				. '<td align="center">Group<br>Supported<br>Job</td><td align="center">Facility<br>Based<br>Work</td>'
				. '<td align="center">Volunteer<br>' . ($f['year'] < 2007 ? 'or Non-Work<br>Activity' : 'Work')
				. '</td><td align="center">In<br>Transition</td>'
				. ($f['year'] == "ALL" || $f['year'] >= 2007 ? '<td align="center">Other<br>Non-Paid<br>Service</td>' : '')
				. "</tr>";
	} elseif ($report == "hours") {
		$html  .= '<p><span class="mainheading">Hours of Participation by Activity</span></p>'
				. '<table border="1" cellspacing="0" cellpadding="0" class="dmrdata">'
				. '<tr><td rowspan="2">&nbsp;</td>';
		//if (!$f['region'] || $f['region'] == 'all' || 1==1) {
		//	$html  .= '<td rowspan="2">Region</td>';
		//}
		$html  .= '<td rowspan="2">Total Served<BR>(unduplicated count)</td>'
				. ($f['year'] !="ALL" && $f['year'] >= 2007
					? '<td rowspan="2">Number entered<BR>a new individual job<BR>in the previous<BR>12 months</td>' : '')
				. "<td colspan=\"$colSpan\" align=\"center\">Mean hours per person participating in activity for month</td>"
				. "<td colspan=\"$colSpan\" align=\"center\">Percent of total hours in activity for month</td>"
				. '</tr><tr><td align="center">Individual<br>Supported<br>Job</td>'
				. '<td align="center">Group<br>Supported<br>Job</td>'
				. '<td align="center">Facility<br>Based<br>Work</td>'
				. '<td align="center">Volunteer<br>' . ($f['year'] < 2007 ? 'or Non-Work<br>Activity' : 'Work')
				. '</td><td align="center"">In<br>Transition</td>'
				. ($f['year'] == "ALL" || $f['year'] >= 2007
					? '<td align="center">Other<br>Non-Paid<br>Service</td>' : '')
				. '<td align="center">Individual<br>Supported<br>Job</td><td align="center">Group<br>Supported<br>Job</td>'
				. '<td align="center">Facility<br>Based<br>Work</td>'
				. '<td align="center">Volunteer<br>' . ($f['year'] < 2007 ? 'or Non-Work<br>Activity' : 'Work')
				. '</td><td align="center">In<br>Transition</td>'
				. ($f['year'] == "ALL" || $f['year'] >= 2007
					? '<td align="center">Other<br>Non-Paid<br>Service</td>' : '')
				. "</tr>";
	} elseif ($report == "wage") {
		$html  .= '<p><span class="mainheading">Monthly Wages</span></p>'
				. '<table border="1" cellspacing="0" cellpadding="0" class="dmrdata">'
				. '<tr><td rowspan="2">&nbsp;</td>';
		//if (!$f['region'] || $f['region'] == 'all' || 1==1) {
		//	$html  .= '<td rowspan="2">Region</td>';
		//}
		$html  .= '<td rowspan="2" align="center">Total Served <BR>(unduplicated count)</td>'
				. ($f['year'] != "ALL" && $f['year'] >= 2007
					? '<td rowspan="2">Number entered<br>a new individual job<br>in the previous<BR>12 months</td>' : '')
				. '<td colspan="3" align="center">Mean monthly wage</td><td colspan="3" align="center">Percent earning above minimum wage</td>'
				. '</tr><tr><td align="center">Individual<br>Supported Job</td>'
				. '<td align="center">Group<br>Supported Job</td><td align="center">Facility Based<br>Work</td>'
				. '<td align="center">Individual<br>Supported Job</td><td align="center">Group<br>Supported Job</td>'
				. '<td align="center">Facility Based<br>Work</td></tr>';
	}

	//foreach ($providers as $provider) {
		$html  .= dda::getRowData('individual', $report);
	//}
	$html .= "</table>\n";
}

$template->add_region('content', $html);
include("header.php");

$template->make_template();
include("footer.php");
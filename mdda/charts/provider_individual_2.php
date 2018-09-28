<?php
ini_set("include_path","../../");
include("common/classes_md.php");
$template = new template;
$template->debug();
$print = !empty($_REQUEST["print"])  && strlen($_REQUEST["print"]) < 3 ? htmlentities($_REQUEST["print"]) : '';
$template->define_file($print ? 'mdda_print_template.php' : 'mdda_template.php');
$template->add_region('title', '<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Provider Individual Report');

$f			= mdda::getFilterValues();

$sRegion	=  $f['region'];
 $sFrom = $f['from'] ? $f['from'] : '';
$sTo = $f['to'] ? $f['to'] : '';
$template->add_region('heading',  "Provider Individual Report: " . mdda::getProviderName($f['provider']) . " Reporting Period: ". mdda::getReportingDates($f['year']) . " for "
	. (!$sRegion || $sRegion == 'all' ? 'all regions' : $sRegion) . ($sFrom != '' ? ".&nbsp;&nbsp;Ages $sFrom to $sTo." : "") . '</em>');
$template->add_region('sidebar', '<?php $area = "providerindividual"; $show_flash_link = ' . ($print + 0) . '; ?>');

$html		= '';

$providers	= array($f['provider']);
sort($providers);
//print "\n<!-- " . var_dump ($f) . "\n-->\n";
$regions	= !$f['region'] ? mdda::getRegionArrayById($f['provider']) : array($f['region']);
$reports	= array("number", "hours", "wage","pto");
$colSpan	 = 8;
$html .= '<form class="printbut clearfix" action="charts/provider_individual_2.php" method="post"><input type="hidden" name="print" value="'. ($print ? '' : 1) .'" />     <input type="hidden" name="y" value="' . $f['year'] . '" /><input type="hidden" name="r" value="' . ($f['region'] ? $f['region'] : 'all') . '" /><input type="hidden" name="p" value="' . ($f['provider'] ? $f['provider'] : 'all') . '" /><input type="hidden" name="f" value="' . $f['from'] . '" /><input type="hidden" name="t" value="' . $f['to'] . '" /><input type="submit" name="submit" value="' .($print ? 'Back to site' : 'Click for print-friendly version'). '" /></form>';
foreach ($reports as $report) {
	if ($report == "number") {
		$html  .= '<p><span class="mainheading">Number Participating by Activity over Two Week Reporting Period</span>'
				. '<table border="1" cellspacing="0" cellpadding="0" class="dmrdata">'
				. '<tr><td rowspan="2">&nbsp;</td>';
		//if (!$f['region'] || $f['region'] == 'all' || 1==1) {
		//	$html  .= '<td rowspan="2">Region</td>';
		//}
		$html  .= '<td rowspan="2">Total Served<BR>(unduplicated count)</td>'
				. "<td colspan=\"$colSpan\" align=\"center\">Number Participating in activity</td>"
				. "<td colspan=\"$colSpan\" align=\"center\">Percent participating in activity</td>"
				. '</tr><tr><td align="center">Individual<br />competitive<br />job</td><td align="center">Individual<br />contracted<br />job</td><td align="center">Self<br />employment</td>'
				. '<td align="center">Group<br />integrated<br />job</td><td align="center">Facility<br />based<br />job</td>'
				. '<td align="center">Community<br />based<br />non work'
				. '<td align="center">Volunteer<br />job'
				. '</td><td align="center"">Facility<br />based<br />non work</td>'

				. '<td align="center">Individual<br />competitive<br />Job</td><td align="center">Individual<br />contracted<br />job</td><td align="center">Self<br />employment</td>'

				. '<td align="center">Group<br />integrated<br />job</td><td align="center">Facility<br />based<br />job</td>'
				. '<td align="center">Community<br />based<br />non work'
				. '<td align="center">Volunteer<br />job'
				. '</td><td align="center"">Facility<br />based<br />non work</td>'

				. "</tr>";
	} elseif ($report == "hours") { $colSpan = '6';
		$html  .= '<p><span class="mainheading">Hours of Participation by Activity over Two Week Reporting Period</span></p>'
				. '<table border="1" cellspacing="0" cellpadding="0" class="dmrdata">'
				. '<tr><td rowspan="2">&nbsp;</td>';
		//if (!$f['region'] || $f['region'] == 'all' || 1==1) {
		//	$html  .= '<td rowspan="2">Region</td>';
		//}
		$html  .= '<td rowspan="2">Total Served<BR>(unduplicated count)</td>'

				. "<td colspan=\"$colSpan\" align=\"center\">Mean Hours per person</td>"
				. "<td colspan=\"$colSpan\" align=\"center\">Percent of total paid work hours</td>"
				. '</tr><tr><td align="center">Individual<br />competitive<br />Job</td>'
				. '<td align="center">Individual<br />contracted<br />job</td>'
           . '<td align="center">Self<br />employment</td>'
            	. '<td align="center">Group<br />integrated<br />job</td>'
			   . '<td align="center">Facility<br />based<br />job</td>'
			   
				. '</td><td align="center"">Community<br />based<br />non work</td>'



				. '<td align="center">Individual<br />competitive<br />Job</td>'
				. '<td align="center">Individual<br />contracted<br />job</td>'
           . '<td align="center">Self<br />employment</td>'
            	. '<td align="center">Group<br />integrated<br />job</td>'
               . '<td align="center">Facility<br />based<br />job</td>'
			   . '</td><td align="center"">Community<br />based<br />non work</td>'

				. "</tr>";
	} elseif ($report == "wage") {
		$html  .= '<p><span class="mainheading">Wages by Activity over Two Week Reporting Period</span></p>'
				. '<table border="1" cellspacing="0" cellpadding="0" class="dmrdata">'
				. '<tr><td rowspan="2">&nbsp;</td>';
		//if (!$f['region'] || $f['region'] == 'all' || 1==1) {
		//	$html  .= '<td rowspan="2">Region</td>';
		//}
		$html  .= '<td rowspan="2" align="center">Total Served <BR>(unduplicated count)</td>'

				. '<td colspan="4" align="center">Mean wages earned</td><td colspan="4" align="center">Total wages earned</td>'
				. '</tr><td align="center">Individual<br />competitive<br />Job</td>'
				. '<td align="center">Individual<br />contracted<br />job</td>'

            	. '<td align="center">Group<br />integrated<br />job</td>'
               . '<td align="center">Facility<br />based<br />job</td>'

				. '<td align="center">Individual<br />competitive<br />Job</td>'
				. '<td align="center">Individual<br />contracted<br />job</td>'

            	. '<td align="center">Group<br />integrated<br />job</td>'
               . '<td align="center">Facility<br />based<br />job</td>
            </tr>';
	}
   elseif ($report == "pto") {
   		$html  .= '<p><span class="mainheading">Paid Time Off by Activity</span></p>'
   				. '<table border="1" cellspacing="0" cellpadding="0" class="dmrdata">'
   				. '<tr><td rowspan="2">&nbsp;</td>';
   		//if (!$f['region'] || $f['region'] == 'all' || 1==1) {
   		//	$html  .= '<td rowspan="2">Region</td>';
   		//}
   		$html  .= '<td rowspan="2">Total Served<BR>(unduplicated count)</td>'

			. '<td colspan="4" align="center">Number who received paid time off</td><td colspan="4" align="center">Percent who received paid time off</td>'
			. '</tr><td align="center">Individual<br />competitive<br />Job</td>'
			. '<td align="center">Individual<br />contracted<br />job</td>'

         	. '<td align="center">Group<br />integrated<br />job</td>'
            . '<td align="center">Facility<br />based<br />job</td>'

			. '<td align="center">Individual<br />competitive<br />Job</td>'
			. '<td align="center">Individual<br />contracted<br />job</td>'

         	. '<td align="center">Group<br />integrated<br />job</td>'
            . '<td align="center">Facility<br />based<br />job</td>'

   				. "</tr>";
   	}

	//foreach ($providers as $provider) {
		$html  .= mdda::getRowData('individual', $report);
	//}
	$html .= "</table>\n";
}

$template->add_region('content', $html);
include("header.php");

$template->make_template();
include("footer.php");

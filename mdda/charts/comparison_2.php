<?php 
ini_set("include_path","../../");
include("common/classes_md.php");
$print = !empty($_REQUEST["print"])  && strlen($_REQUEST["print"]) < 3 ? htmlentities($_REQUEST["print"]) : '';

$template = new template;
$template->define_file($print ? 'mdda_print_template.php' : 'mdda_template.php');
$template->add_region('title', '<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Provider Comparison');
$template->add_region('heading', 'Provider Comparison');
$template->add_region('sidebar','<?php $area = "comparison"; $show_flash_link = ' . ($print + 0) . '; ?>');
$var	= isset($_REQUEST["var"]) && strlen($_REQUEST["var"]) < 40 ? htmlentities($_REQUEST['var']) : '';
$f		= mdda::getFilterValues();
$values	= mdda::getProviderComparisonArray($var);
$cats	= implode(';', array_keys($values)) . ';';
$data	= implode(';', $values) . ';';
$axis	= mdda::getRegionAxisLabel($var);
$legend	= mdda::getRegionLegendName($var, $year);
$colors = array("9900CC", "FF9900", "993333"); //purple, orange, brown
$pcScript	= "graph.setcategories($cats)\ngraph.setseries((CLR_{$colors[0]})'$legend';$data)\n"
 			. "main.AddPCXML(<Textbox Name='title' Top='0' Left='0' Width='1024' Height='24'><Properties AutoWidth='False' HJustification='Center' LeftMargin='5' RightMargin='5' FillColor='#BACBDB' Font='Size:12; Color:#5C656A;' />\n"
			. "<Text>$legend</Text></Textbox>)\n"
			. "main.AddPCXML(<Textbox Name='axis1' Top='120' Left='10' Width='75' Height='70'>\n"
			. "<Properties BorderType='None' AutoWidth='True' HJustification='Center' LeftMargin='5' RightMargin='5' FillColor='#ffffff' Font='Size:10; Style:Bold ; Color:black;' />\n"
			. "<Text>$axis</Text></Textbox>)\n"
			. "graph.AddPCXML(<CategoryScale LimitLabelLength='False' MaxLengthRotatedText='0' StaggerLabels='False' RotateLabels='0' LowOuterLine='Color:#7f7f7f;' HighOuterLine='Color:#7f7f7f;' MajorTick='Visible:False;' MinorTick='Size:Large;' MajorGrid='Color:#7f7f7f;' Font='Size:10; Color:#3366ff;' MinorFont='Size:10;' />)\n";
$mychart = new chart;
$mychart->externalServerAddress = "http://www.communityinclusion.org:8080";
$mychart->internalCommPortAddress = "http://www.communityinclusion.org:8081";
$mychart->appearanceFile = "apfiles/dds_comparison.pcxml";
$mychart->width = 800;
$mychart->height = 1024;
$mychart->userAgent = $_SERVER['HTTP_USER_AGENT'];
$mychart->returnDescriptiveLink = true;
$mychart->language = "EN";
$mychart->pcScript = $pcScript;
$mychart->imageType = "JPG";
$mid = floor(strlen($legend) / 2);
$pos1 = strrpos($legend, ' ', -$mid);
$pos2 = strpos($legend, ' ', $mid);
$pos = ($mid - $pos1) < ($pos2 - $mid) ? $pos1 : $pos2;
$legend = substr($legend, 0, $pos) . '<br>' . substr($legend, $pos + 1);
$html	= $mychart->getEmbeddingHTML()
		. "<p>mid:$mid pos1:$pos1 pos2:$pos2 pos:$pos</p>"
		. '<table class="sortable" border="1" cellspacing="0" cellpadding="1"><thead><tr><th>Provider</th><th>'
		. $legend . '</th></tr></thead><tbody>';
foreach ($values as $provider => $val) {
	$html .= "<tr><td>$provider</td><td>$val</td></tr>";
}
$html .= "</tbody></table>";	
if (!$print) {
	$html .= "<br><a target='_new' href='region_2.php?print=1&year=$year&variable=$var'>Printer-Friendly Format</a>";
}
$template->add_region('content', $html);
include("header.php");
$template->make_template(); 
include("footer.php");
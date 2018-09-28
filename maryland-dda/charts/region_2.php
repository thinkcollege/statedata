<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template = new template;
$template->debug();
$print = !empty($_REQUEST["print"]);
$template->define_file($print ? 'dds_print_template.php' : 'dds_template.php');
$template->add_region('title', '<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Summary by REgion');
$template->add_region('heading', 'Summary by Region');
$template->add_region('sidebar', '<?php $area = "region"; $show_flash_link = ' . ($print + 0) . '; ?>');

$var	= isset($_REQUEST["var"]) ? $_REQUEST["var"] : '';
$f		= dda::getFilterValues();
$values	= implode(';', dda::getRegionVariableArray($var, $f['year']));
$cats	= preg_replace('/(^|;)x_/i', '\\1', implode(';', dda::getRegionColumnNamesArray($f['year'])));
$axis	= dda::getRegionAxisLabel($var);
$legend	= dda::getRegionLegendName($var, $f['year']);
$colors = array("9900CC", "FF9900", "993333"); //purple, orange, brown
$pcScript	= "graph.setcategories($cats)\n"
			. "graph.setseries((CLR_{$colors[0]})'$legend';$values)\n"
 			. "main.AddPCXML(<Textbox Name='title' Top='0' Left='0' Width='615' Height='24'><Properties AutoWidth='False' HJustification='Center' LeftMargin='5' RightMargin='5' FillColor='#BACBDB' Font='Size:14; Style:Bold Italic; Color:#5C656A;' />\n"
			. "<Text>$legend</Text></Textbox>)\n"
			. "main.AddPCXML(<Textbox Name='axis1' Top='120' Left='10' Width='75' Height='70'>\n"
			. "<Properties BorderType='None' AutoWidth='True' HJustification='Center' LeftMargin='5' RightMargin='5' FillColor='#ffffff' Font='Size:10; Style:Bold ; Color:black;' />\n"
			. "<Text>$axis</Text></Textbox>)\n"
			. "graph.AddPCXML(<CategoryScale LimitLabelLength='False' MaxLengthRotatedText='10' StaggerLabels='False' RotateLabels='-45' LowOuterLine='Color:#7f7f7f;'  HighOuterLine='Color:#7f7f7f;' MajorTick='Visible:False;' MinorTick='Size:Large;' MajorGrid='Color:#7f7f7f;' Font='Size:12; Style:Bold Italic; Color:#3366ff;' MinorFont='Size:10;' />)\n";
$mychart = new chart;
$mychart->externalServerAddress = "http://www.communityinclusion.org:8080";
$mychart->internalCommPortAddress = "http://www.communityinclusion.org:8081";
$mychart->appearanceFile = "apfiles/dmr_activity.pcxml";
$mychart->width = 616;
$mychart->height = 430;
$mychart->userAgent = $_SERVER['HTTP_USER_AGENT'];
$mychart->returnDescriptiveLink = true;
$mychart->language = "EN";
$mychart->pcScript = $pcScript;
$mychart->imageType = "JPG";

switch ($var[0]) {
	case 'N': $th = 'Number';	break;
	case 'P': $th = 'Percent';	break;
	case 'A': $th = 'Average';	break;
	case 'M': $th = 'Mean';		break;
}
$html	= $mychart->getEmbeddingHTML()
		. '<table border="1" cellspacing="0" cellpadding="3"><caption>'	. $legend
		.'</caption<thead><tr><th sope="row">Region</th><th>' . str_replace(';', '</th><th>', $cats)
		. '</th></tr></thead><tbody><tr><th scope="row">' . $th . '</th><td>'
		. str_replace(';', '</td><td>', $values) . '</td></tr></tbody></table>';
if (!$print) {
	$html .= "<br><a target=\"_new\" href=\"region_2.php?print=1&amp;variable=$var&amp;" . dda::serializeFilters() . "\">Printer-Friendly Format</a>";
}
$template->add_region('content', $html);
include("header.php");
$template->make_template(); 
include("footer.php");
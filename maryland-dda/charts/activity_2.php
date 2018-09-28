<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template = new template;
$template->debug();
$print = !empty($_REQUEST["print"]);

$template->define_file($print ? 'dds_print_template.php' : 'dds_template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Summary by Activity');
$template->add_region('heading', 'Summary by Activity');
$template->add_region("sidebar", "<?php \$area = \"activity\"; \$show_flash_link = " . ($print + 0) . "; ?>");

$variable 	= isset($_REQUEST["variable"]) ? $_REQUEST['variable'] : '';
$f			= dda::getFilterValues();
if (empty($variable)) {
	$template->add_region('content', '<p class="error">Please select a variable on the previous page.</p><p><a href="' . str_replace('_2.php', '_1.php', $_SERVER['REQUEST_URI']) . '">Back</a></p>');
	include('header.php');
	$template->make_template();
	include('footer.php');
	exit;
}
if ($f['provider']) {
	$provider = dda::getProviderName($f['provider']);
} else {
	$provider = "ALL";
	$providerId = 0;
}
$legend		= dda::getLegendName($variable, $f['region'], $provider, $f['year']);
$colors		= array("9900CC", "FF9900", "993333"); // purple, orange, brown
$data		= dda::getActivityVariableArray($variable);
$labels		= implode(';', array_keys($data));
$cats		= implode(';', $data);
$pcScript	= "graph.setcategories($labels;)\ngraph.setseries((CLR_{$colors[0]})'$legend';$cats;)\n"
			. "main.AddPCXML(<Textbox Name='title' Top='0' Left='0' Width='615' Height='24'><Properties AutoWidth='False' HJustification='Center' LeftMargin='5' RightMargin='5' FillColor='#BACBDB' Font='Size:14; Style:Bold Italic; Color:#5C656A;'/>\n"
			. "<Text>$legend</Text></Textbox>)\n"
 			. "main.AddPCXML(<Textbox Name='axis1' Top='120' Left='10' Width='75' Height='70'>\n"
			. "<Properties BorderType='None' AutoWidth='True' HJustification='Center' LeftMargin='5' RightMargin='5' FillColor='#ffffff' Font='Size:10; Style:Bold ; Color:black;' />\n"
			. "<Text>" . dda::getAxisLabel($variable) . "</Text></Textbox>)\n"
 			. "graph.AddPCXML(<CategoryScale LimitLabelLength='False' MaxLengthRotatedText='10' StaggerLabels='False' RotateLabels='-45' LowOuterLine='Color:#7f7f7f;'  HighOuterLine='Color:#7f7f7f;'  MajorTick='Visible:False;'  MinorTick='Size:Large;'  MajorGrid='Color:#7f7f7f;'  Font='Size:12; Style:Bold Italic; Color:#3366ff;' MinorFont='Size:10;' />)";
$mychart = new chart;
$mychart->externalServerAddress = "http://www.communityinclusion.org:8080";
$mychart->internalCommPortAddress = "http://www.communityinclusion.org:8081";
$mychart->appearanceFile = "apfiles/dmr_activity.pcxml";
$mychart->width = 616;
$mychart->height = 430;
$mychart->userAgent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
$mychart->returnDescriptiveLink = true;
$mychart->language = "EN";
$mychart->pcScript = $pcScript;
$mychart->imageType = !$print ? "JPEG" : 'JPG';

preg_match('/^(number|percent|total|mean)/i', $variable, $th);
$html 	= $mychart->getEmbeddingHTML() . '<table border="1" cellpadding="3" cellspacing="0">'
		. "<caption>$legend</caption><thead><tr><th>Activity</th><th>" . ucfirst(strtolower($th[1])) . "</th></tr></thead><tbody>";
foreach ($data as $label => $val) {
	$html .= "<tr><th scope=\"row\">$label</th><td>$val</td></tr>";
}
$html .= "</tbody></table>";
if (!$print) {
	$html .= "<br /><a target='_new' href='charts/activity_2.php?print=1&amp;variable=$variable&amp;" . dda::serializeFilters() . "'>Printer-Friendly Format</a>";
}
$template->add_region('content', $html);
include("header.php");
$template->make_template(); 
include("footer.php");

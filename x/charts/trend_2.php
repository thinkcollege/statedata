<?php 
ini_set("include_path","../");
include("common/classes.php");

$print = !empty($_REQUEST["print"]);
$mre_base=new mre_base;

//$template->define_file($print ? 'print_template.php' : 'template.php');
$title =  $mre_base->mre_base_sitename . " - Trend report";
$area="trend" ;

if ($print) {
	$show_flash_link = 0;
} else {	 
	$show_flash_link = 1;
}

$functions	= new functions;
$mychart	= new chart;

$reporttype	= !empty($_REQUEST['reporttype']) ? preg_replace('/[^a-z0-9_-]/i', '', $_REQUEST['reporttype']) : '';
$year	= !empty($_REQUEST['year']) ? preg_replace('/[^\',a-z0-9_-]/i', '', $_REQUEST['year']) : '';
$selectedstates	= !empty($_REQUEST['selectedstates']) ? preg_replace('/[^\',a-z0-9_-]/i', '', $_REQUEST['selectedstates']) : '';
$act_subcat	= !empty($_REQUEST['subcat']) ? preg_replace('/[^a-z0-9_-]/i', '', $_REQUEST['subcat']) : '';
$selectedstates = str_replace("'xxx',","",$selectedstates);

list($activity_id, $subcat_id) = explode("_", $act_subcat);
$activity	= $functions->get_activity($activity_id);

$activity_name = $functions->get_activity_name($activity_id);
$subcat_name = $functions->get_subcat_name($subcat_id);
$states = $functions->convert_state_names($selectedstates);
$stateArray = explode(",",$states);

$heading = "Trend Chart: $subcat_name <br/> $states for FYs $year ";


$full_url = $functions->getFullUrl(1);

$htmlTable = "";

switch($activity_id) {
	case "1":
		switch($subcat_id){
			case "1":
				//echo  "<h2>Device Demonstrations by AT Type: Percentages</h2>";
				$data = $activity->generate_at_type($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "2":
				//echo  "<h2>Device Demonstrations by Participants: Percentages</h2>";
				$data = $activity->generate_participants($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "5":
				//echo  "<h2>Satisfaction with Device Demonstrations: Percentages</h2>";
				$data = $activity->generate_sat($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
		}
		break;
	case "2":
		switch($subcat_id){
			case "6":
				$data = $activity->generate_purpose($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "7":
				$data = $activity->generate_at_type($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "8":
				$data = $activity->generate_participants($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "9":
				$data = $activity->generate_sat($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
		}
		break;
	case "3":
		switch($subcat_id){
			case "11":
				$data = $activity->generate_deviceexchange_exchange_at_type($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "12":
				$data = $activity->generate_deviceexchange_exchange_at_type_dol($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "14":
				$data = $activity->generate_devicerrr_rrr_at_type($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "15":
				$data = $activity->generate_devicerrr_rrr_at_type_dol($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "17":
				$data = $activity->generate_deviceopenended_at_type($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "18":
				$data = $activity->generate_deviceopenended_at_type_dol($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "19":
				$data = $activity->generate_sat($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			
		}
		break;
	case "4":
		switch($subcat_id){
			case "21":
				$data = $activity->generate_financialactivites_at_type($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "22":
				$data = $activity->generate_financialactivites_at_type_dol($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "24":
				$data = $activity->generate_aquisition_at_type($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "25":
				$data = $activity->generate_aquisition_at_type_dol($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "26":
				$data = $activity->generate_sat($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
		}
		break;
	case "5":
		switch($subcat_id){
			case "27":
				$data = $activity->generate_training_partcipants($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "28":
				$data = $activity->generate_training_topics($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			
		}
		break;
	case "5":
		switch($subcat_id){
			case "29":
				$data = $activity->generate_devices($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "30":
				$data = $activity->generate_funding($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			case "31":
				$data = $activity->generate_disability($selectedstates,$year,$reporttype);
				$htmlTable = $activity->html_format($data);
				break;
			
		}
		break;
}
$chartString = "";
if ($reporttype == "oneyear" || $reporttype == "single"){

	$pcScript = "";
	$colors = array("00FFFF", "000088", "993333");

	for ($m =0 ; $m < count($data["data"]); $m++){
		$pcScript 	.= "graph.setseries((CLR_{$colors[$m]}){$data["pscript_data"][$m]})";
	}

	$pcScript 	= "graph.setcategories(" . $data["pscript_headings"] . ")" . $pcScript
				. "main.AddPCXML(<Textbox Name='title' Top='0' Left='0' Width='615' Height='34'>
	<Properties AutoWidth='False' HJustification='Center' LeftMargin='5' RightMargin='5' FillColor='#BACBDB' Font='Size:14; Style:Bold Italic; Color:#5C656A;'/>
	<Text>".str_replace("<br/>","&#xa;",$heading)."</Text></Textbox>)"
				. "main.AddPCXML(<Textbox Name='axis1' Top='120' Left='40' Width='75' Height='70'>
	<Properties BorderType='None' AutoWidth='True' HJustification='Center' LeftMargin='5' RightMargin='5' FillColor='#ffffff' Font='Size:10; Style:Bold ; Color:black;'/>
	<Text>Percent</Text></Textbox>)";
	//echo $pcScript;
	$mychart->externalServerAddress = "http:/www.communityinclusion.org:8080";
	$mychart->internalCommPortAddress = "http://www.communityinclusion.org:8081";
	$mychart->appearanceFile = "apfiles/comparison.pcxml";
	$mychart->userAgent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
	$mychart->width = 616;
	$mychart->height = 330;
	$mychart->returnDescriptiveLink = true;
	$mychart->language = "EN";
	$mychart->pcScript = $pcScript;
	$mychart->imageType = !$print ? "FLASH" : "JPG";

	$chartString = preg_replace("/<script.*?<\/script>/i", "", $mychart->getEmbeddingHTML());
}
include("header.php");
echo $chartString;
echo $htmlTable;

include("footer.php");
?>
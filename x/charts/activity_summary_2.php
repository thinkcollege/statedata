<?php 
ini_set("include_path","../");
include("common/classes.php");

$print = !empty($_REQUEST["print"]);
$mre_base=new mre_base;

//$template->define_file($print ? 'print_template.php' : 'template.php');
$title =  $mre_base->mre_base_sitename . " - Activity summary report";
$area="activity" ;

if ($print) {
	$show_flash_link = 0;
} else {	 
	$show_flash_link = 1;
}

$functions	= new functions;

$year	= !empty($_REQUEST['year']) ? preg_replace('/[^\',a-z0-9_-]/i', '', $_REQUEST['year']) : '';
$activity_id	= !empty($_REQUEST['activity']) ? preg_replace('/[^a-z0-9_-]/i', '', $_REQUEST['activity']) : '';
$selectedstates	= !empty($_REQUEST['selectedstates']) ? preg_replace('/[^\',a-z0-9_-]/i', '', $_REQUEST['selectedstates']) : '';
$reporttype = !empty($_REQUEST['reporttype']) ? preg_replace('/[^a-z0-9_-]/i', '', $_REQUEST['reporttype']) : '';

$activity_name = $functions->get_activity_name($activity_id);
$activity	= $functions->get_activity($activity_id);
$heading = "$activity_name activity summary report for " . str_replace("'","",str_replace("'xxx',","",$selectedstates));


$full_url = $functions->getFullUrl(1);


include("header.php");

echo "<p>Total number of programs reporting data: " . $activity->number_reporting($activity_id) . "</p>";
$name = "";
switch($activity_id) {
	case "1":		
		$name = "Device Demonstrations";
		
		
		echo  "<h2>$name by AT Type: Percentages</h2>";
		$data = $activity->generate_at_type($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);

		echo  "<h2>$name Participants by type: Percentages</h2>";
		$data = $activity->generate_participants($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);

		echo  "<h2>Satisfaction with $name: Percentages</h2>";
		$data = $activity->generate_sat($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		break;
	case "2":
		$name = "Device Loan";

		echo  "<h2>$name by Purpose: Percentages</h2>";
		$data = $activity->generate_purpose($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		
		
		echo  "<h2>$name by AT Type: Percentages</h2>";
		$data = $activity->generate_at_type($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);

		echo  "<h2>$name Participants by type: Percentages</h2>";
		$data = $activity->generate_participants($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);

		echo  "<h2>Satisfaction with $name: Percentages</h2>";
		$data = $activity->generate_sat($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		break;
	case "3":
		
		echo  "<h2>Device Exchange by AT Type: Percentages</h2>";
		$data = $activity->generate_deviceexchange_exchange_at_type($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		
		
		echo  "<h2>Device Exchange by AT Type: Total Dollar amount device exchange program saved consumers</h2>";
		$data = $activity->generate_deviceexchange_exchange_at_type_dol($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);

		echo  "<h2>Device Reassignment/Refurbishment/Repair (RRR) by AT Type: Percentages</h2>";
		$data = $activity->generate_devicerrr_rrr_at_type($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);

		echo  "<h2>Device Reassignment/Refurbishment/Repair (RRR) by AT Type: Total Dollar amount program saved consumers</h2>";
		$data = $activity->generate_devicerrr_rrr_at_type_dol($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		
		echo  "<h2>Open-ended loans by AT Type: Percentages</h2>";
		$data = $activity->generate_deviceopenended_at_type($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		
		echo  "<h2>Open-ended loans by AT Type: Total Dollar amount open-ended loan program saved consumers</h2>";
		$data = $activity->generate_deviceopenended_at_type_dol($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		
		echo  "<h2>Satisfaction with Device Reutilzation: Percentages</h2>";
		$data = $activity->generate_sat($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		break;
	case "4":
		
		echo  "<h2>Financial Loans by AT Type: Percentages</h2>";
		$data = $activity->generate_financialactivites_at_type($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		
		
		echo  "<h2>Financial Loans by AT Type: Dollar Value of Loans Issued by Financial Loans Program</h2>";
		$data = $activity->generate_financialactivites_at_type_dol($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);

		echo  "<h2>Financial Activities Resulting in the Acquisition of AT by AT Type: Percentages</h2>";
		$data = $activity->generate_aquisition_at_type($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);

		echo  "<h2>Financial Activities Resulting in the Acquisition of AT by AT Type: Dollar Value of loans</h2>";
		$data = $activity->generate_aquisition_at_type_dol($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		
		echo  "<h2>Financial Activities that Allow Consumers to Obtain AT at a Reduced Cost by AT Type: Percentages</h2>";
		$data = $activity->generate_allowconsumers_at_type($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		
		echo  "<h2>Financial Activities that Allow Consumers to Obtain AT at a Reduced Cost of AT by AT Type: Dollar Value of loans</h2>";
		$data = $activity->generate_allowconsumers_at_type_dol($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		
		echo  "<h2>Satisfaction with Financing Activities: Percentages</h2>";
		$data = $activity->generate_sat($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		break;
	case "5":
		
		echo  "<h2>Training Participants: Percentages</h2>";
		$data = $activity->generate_training_partcipants($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		
		
		echo  "Trainings by Topic: Percentages</h2>";
		$data = $activity->generate_training_topics($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		break;

	case "6":
		
		echo  "<h2>Information and Assistance on AT Devices/Services: Percentages</h2>";
		$data = $activity->generate_devices($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		
		
		echo  "Information and Assistance on AT Funding: Percentages</h2>";
		$data = $activity->generate_funding($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		break;

		echo  "Information and Assistance on Disability Topics: Percentages</h2>";
		$data = $activity->generate_disability($selectedstates,$year,$reporttype);
		echo $activity->html_format($data);
		break;
}



include("footer.php");
?>
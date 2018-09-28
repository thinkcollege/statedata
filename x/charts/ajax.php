<?php

ini_set("include_path",".:../");
include("common/classes.php");
$mre_base=new mre_base;

$action	= !empty($_REQUEST['action']) ? preg_replace('/[^a-z0-9_-]/i', '', $_REQUEST['action']) : '';
$activity	= !empty($_REQUEST['activity']) ? preg_replace('/[^a-z0-9_-]/i', '', $_REQUEST['activity']) : '';
$elem	= !empty($_REQUEST['elem']) ? preg_replace('/[^a-z0-9_-]/i', '', $_REQUEST['elem']) : '';
$multiselect	= !empty($_REQUEST['multiselect']) ? preg_replace('/[^a-z0-9_-]/i', '', $_REQUEST['multiselect']) : '';
$showAll	= !empty($_REQUEST['showAll']) ? preg_replace('/[^a-z0-9_-]/i', '', $_REQUEST['showAll']) : '';

if ($multiselect == '') {
	$multiselect = false;
} else {
	$multiselect = true;
}

if ($showAll == '') {
	$showAll = 1;
} else {
	$showAll = 0;
}
$dataOnly = true;

$functions = new functions;
$response = "";

switch ($action)
{
case "getStates":
	$activityAbbrv = $functions->get_activity_abbrv($activity);
	$response = $functions->getActiveStates("states", $activityAbbrv, $multiselect,$showAll, $dataOnly);
	break;
//case label2:
//  code to be executed if n=label2;
//  break;
default:
  $response  = "";
}	
echo $response;
?>
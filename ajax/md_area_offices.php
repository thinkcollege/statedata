<?php
require_once('../common/classes_md.php');
error_reporting(E_ALL);
ini_set('display_errors', 'off');

$database = Database::getDatabase();

//header('Content-type: text/xml');
$region_id = (isset($_REQUEST['region_id'])) ? $_REQUEST['region_id'] : '';

$query = "Select * from mdda_area_offices";
//$response = "<area_offices>";

if ($region_id != '') {
	$query .= " where region_id = " . $region_id;
}

$query .= " order by area_office";

$result = $database->query($query);

$num=0;
$num=mysql_affected_rows();
//calling class
$objJSON=new mysql2json();
echo(trim($objJSON->getJSON($result,$num)));

/*
while($row = mysql_fetch_array($results))
 {
	$response .= "<area_office area_office_id=\"".$row["area_office_id"]."\" region_id=\"".$row["region_id"]."\" area_office=\"".$row["area_office"]."\" />";
 }
$response .= "</area_offices>";

echo $response;
*/
?>

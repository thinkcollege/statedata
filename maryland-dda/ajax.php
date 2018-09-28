<?php
ini_set("include_path", "../");
include("common/classes_md.php");
header('Content-Type: text/plain', true);
$r = !empty($_GET['r']) ? $_GET['r'] : '';
$a = !empty($_GET['ao']) ? $_GET['ao'] : '';
$cols = (count($_GET) == 1 ? '`listing`.`area_office` AS `val`, `listing`.`area_office` AS `opt`' : '`providers`.`Vendor` AS `opt`, `mdda_consumers`.`provider_id` AS `val`') ;
$where	= ($r ? "`regions`.`region` = '$r' AND `listing`.`area_office` IS NOT NULL AND TRIM(`listing`.`area_office`) <> ''" : '') . ($r && $a ? ' AND ' : "")
		. ($a ? "`listing`.`area_office` = '$a' AND `mdda_consumers`.`provider_id` IS NOT NULL AND `mdda_consumers`.`provider_id` <> 0" : '');

print '<option value="0">All ' . (count($_GET) == 1 ? 'Area Offices' : 'Providers') . '</option>';
$db = Database::getDatabase();
$rs = $db->query("SELECT DISTINCT $cols FROM `mdda_consumers` LEFT JOIN `mdda_area_offices` `listing` ON `mdda_consumers`.`area_office_id` = `listing`.`area_office_id` LEFT JOIN `mdda_providers` `providers` ON `mdda_consumers`.`provider_id` = `providers`.`provider_id` LEFT JOIN `mdda_regions` `regions` on `mdda_consumers`.`resp_region` = `regions`.`region_id` WHERE $where ORDER BY `opt`");
while ($row = $db->fetch_assoc($rs)) {
	print '<option value="' . htmlentities($row['val'], ENT_COMPAT, 'UTF-8') . '">' . htmlentities(trim($row['opt']), ENT_COMPAT, 'UTF-8') . "</option>";
}
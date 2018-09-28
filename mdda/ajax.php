<?php
ini_set("include_path", "../");
include("common/classes_md.php");
header('Content-Type: text/plain', true);
$r = !empty($_GET['r']) ? $_GET['r'] : '';
$a = !empty($_GET['ao']) ? $_GET['ao'] : '';
$cols = count($_GET) == 1 ? '`area_office` AS `val`, `area_office` AS `opt`' : '`vendor` AS `opt`, `vendor_id` AS `val`';
$where	= ($r ? "`region` = '$r' AND `area_office` IS NOT NULL AND TRIM(`area_office`) <> ''" : '') . ($r && $a ? ' AND ' : "")
		. ($a ? "`area_office` = '$a' AND `Vendor_ID` IS NOT NULL AND `Vendor_ID` != ''" : '');

print '<option value="0">All ' . (count($_GET) == 1 ? 'Counties' : 'Providers') . '</option>';
$db = Database::getDatabase();
$rs = $db->query("SELECT DISTINCT $cols FROM `spec_mdda6` WHERE $where ORDER BY `opt`");
while ($row = $db->fetch_assoc($rs)) {
	print '<option value="' . htmlentities($row['val'], ENT_COMPAT, 'UTF-8') . '">' . htmlentities(trim($row['opt']), ENT_COMPAT, 'UTF-8') . "</option>";
}
<?php
function e($s) {
	$db = fQuery();
	return $db->escape($s);
}

function geoSort($geo1, $geo2) {
	if (in_array($geo1, array('All Counties', 'All Providers', 'All Regions'))) {
		return -1;
	} else if (in_array($geo2, array('All Counties', 'All Providers', 'All Regions'))) {
		return 1;
	}
	return strcmp($geo1, $geo2);
}
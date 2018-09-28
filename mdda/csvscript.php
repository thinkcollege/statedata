<?php
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="Maryland_DDA_data_' . date('m-d-Y') . '.csv"');
$csv = $_REQUEST['csv'];
echo $csv;
?>
<?php
#ini_set('memory_limit', '1024M');
define('LIVE', (isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] == '72.3.249.15') || (isset($_ENV['HOSTNAME']) && $_ENV['HOSTNAME'] == 'communityinclusion.org'));

include((LIVE ? '/home/statedata/statedata.info/htdocs/waddd/includes/' : '') . 'constants.php');
include((LIVE ? '/home/statedata/statedata.info/htdocs/waddd/includes/' : '') . 'utils.php');
include(LIVE ? '/home/nercve/lib/lib.php' : '../../lib/lib.php');
$suffix = date('_Y_m_d') . '.dat';
$ignoredRecords = $i = $insertRows = 0;
$msgs = $msg = $query = '';

if (is_file(DATA_DIR . 'Billing' . $suffix)) {
	$msgs .= "Importing billing data " . date('m/d/Y');
	$f = fopen(DATA_DIR . 'Billing' . $suffix, 'r');
	while (!feof($f)) {
		$i++;
		$data = fgetcsv($f, 0, '|', '"');
		if ($data === false) {
			$i--;
			continue;
		}
		$msg = (count($data) != 26 ? "$i Not enough columns.\n" : '')
			. (intval($data[0]) <= 0 ? "$i Invalid client ID.\n" : '')
			. (!preg_match('/^DV\d{2}$/', $data[1]) ? "$i DV code not valid!\n" : '')
			. (strlen($data[2]) != 6 ? "$i Serivce Month Not valid!\n" : '')
			. (strlen($data[3]) != 6 ? "$i Billing Month Not valid!\n" : '')
			. (!preg_match(REGEX_REGION_CODE, $data[4]) && strpos($data[4], 'RG1') === false ? "$i region code not valid!\n" : '')
			. (!preg_match(REGEX_COUNTY_CODE, $data[5]) ? "$i county code not valid!\n" : '')
			. (!preg_match(REGEX_PROVIDER_NUMBER, $data[6]) ? "$i provider Number not valid!\n" : '')
			. (!empty($data[8]) && strtotime($data[8]) === false ? "$i invalid DOB!\n" : '')
			. (!preg_match('/^(?:GN(?:FE|MA))?$/', $data[9], $m9) ? "$i Invalid Gender Code!\n" : '')
			. (!preg_match(REGEX_DATETIME, $data[10], $m10) ? "$i Invalid Service Start Date!\n" : '')
			. (!preg_match(REGEX_DATETIME, $data[11], $m11) ? "$i Invalid Service End Date!\n" : '')
			. (!empty($data[12]) && !isFloat($data[12]) ? "$i Invalide Gross Pay!\n" : '')
			. (!empty($data[13]) && !isFloat($data[13]) ? "$i Invalide Hours Paid!\n" : '')
			. (!empty($data[14]) && !isFloat($data[14]) ? "$i Check index 14 should be float!\n" : '')
			. (!empty($data[15]) && !isFloat($data[15]) ? "$i Check index 15 should be float!\n" : '')
			. (!empty($data[16]) && !isFloat($data[16]) ? "$i Check index 16 should be float!\n" : '')
			. (!empty($data[17]) && !isFloat($data[17]) ? "$i Check index 17 should be float!\n" : '')
			. (!empty($data[18]) && !isFloat($data[18]) ? "$i Check index 18 should be float!\n" : '')
			. (!preg_match('/^(RI[0-9A-Z]{2})?$/', $data[19]) ? "$i Check index 19 should be RI code!\n" : '')
			. (!empty($data[20]) && !isFloat($data[20]) ? "$i Check index 20 should be float!\n" : '')
			. (!preg_match('/^(?:DL\d{2})?$/', $data[21]) ? "$i Check index 21 should be DL code!\n" : '')
			. (!preg_match('/^(?:DL\d{2})?$/', $data[22]) ? "$i Check index 22 should be DL code\n" : '')
			. (!preg_match('/^([a-z0-9+]{1,6})?$/i', $data[23]) ? "$i Check index 23 should be FS code!\n" : '')
			. (!preg_match(REGEX_DATETIME, $data[24], $m24) ? "$i Check index 24 should be datetime!\n" : '')
			. (!preg_match(REGEX_DATETIME, $data[25], $m25) ? "$i Check index 25 should be datetime!\n" : '');
		if (!empty($msg)) {
			$msgs .= $msg . print_r($data, true);
			$msg = '';
			$ignoredRecords++;
			continue;
		}
		$data[0] = intval($data[0]);
		$data[1] = "'{$data[1]}'";
		$data[2] = '\'' . date('Y-m-d', mktime(0,0,0,substr($data[2], 4, 2), 1, substr($data[2], 0, -2))) . '\'';
		$data[3] = '\'' . date('Y-m-d', mktime(0,0,0,substr($data[3], 4, 2), 1, substr($data[3], 0, -2))) . '\'';
		$data[4] = "'{$data[4]}'";
		$data[5] = "'{$data[5]}'";
		$data[6] = '\'' . e($data[6]) . '\'';
		$data[7] = '\'' . e($data[7]) . '\'';
		$data[8] = '\'' . date('Y-m-d', strtotime($data[8])) . '\'';
		$data[9] = has_value($m9, 0, '') ? '\'N/A\'' : "'{$data[9]}'"  ;
		$data[10] = isset($m10[1]) ? "'{$m10[1]}'" : "''";
		$data[11] = isset($m11[1]) ? "'{$m11[1]}'" : "''";
		$data[12] = floatval($data[12]);
		$data[13] = floatval($data[13]);
		$data[14] = !empty($data[14]) ? floatval($data[14]) : 'NULL';
		$data[15] = !empty($data[15]) ? floatval($data[15]) : 'NULL';
		$data[16] = !empty($data[16]) ? floatval($data[16]) : 'NULL';
		$data[17] = !empty($data[17]) ? floatval($data[17]) : 'NULL';
		$data[18] = !empty($data[18]) ? floatval($data[18]) : 'NULL';
		$data[19] = "'{$data[19]}'";
		$data[20] = empty($data[20]) ? 'NULL' : floatval($data[20]);
		$data[21] = "'{$data[21]}'";
		$data[22] = "'{$data[22]}'";
		$data[23] = "'{$data[23]}'";
		$data[24] = isset($m24[1]) ? "'{$m24[1]}'" : "''";
		$data[25] = isset($m25[1]) ? "'{$m25[1]}'" : "''";
		
		$result = fQuery('SELECT 1 FROM ' . TABLE_BILLING . " WHERE ClientID = {$data[0]} AND ServiceCode = {$data[1]} AND ServiceYearMonth = {$data[2]}");
		if ($result->queriedRows() == 1) {
			fQuery('UPDATE ' . TABLE_BILLING . " SET `BillingYearMonth` = {$data[3]}, `RegionCode` = {$data[4]}, `CountyCode` = {$data[5]}, `ProviderNumber` = {$data[6]}, `ProviderName` = {$data[7]}, `ClientDOB` = {$data[8]}, `ClientGender` = {$data[9]}, `ServiceStartDate` = {$data[10]}, `SerivceEndDate` = {$data[11]}, `GrossWages` = {$data[12]}, `HoursPaid` = {$data[13]},	`TotalHoursOfSupport` = {$data[14]}, `JobPrepHours` = {$data[15]}, `JobDevelopmentHours` = {$data[16]}, `JobCoachingHours` = {$data[17]}, `RecordKeepingHours` = {$data[18]}, `ClientResidentTypeCode` = {$data[19]}, `CognitivePreformanceScore` = {$data[20]}, `CommunityAccessSupportLevelCode` = {$data[21]}, `EmploymentSupportLevelCode` = {$data[22]}, `FundSourceCode` = {$data[23]}, `FundStartDate` = {$data[24]}, `FundEndDate` = {$data[25]} WHERE `ClientID` = {$data[0]} AND `ServiceCode` = {$data[1]} AND `ServiceYearMonth` = {$data[2]}");
		} else {
			$query = 'INSERT INTO ' . TABLE_BILLING . ' (`ClientID`, `ServiceCode`, `ServiceYearMonth`, `BillingYearMonth`, `RegionCode`, `CountyCode`, `ProviderNumber`, `ProviderName`, `ClientDOB`, `ClientGender`, `ServiceStartDate`, `SerivceEndDate`, `GrossWages`, `HoursPaid`, `TotalHoursOfSupport`, `JobPrepHours`, `JobDevelopmentHours`, `JobCoachingHours`, `RecordKeepingHours`, `ClientResidentTypeCode`, `CognitivePreformanceScore`, `CommunityAccessSupportLevelCode`, `EmploymentSupportLevelCode`, `FundSourceCode`, `FundStartDate`, `FundEndDate`) VALUES (' . implode(', ', $data) . ')';
			fQuery($query);
			$insertRows++;
			$ret = getVar('SELECT 1 FROM ' . TABLE_PROVIDER . ' p WHERE p.Number = \'' . e($data[6]) . '\'');
			if ($ret === null) {
				fQuery('INSERT INTO ' . TABLE_PROVIDER . ' (Number, Name) VALUES (\'' . e($data[6]) . '\', \'' . e($data[7]) . '\')');
			}
		}
	}
	$msgs .= "\nIgnored Rows:$ignoredRecords\tInsertedRows:$insertRows\tTotal Rows:$i\n";
	fclose($f);
}
if (is_file(DATA_DIR . 'Employment' . $suffix)) {
	$msgs .= "\nImporting Employment data " . date('m/d/Y');
	fQuery('TRUNCATE TABLE ' . TABLE_EMPLOYMENT);
	$f = fopen(DATA_DIR . 'Employment' . $suffix, 'r');
	$i = $ignoredRecords = $insertRows = 0;
	$query = '';
	while (!feof($f)) {
		$i++;
		$data = fgetcsv($f, 0, '|', '"');
		if ($data === false) {
			$i--;
			continue;
		}
		$msg = (count($data) != 9 ? "$i doens't have enough fields!\n" : '')
			. (intval($data[0]) <= 0 ? "$i-0 should be int.\n" : '')
			. (!preg_match(REGEX_DATETIME, $data[2], $m2) ? "$i-2 should be datetime.\n" : '')
			. (!preg_match(REGEX_DATETIME, $data[3], $m3) ? "$i-3 should be datetime.\n" : '')
			. (!preg_match(REGEX_FLAG, $data[4], $m4) ? "$i-4 should be True or False.\n" : '')
			. (!preg_match(REGEX_FLAG, $data[5], $m5) ? "$i-5 should be True or False.\n" : '')
			. (!preg_match(REGEX_FLAG, $data[6], $m6) ? "$i-6 should be True or False.\n" : '')
			. (!preg_match(REGEX_FLAG, $data[7], $m7) ? "$i-7 should be True or False.\n" : '')
			. (!preg_match('/^(JT\d{2})?$/', $data[8]) ? "$i-8 should be JT code.\n" : '');
		if ($msg) {
			$msgs .= $msg . print_r($data, true);
			$msg = '';
			$ignoredRecords++;
			continue;
		}
		$data[0] = intval($data[0]);
		$data[1] = '\'' . e($data[1]) . '\'';
		$data[2] = isset($m2[1]) ? "'{$m2[1]}'" : "''";
		$data[3] = isset($m3[1]) ? "'{$m3[1]}'" : "''";
		$data[4] = isset($m4[1]) ? ($m4[1] === 'True' ? 1 : 0) : 'NULL';
		$data[5] = isset($m5[1]) ? ($m5[1] === 'True' ? 1 : 0) : 'NULL';
		$data[6] = isset($m6[1]) ? ($m6[1] === 'True' ? 1 : 0) : 'NULL';
		$data[7] = isset($m7[1]) ? ($m7[1] === 'True' ? 1 : 0) : 'NULL';
		$data[8] = "'{$data[8]}'";
		$query .= ' (' . implode(', ', $data) . '),';
		$insertRows++;
	}
	$msgs .= "\nIgnored Rows:$ignoredRecords\tInserted Rows:$insertRows\tTotal Rows:$i\n";
	if ($query != '') {
		$query = 'INSERT INTO ' . TABLE_EMPLOYMENT . ' (`ClientID`, `EmployerName`, `StartDate`, `EndDate`, `MedicalInsurance`, `DentalInsurance`, `Retired`, `PaidLeave`, `JobType`) VALUES' . substr($query, 0, -1);
		fQuery($query);
	}
}

if (is_file(DATA_DIR . 'ReferenceCode' . $suffix)) {
	$msgs .= 'Importing ReferenceCode data ' . date('m/d/Y') . "\n";
	$f = fopen(DATA_DIR . 'ReferenceCode' . $suffix, 'r');
	fQuery('TRUNCATE TABLE ' . TABLE_CODE_LOOKUP);
	$i = $ignoredRecords = $insertRows = 0;
	$query = '';
	while (!feof($f)) {
		$i++;
		$data = fgetcsv($f, 0, '|', '"');
		if ($data === false) {
			$i--;
			continue;
		}
		$msg  .= (count($data) != 3 ? "$i not enought fields!\n" : '')
			. (!preg_match('/^[A-Z]{2}$/', trim($data[0])) ? "$i-0 should be char(2) A-Z.\n" : '')
			. (!preg_match('/^[A-Z0-9+]{1,6}$/i', trim($data[1])) ? "$i-1 should be varchar(6) [a-z0-9+].\n" : '');
		if ($msg) {
			$msgs .= $msg . print_r($data, true);
			$msg = '';
			$ignoredRecords++;
			continue;
		}
		$data[0] = trim($data[0]);
		$data[1] = trim($data[1]);
		$data[2] = e(trim($data[2]));
		$query .= ' (\'' . implode('\', \'', $data) . '\'),';
		$insertRows++;
	}
	$msgs .= "\nIgnored Rows:$ignoredRecords\tInserted Rows:$insertRows\tTotal Rows:$i\n";
	if ($query != '') {
		$query = 'INSERT INTO ' . TABLE_CODE_LOOKUP . ' (`Grouping`, `Code`, `Value`) VALUES' . substr($query, 0, -1);
		fQuery($query);
	}
}
$msgs .= error();
if (LIVE) {
	mail('Christopher Nagle <christopher.nagle@umb.edu>', 'WA-DDD Data import', $msgs, "From: Christopher Nagle <christopher.nagle@umb.edu>");
} else {
	print $msgs;
}

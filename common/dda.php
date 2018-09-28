<?php
/**
 * useful functions for DDS.
 *
 * @package dds
 * @author Chris Nagle
 */
class dda {

	static private $vars = null;
	function __construct() {}
	
	static function getVariables() {
		if (self::$vars === null) {
			$db = Database::getDatabase();
			$vars = $db->query('SELECT `col`, `name`, `axis`, `special` FROM `dds_variables`');
			while ($var = $db->fetch_assoc($vars)) {
				self::$vars[$var['col']] = $var;
			}
		}
		return self::$vars;
	}

/*
	function: safehtml
	purpose: strip out non-safe tags
*/
	static function safehtml($html, $safetags="<b><a><br><i><u><ul><ol><li>") {
		$html=strip_tags($html, $safetags);
		return $html;
	}

	static function getFilters($report) {
		$f	= self::getFilterValues();
		$db = Database::getDatabase();
		$rs = $db->query("SELECT YEAR(NOW()) - MAX(YEAR(STR_TO_DATE(`dob`,'%d/%m/%Y'))) AS `min`, YEAR(NOW()) - MIN(YEAR(STR_TO_DATE(`dob`,'%d/%m/%Y'))) AS `max` FROM `mdda_consumers` ");
		$range = $db->fetch_assoc($rs);
		$age = '<option value="">All</option>';
		for ($i = max($range['min'], 15); $i <= $range['max']; $i++) {
			$age .= "<option>$i</option>";
		}
		
		return '<p><label for="y">Select ' . ($report == 'trends' ? 'start' : '') . ' year:</label> ' . self::getYearSelect('y', $f['year']) . '</p>'
				. ($report != 'region' && $report != 'individual' ? '<p><label for="r">Select region:</label> ' . self::getRegions("r", $f['region']) . "</p>"
					. '<p><label for="ao">Select area office:</label> ' . self::getAreaOffices('ao', $f['areaOffice']) . "</p>" : '')
				. ($report != 'region' && $report != 'provider' ? '<p><label for="p">Select provider</label> ' . self::getProviders('p', $f['provider']) . '</p>' : '')
				. '<p><label>Select age:</label> <label for="f">from</label> <select id="f" name="age[from]">'
				. str_replace("<option>{$f['from']}</option>", "<option selected=\"selected\">{$f['from']}</option>", $age)
				. '</select> <label for="t">to</label> <select id="t" name="age[to]">'
				. str_replace("<option>{$f['to']}</option>", "<option selected=\"selected\">{$f['to']}</option>", $age)
				. '</select></p>';
	}
	
	static function getFilterValues() {
		return array('year' => !empty($_REQUEST['y']) ? abs($_REQUEST['y']) : 0,
			'region' => !empty($_REQUEST['r']) ? $_REQUEST['r'] : '',
			'areaOffice' => !empty($_REQUEST['ao']) ? $_REQUEST['ao'] : '',
			'provider' => !empty($_REQUEST['p']) ? $_REQUEST['p'] : '',
			'from' => !empty($_REQUEST['age']['from']) && $_REQUEST['age']['from'] > 0 ? abs($_REQUEST['age']['from']) : 0,
			'to' => !empty($_REQUEST['age']['to']) && $_REQUEST['age']['to'] > 0 ? abs($_REQUEST['age']['to']) : 0);
	}

	static function getFilterClause($report) {
		$f = self::getFilterValues();
		$where	= " AND `reporting_period` " . ($report == 'trends' ? '>' : '') . '= ' . $f['year'];
		if ($f['to'] && $f['from']) {
			$where .= ' AND `dob` BETWEEN DATE_ADD(MAKEDATE(`reporting_period`, 92), INTERVAL -' . $f['to']
					. ' YEAR) AND DATE_ADD(MAKEDATE(`reporting_period`, 92), INTERVAL -' . $f['from'] . ' YEAR)';
		} else if ($f['to']) {
			$where .= ' AND `dob` < DATE_DIFF(MAKEDATE(`reporting_period`, 92), INTERVAL -' . $f['to'] . ' YEAR)';
		} else if ($f['from']) {
			$where .= ' AND `dob` > DATE_DIFF(MAKEDATE(`reporting_period`, 92), INTERVAL -' . $f['from'] . ' YEAR)';
		}
		if ($report == 'region') {
			return $where;
		}
		if ($f['region'] && $f['region'] != "all") {
		
				$where .= " AND region = '{$f['region']}' ";
		
		}
		if ($f['areaOffice']) {
			$where .= " AND `area_office` = '{$f['areaOffice']}'";
		}
		if ($report != 'comparison' && $f['provider']) {
			$where .= " AND provider_id = {$f['provider']} ";
		}
		return $where;
	}

	static function serializeFilters() {
		$ret = '';
		$sep = '';
		foreach (dda::getFilterValues() as $f => $v) {
			if (!empty($v)) {
				$ret .= "$sep$f=$v";
				$sep = "&amp;";
			}
		}
		return $ret;
	}

	static function passFilters() {
		$ret = '';
		foreach (dda::getFilterValues() as $f => $val) {
			if (!empty($val)) {
				$name = $f[0] . strtolower(preg_replace('/[a-z]+/', '', $f));
				$ret .= "<input type=\"hidden\" name=\"$name\" value=\"$val\" />";
			}
		}
		return $ret;
	}

/*
	function: getRegions
	purpose: returns a dropdown of regions
*/
	static function getRegions($element_name, $selected = '', $showAll = 1, $provider = 0, $regiontype = 'normal', $year = 0) {
		$where = $provider == 0 ? "`regions`.`region` != 'x'" : "`mdda_consumers`.`provider_id` = '$provider'";
		$sql = "SELECT distinct `regions`.`region` AS `val`, `regions`.`region` AS `opt` from `mdda_consumers` left join `mdda_regions` `regions` ON `mdda_consumers`.`resp_region` = `regions`.`region_id` where $where and `regions`.`region` IS NOT NULL AND `region` <> ''";

		
		$db = Database::getDatabase();
		$rs = $db->query($sql . " ORDER BY `opt`");
		$html = $showAll == 1 && $db->num_rows($rs) > 1 ? '<option value="all">All Regions</option>' : '';
		while ($row = $db->fetch_assoc($rs)) {
			$selected = isset($_REQUEST[$element_name]) && $_REQUEST[$element_name] == $row['val'] ? ' selected="selected"' : '';
			$html .= "<option value=\"{$row['val']}\"$selected>{$row['opt']}</option>";
		}
		return "<select id=\"$element_name\" name=\"$element_name\">$html</select>";
	}

	static function getRegionArray($provider) {
		$db = Database::getDatabase();
		$ret = array();
		$rs = $db->query("SELECT distinct `regions`.`Vendor` `Vendorname` from `mdda_consumers` LEFT JOIN `mdda_providers` `providers` ON `mdda_consumers`.`provider_id` = `providers`.`provider_id` LEFT JOIN `mdda_regions` `regions` ON `mdda_consumers`.`resp_region` = `regions`.`region_id` LEFT JOIN `mdda_area_offices` `counties` on `mdda_consumers`.`area_office_id` = `counties`.`area_office_id` where `Vendorname` = '$provider' and `regions`.`region` order by `regions`.`region`");
		while ($row = $db->fetch_assoc($rs)) {
			$ret[] = $row['region'];
		}
		return $ret;
	}
	
	static function getRegionArrayById($provider_id) {
		$db	 = Database::getDatabase();
		$ret = array();
		$vendor = "mdda_consumers.provider_id = $provider_id";
		if ($provider_id == "all") {
			$vendor = "";
		}
		$rs  = $db->query("SELECT distinct region from mdda_consumers LEFT JOIN `mdda_regions` `regions` ON `mdda_consumers`.`resp_region` = `regions`.`region_id` where $vendor and TRIM(`regions`.`region`) order by `regions`.`region`");
		while ($row = $db->fetch_assoc($rs)){
			$ret[] = $row['region'];
		}
		return $ret;
	}

	static function getRegionClause($region) {
		if (strpos($region, "x_") === 0) {
			return "region is not null and region != '' AND "
				. ($region == 'x_Central' || $region == 'x_West' ? 'LEFT(CRS_Contract, 1)' : 'CRS_Contract')
				. "IN (". self::getContractNumbers(substr($region, 2)) . ")";
		} else if ($region != '' && strtolower($region) != 'all' && $region != '0') {
			return "region = '$region'";
		} else {
			return 1;
		}
	}

	static function getAreaOffices($elementName, $region = '', $year = '') {
		$html = '';
		$where	= '`area_office` IS NOT NULL AND `area_office` != \'\''
				. ($region  ? ' AND ' . self::getRegionClause($region) : '')
				. ($year > 2003 ? ' AND `reporting_period` = ' . $year : '');
		$db = Database::getDatabase();
		$rs = $db->query('SELECT DISTINCT `counties`.`area_office` FROM `mdda_consumers` LEFT JOIN `mdda_area_offices` `counties` on `mdda_consumers`.`area_office_id` = `counties`.`area_office_id` WHERE ' . $where . ' ORDER BY `area_office`');
		while ($row = $db->fetch_assoc($rs)) {
			$selected = isset($_REQUEST[$elementName]) && $_REQUEST[$elementName] == $row['area_office'] ? ' selected="selected"' : '';
			$html .= "<option$selected>{$row['area_office']}</option>";
		}
		return "<select id=\"$elementName\" name=\"$elementName\"><option value=\"\">All Area offices</option>$html</select>";
	}
	
/*
	function: getProviders
	purpose: returns a dropdown of providers in a given region
*/
	static function getProviders($element_name, $region = 'ALL', $showAll = 1) {
		$db = Database::getDatabase();

		$where = self::getRegionClause($region);
		
		$rs = $db->query("SELECT distinct `providers`.`Vendor` `Vendorname`, `mdda_consumers`.`provider_id` FROM `mdda_consumers` LEFT JOIN `mdda_providers` `providers` on `mdda_consumers`.`provider_id` = `providers`.`provider_id` WHERE $where ORDER BY `providers`.`Vendor`");
		$html = "<select id=\"$element_name\" name=\"$element_name\">";
		if ($showAll == 1) {
			$html .= "<option value=\"ALL\">All Providers</option>";
		}
		while ($row = $db->fetch_assoc($rs)) {
			$selected = isset($_REQUEST[$element_name]) && $_REQUEST[$element_name] == $row['val'] ? ' selected="selected"' : '';
			$html .= "<option value=\"{$row['provider_id']}\"$selected>{$row['Vendorname']}</option>";
		}
		$html .= "</select>\n"; 
		return $html;
	}

/*
	function: getProviders
	purpose: returns a dropdown of providers in a given region
*/
	static function getActivityVariables() {
		$vars = array('numberinactivity' => 'Number participating in activity', 'percent' => 'Percent participating in activity',
			'totalhours' => 'Total # hours for activity', 'meanhours' => 'Mean hours per activity (of those participating)',
			'totalwages' => 'Total wages per activity', 'meanwage' => 'Mean wage per activity', 'meanhourlywage' => 'Mean hourly wage for individual, group and facility employment',
			'numberminimum' => 'Number earning at least minimum wage', 'percentminimum' => 'Percent earning at least minimum wage',
			'numberemployed10of12' => 'Number employed for 10 of the last 12 months', 'precentemployed10of12' => 'Percent employed for 10 of the last 12 months',
			'numbernewjobin12months' => 'Number entered a new individual job in the last 12 months');
		$html = '';
		$i = 0;
		foreach ($vars as $col => $label) {
			$html .=  "<li><input type=\"radio\" name=\"variable\" id=\"v$i\" value=\"$col\"> <label for='v$i'>$label</label></li>";
		}
		return "<ul id=\"ddsVars\">$html</li>";
	}

/*
	function: getRegionVariables
	purpose: returns a dropdown of providers in a given region
*/
	static function getRegionVariables($year) {
		$i = 0;
		$html = '';
		foreach (self::getVariables() as $col => $var) {
			$var_name = $var['name'];
			if ($year >= 2007 && !empty($col)) {
				$var_name = str_replace("or Non-Work Day Activities", "Work", $var_name);
			}
			if ($year == 2007 || $var['special'] == 0) {
				$html .= "<li><input type=\"radio\" name=\"var\" id=\"v$i\" value=\"$col\" /> <label for=\"v$i\">$var_name</label></li>";
			}
			$i++;
		}
		return "<ul id=\"ddsVars\">$html</ul>";
	}

/*
	function: getActivityColumnNamesArray
	purpose: return the column names for an activity
*/
	static function getActivityColumnNamesArray ($variable) {
		switch ($variable) {
			case 'totalwages':
			case 'meanwage':
			case 'numberminimum':
			case 'percentminimum':
				return array('Individual Supported Employment', 'Group Supported Employment', 'Facility Based Employment');
			case 'numberemployed10of12':
			case 'precentemployed10of12':	return array('Individual Supported Employment', 'Group Supported Employment');
			case 'numbernewjobin12months':	return array('Individual Supported Employment');
			case 'meanhourlywage':
				return array('Mean hourly wage Individual Employment', 'Mean hourly wage Group Employment', 'Mean hourly wage Facility Based Employment');
			default:
				return array('Individual Supported Employment', 'Group Supported Employment', 'Facility Based Employment', 'Volunteer or Non-Paid Day Services', 'in Transition');
		}
	}

/*
	function: getActivityColumnNamesArray
	purpose: return the column names for an activity
*/
	static function getRegionColumnNamesArray ($year = "any") {
		$db = Database::getDatabase();
		$rs = $db->query("SELECT DISTINCT `regions`.`region` FROM `mdda_consumers` LEFT JOIN `mdda_regions` `regions` ON `mdda_consumers`.`resp_region` = `regions`.`region_id` WHERE `regions`.`region` IS NOT NULL AND `regions`.`region` <> '' order by `regions`.`region`");

		$ret = $_SERVER['PHP_AUTH_USER'] =='dmruser' ? array("x_Berkshire", "x_Franklin/Hampshire", "x_Springfield/Westfield", "x_Holyoke/Chicopee", "x_West", "x_Central") : array();
		while ($row = $db->fetch_assoc($rs)) {
			$ret[] =  $row['region'];
		}
		return $ret;
	}

/*
	function: getLegendName
	purpose: return the legend name for an activity
*/
	static function getLegendName($variable, $region, $provider, $year) {
		$f = self::getFilterValues();
		if (strpos($f['region'], "x_") === 0) {
			$f['region'] = substr($f['region'], 2);
		}
		$legend	= ($f['provider'] ? " for " . self::getProviderName($f['provider']) : " for all providers ")
				. ($f['areaOffice'] ? " for {$f['areaOffice']} area office" : " in all area offices")
				. ($f['region'] ? " in the {$f['region']} region" : " in all regions") . " in {$f['year']}"
				. ($f['from'] && $f['to'] ? " between {$f['from']} and {$f['to']}" : '')
				. (!($f['from'] && $f['to']) && $f['from'] ? " {$f['from']} and older" : '')
				. (!($f['from'] && $f['to']) && $f['to'] ? " {$f['to']} and younger" : '');
		switch ($variable) {
			case 'numberinactivity':	return "Number participating in activity" . $legend;
			case 'percent':				return "Percent participating in activity" . $legend;
			case 'totalhours':			return "Total hours for activity" . $legend;
			case 'meanhours':			return "Mean hours per activity" . $legend;
			case 'totalwages':			return "Total wages per activity" . $legend;
			case 'meanwage':			return "Mean wage per activity" . $legend;
			case 'numberminimum':		return "Number earning at least minimum wage" . $legend;
			case 'percentminimum':		return "Percent earning at least minimum wage" . $legend;
			case 'meanhourlywage':		return "Mean hourly wage for individual, group and facility employment" . $legend;
			case 'numberemployed10of12':	return "Number employed for 10 of the last 12 months" . $legend;
			case 'precentemployed10of12':	return "Percent employed for 10 of the last 12 months" . $legend;
			case 'numbernewjobin12months':	return "Number entered a new individual job in the last 12 months" . $legend;
		}
	}

/*
	function: getRegionLegendName
	purpose: return the legend name for an region view
*/
	static function getRegionLegendName($variable, $year = '-1') {
		$vars =& self::getVariables();
		return isset($vars[$variable]) ? $vars[$variable]['name'] . ($year != -1 ? " in $year" : '') : '';
	}

/*
	function: getAxisLabel
	purpose: return the legend name for an activity
*/
	static function getAxisLabel($variable) {
		switch ($variable) {
			case 'numberinactivity':
			case 'numberminimum':		return "Total";
			case 'percent':
			case 'percentminimum':		return "Percent";
			case 'totalhours':
			case 'meanhours':			return "Hours";
			case 'totalwages':
			case 'meanwage':			return "Wages/&#xa;month";
			case 'meanhourlywage':		return "Mean";
		}
	}

/*
	function: getRegionAxisLabel
	purpose: return the axis label for the region view
*/
	function getRegionAxisLabel($variable) {
		$vars =& self::getVariables();
		return isset($vars[$variable]) ? $vars[$variable]['axis'] : '';
	}

/*
	function: getProviderName
	purpose: return the provider name
*/
	static function getProviderName($provider_id) {
		if (empty($provider_id)) {
			return 'All Providers';
		}
		$db = Database::getDatabase();
		$rs = $db->query("SELECT distinct Vendor from spec_dmr6 where region is not null and region != '' and Vendor_ID = " . $vendor_id );
		
		return $db->num_rows($rs) > 0 ? $db->fetch_result($rs, 0, 'vendor') : "";;
	}

/*
	function: getContractNmbers
	purpose: return the contract numbersfor a given region
*/
	static function getContractNumbers ($region) {
		switch ($region) {
			case 'Berkshire':			return "110314,110304,110305,110306";
			case 'Franklin/Hampshire':	return "120326,120612,120325,120334";
			case 'Springfield/Westfield': return "161362,140388,140349,140345,140317,160334,160307";
			case 'Holyoke/Chicopee':	return "150300,150320,150336,150615,150340,150318,150325";
			case 'Central':				return "2";
			case 'West':				return "1";
		}
	}

/*
	function: getRegionVariableArray
	purpose: return the values in each column for an region query
*/
	static function getRegionVariableArray($variable, $year) {
		$cols	= '';
		$sep	= '';
		$pos	= strpos($variable, '_');
		$type	= substr($variable, 0, $pos);
		$total	= strpos($variable, '_total_') === $pos; 
		$col	= $pos !== false ? substr($variable, ($total ? 6 : 0) + $pos + 1) : '1';
		$yesNo	= strpos($col, 'YN') !== false || $col == 'IndSupEmp' || $col == 'GroupSupEmp';
		foreach (self::getRegionColumnNamesArray($year) as $region) {
			if (strpos($region, "x_") === 0) {
				$clause = ($region == 'x_West' || $region == 'x_Central' ? "LEFT(CRS_Contract, 1)" : "`CRS_contract`")
						. " IN (" . self::getContractNumbers(substr($region, 2)) . ") AND "
						. ($yesNo ? "TRIM($col) = 'Y'" : "IFNULL($col, 0) > 0");
			} else {
				$clause = "region = '$region' and " . ($yesNo ? "TRIM($col) = 'Y'" : "IFNULL($col, 0) > 0");
			}
			switch ($type) {
				case 'Num': $cols .= $sep . "SUM($clause)";	break;
				case 'Per':
					$bottom = $yesNo ? "SUM(`regions`.`region` = '$region' AND $col IN ('Y', 'N'))" : ($total ? "SUM(IF(`regions`.`region` = '$region', `totalHours`, 0))" : "SUM(`region` = '$region')");
					$cols .= $sep . "IF($bottom > 0, FORMAT((SUM($clause) / $bottom) * 100, 2), 0)";
					break;
				case 'Avg':	 $cols .= $sep . "FORMAT(AVG(IF(`region` = '$region', $col, NULL)), 2)";	break;
				case 'Mean':
					switch ($col) { case 'indv_comp_hrs': $top = 'indv_comp_gross_wages'; break; case 'indv_cont_hrs': $top = 'indv_cont_gross_wages'; break; case 'grp_integ_hrs': $top = 'grp_integ_gross_wages'; break; case 'self_emp_hrs': $top = '(self_emp_gross_income - self_emp_gross_expens)'; break; case 'shl_hrs': $top = 'shl_gross_wages'; break; }
					$clause = "SUM(IF(`regions`.`region` = '$region', $col, 0))";
					$cols .= $sep . "FORMAT(AVG(IF(`regions`.`region` = '$region', IF($col > 0, $top/$col, 0), NULL)), 2)";
					break;
			}
			$sep = $cols ? ', ' : '';
		}
		$where = self::getFilterClause('region	');
		$db = Database::getDatabase();
		print "SELECT $cols FROM `mdda_consumers` WHERE `regions`.`region` IS NOT NULL AND `regions`.`region` <> '' $where GROUP BY `reporting_period`";
		$rs = $db->query("SELECT $cols FROM `mdda_consumers` LEFT JOIN `mdda_providers` `providers` ON `mdda_consumers`.`provider_id` = `providers`.`provider_id` LEFT JOIN `mdda_regions` `regions` ON `mdda_consumers`.`resp_region` = `regions`.`region_id` LEFT JOIN `mdda_area_offices` `counties` on `mdda_consumers`.`area_office_id` = `counties`.`area_office_id` WHERE `regions`.`region` IS NOT NULL AND `regions`.`region` <> '' $where GROUP BY `reporting_period_id`");
		return $db->num_rows($rs) > 0 ? $db->fetch_row($rs) : array();
	}
	
	static function getProviderComparisonArray($variable) {
		$f		= dda::getFilterValues();
		$cols	= '';
		$sep	= '';
		$pos	= strpos($variable, '_');
		$type	= substr($variable, 0, $pos);
		$total	= strpos($variable, '_total_') === $pos; 
		$col	= $pos !== false ? substr($variable, ($total ? 6 : 0) + $pos + 1) : '1';
		$yesNo	= strpos($col, 'YN') !== false || $col == 'IndSupEmp' || $col == 'GroupSupEmp';
		$clause = '';
		if (strpos($region, "x_") === 0) {
			$clause .= ($f['region'] == 'x_West' || $f['region'] == 'x_Central' ? "LEFT(CRS_Contract, 1)" : "`CRS_contract`")
					 . " IN (" . self::getContractNumbers(substr($f['region'], 2)) . ") AND ";
		}
		$clause .= $yesNo ? "TRIM($col) = 'Y'" : "IFNULL($col, 0) > 0";
		switch ($type) {
			case 'Num': $cols .= $sep . "SUM($clause)";	$sort = $cols; break;
			case 'Per':
				$bottom = $yesNo ? "SUM($col IN ('Y', 'N'))" : ($total ? 'totalHours' : 'COUNT(1)');
				$cols .= $sep . "IF($bottom > 0, FORMAT((SUM($clause) / $bottom) * 100, 2), 0)";
				$sort = "SUM($clause) / $bottom";
				break;
			case 'Avg':	 $cols .= $sep . "FORMAT(AVG($col), 2)"; $sort = "AVG($col)"; break;
			case 'Mean':
				switch ($col) {
					case 'indv_comp_hrs': $top = 'dol_ind'; break;
					case 'HrsGroup': $top = 'dol_group'; break;
					case 'Fac': $top = 'dol_facility'; break;
				}
				$cols .= $sep . "FORMAT(AVG($top/$col), 2)";
				$sort = "AVG($top/$col)";
				break;
		}
		$where	= dda::getFilterClause('comparison');
		$i	 = 1;
		$ret = array();
		$db  = Database::getDatabase();
		$rs  = $db->query("SELECT $cols AS `var`, `mdda_consumers`   .`provider_id` `providerno`, `providers`.`Vendor` `providername` FROM `mdda_consumers` LEFT JOIN `mdda_regions` `regions` ON `mdda_consumers`.`resp_region` = `regions`.`region_id` LEFT JOIN `mdda_providers` `providers` ON `mdda_consumers`.`provider_id` = `providers`.`provider_id` WHERE `regions`.`region` IS NOT NULL AND `regions`.`region` <> '' $where GROUP BY `providers`.`Vendor` ORDER BY $sort DESC");
		while ($row = $db->fetch_assoc($rs)) {
			$key = !$f['provider'] || $f['provider'] == $row['providerno'] ? $row['providername'] : $i;
			$ret[$key] = $row['var'];
			$i++;
		}
		return $ret;
	}

	static function getTrendVariableArray($variable) {
		$f		= dda::getFilterValues();
		$cols	= '';
		$sep	= '';
		$pos	= strpos($variable, '_');
		$type	= substr($variable, 0, $pos);
		$total	= strpos($variable, '_total_') === $pos; 
		$col	= $pos !== false ? substr($variable, ($total ? 6 : 0) + $pos + 1) : '1';
		$yesNo	= strpos($col, 'YN') !== false || $col == 'IndSupEmp' || $col == 'GroupSupEmp';
		$clause = '';
		if (strpos($f['region'], "x_") === 0) {
			$clause .= ($f['region'] == 'x_West' || $f['region'] == 'x_Central' ? "LEFT(CRS_Contract, 1)" : "`CRS_contract`")
					 . " IN (" . self::getContractNumbers(substr($f['region'], 2)) . ") AND ";
		}
		$clause .= $yesNo ? "TRIM($col) = 'Y'" : "IFNULL($col, 0) > 0";
		switch ($type) {
			case 'Num': $cols .= $sep . "SUM($clause)"; break;
			case 'Per':
				$bottom = $yesNo ? "SUM($col IN ('Y', 'N'))" : ($total ? 'totalHours' : 'COUNT(1)');
				$cols .= $sep . "IF($bottom > 0, FORMAT((SUM($clause) / $bottom) * 100, 2), 0)";
				break;
			case 'Avg':	 $cols .= $sep . "FORMAT(AVG($col), 2)"; break;
			case 'Mean':
				switch ($col) {
					case 'indv_comp_hrs': $top = 'dol_ind'; break;
					case 'HrsGroup': $top = 'dol_group'; break;
					case 'Fac': $top = 'dol_facility'; break;
				}
				$cols .= $sep . "FORMAT(AVG($top/$col), 2)";
				break;
		}
		$where	= dda::getFilterClause('trends');
		$i	 = 1;
		$ret = array();
		$db  = Database::getDatabase();
		$rs  = $db->query("SELECT $cols AS `var`, `mdda_consumers`.`reporting_period_id` `repperiod` FROM `mdda_consumers` LEFT JOIN `mdda_regions` `regions` ON `mdda_consumers`.`resp_region` = `regions`.`region_id` WHERE `regions`.`region` IS NOT NULL AND `regions`.`region` <> '' $where GROUP BY `mdda_consumers`.`reporting_period_id` ORDER BY `mdda_consumers`.`reporting_period_id`");
		while ($row = $db->fetch_assoc($rs)) {
			$ret[$row['`mdda_consumers`.`reporting_period_id`']] = $row['var'];
		}
		return $ret;
	}

/*
	function: getActivityVariableArray
	purpose: return the values in each column for an activity query
*/
	static function getActivityVariableArray($type) {
		if (empty($type)) {
			return array('error' => 'Please Select a variable on the previous page.');
		}
		$labels = self::getActivityColumnNamesArray($type);
		$f		= self::getFilterValues();
		$where = self::getFilterClause('activity');

		switch ($type) {
			case 'totalwages': 				$vars = array('dol_ind', 'dol_Group', 'dol_Facility');	break;
			case 'meanwage':				$vars = array('dol_ind', 'dol_Group', 'dol_Facility'); break;
			case 'numbernewjobin12months':	$vars = array('NewIndJob');	break;
			case 'numberminimum': 			$vars = array('YNInd', 'YNGroup', 'YNFacility');	break;
			case 'percentminimum':			$vars = array('YNInd', 'YNGroup', 'YNFacility');	 break;
			case 'meanhourlywage':			$vars = array('indv_comp_hrs', 'dol_ind', 'HrsGroup', 'dol_Group', 'hrsFac', 'dol_Facility'); break;
			case 'numberemployed10of12':	$vars = array('IndSupEmp', 'GroupSupEmp');	break;
			default: 						$vars = array('indv_comp_hrs', 'HrsGroup', 'HrsFac', 'HrsVolunteer', 'HrsTransition');
			
		}
		if ($type == 'precentemployed10of12' && $f['year'] == 2009) {
			$cols	= "(SUM(`IndSupEmp` = 'Y') / SUM(`Indv_intg_empl_participate`  = 0)) * 100 AS `{$labels[0]}`"
					. "(SUM(`GroupSupEmp` = 'Y') / SUM(`HrsGroup` > 0 OR `dol_Group` > 0)) * 100 AS `{$labels[1]}`";
		} else if ($type == 'precentemployed10of12') {
			$cols	= "IF(SUM(indv_comp_hrs > 0 OR dol_ind > 0) + SUM(IndSupEmp = 'Y' AND (`indv_comp_hrs` = 0 OR `dol_ind` = 0)) > 0, (SUM(`IndSupEmp` = 'Y') / (SUM(indv_comp_hrs > 0 OR dol_ind > 0) + SUM(IndSupEmp = 'Y' AND (`indv_comp_hrs` = 0 OR `dol_ind` = 0)))) * 100 AS `{$labels[0]}`"
					. "IF(SUM(HrsGroup > 0 or dol_Group > 0) + SUM(`GroupSupEmp` = 'Y' AND (`HrsGroup` = 0 OR `dol_Group` = 0)) > 0, (SUM(`GroupSupEmp` = 'Y') / (SUM(`HrsGroup` > 0 or `dol_Group` > 0) + SUM(`GroupSupEmp` = 'Y' AND (`HrsGroup` = 0 OR `dol_Group` = 0)))) * 100, 0) AS `{$labels[1]}`";
		} else {
			$cols = '';
			$sep = '';
			for ($i = 0; $i < count($vars); $i++) {
				$col = $vars[$i];
				$cols .= $sep;
				switch ($type) {
					case 'numberinactivity':		$cols .= "SUM((IFNULL(`$col`, 0) > 0)) AS `{$labels[$i]}`";		break;
					case 'percent':					$cols .= "FORMAT((SUM((IFNULL(`$col`, 0) > 0)) / COUNT(1)) * 100, 2) AS `{$labels[$i]}`"; break;
					case 'totalhours':
					case 'totalwages':				$cols .= "SUM(IF(`$col` AND 1, `$col`, 0)) AS `{$labels[$i]}`";	break;
					case 'meanhours':
					case 'meanwage':				$cols .= "FORMAT(AVG(IF(`$col` AND 1, $col, NULL)), 2) AS `{$labels[$i]}`";	break;
					case 'numberminimum':
					case 'numbernewjobin12months':	$cols .= "SUM(TRIM(`$col`) = 'Y') AS `{$labels[$i]}`";	break;
					case 'percentminimum':			$cols .= "FORMAT((SUM(TRIM(`$col`) = 'Y') / SUM(TRIM(`$col`) IN ('N', 'Y'))) * 100, 2) AS `{$labels[$i]}`";	break;
					case 'meanhourlywage':			$cols .= "FORMAT(AVG(IF(`{$vars[$i + 1]}` AND `$col`, `{$vars[$i + 1]}` / `$col`, null)), 2) AS `{$labels[$i/2]}`"; $i++; break;
					case 'numberemployed10of12': 	$cols .= "SUM(`$col` = 'Y') AS `{$labels[$i]}`";	break;
				}
				$sep = $cols ? ",\n" : '';
			}
		}
		$db = Database::getDatabase();
		$cols = "REPLACE(" . substr(preg_replace("/ AS `(.+?)`(?:,\n)?/", ", ',', '') AS `\\1`,\nREPLACE(", $cols), 0, -10);
		$rs = $db->query("SELECT $cols from `mdda_consumers` where `region` is not null and `region` != '' $where GROUP BY `reporting_period`");
		return $db->num_rows($rs) > 0 ? $db->fetch_assoc($rs) : array();
	}

/*
	function: getProvidersArray
	purpose: returns an array of providers in a region
*/
	static function getProvidersArray($region) {
		static $ret = array();
		if (count($ret) > 0) {
			return $ret;
		}
		$db = Database::getDatabase();
		if ($region == "ALL") {
			$query = "SELECT distinct `providers`.`Vendor` `vendor` from mdda_consumers LEFT JOIN `mdda_providers` `providers` ON `mdda_consumers`.`provider_id` = `providers`.`provider_id` LEFT JOIN `mdda_regions` `regions` ON `mdda_consumers`.`resp_region` = `regions`.`region_id` where  `resp_region` is not null and `resp_region` != '' order by `providers`.`Vendor`";
		} else if (strpos($region, "x_") === 0) {
			$region = substr($region, 2);
			if ($region == 'West' || $region == 'Central') {
				$where = "LEFT(CRS_Contract, 1) = " . self::getContractNumbers($region) . "";
			} else {
				$where = "`regions`.`region` is not null and `regions`.`region` != ''";
			}
		} else {
			$where = "`regions`.`region` = '$region'";
		}
		$rs = $db->query("SELECT distinct `providers`.`Vendor` `vendorname` from mdda_consumers LEFT JOIN `mdda_providers` `providers` ON `mdda_consumers`.`provider_id` = `providers`.`provider_id` WHERE $where order by `vendorname`");
		while ($row = $db->fetch_assoc($rs)) {
			$ret[] =  $row['vendorname'];
		}
		return $ret;
	}

/*
	function: getRowData
	purpose: outputs a row in the report
*/
	static function getRowData($report, $subreport, $level = 'provider') {
		$f		= dda::getFilterValues();
		$extra	= !$f['year'] || $f['year'] >= 2007;
		$hours	= array('indv_comp_hrs', 'indv_cont_hrs', 'grp_integ_hrs', 'self_emp_hrs', 'fac_non_work_hrs');
		
		$cols = 'count(1) ' . ($f['year'] > 2005 ? ",\nSUM(`NewIndJob` = 'Y')" : '');
		if ($subreport == "number") {
			foreach ($hours as $col) {
				$cols  .= ",\nSUM(IFNULL($col, 0) > 0)";
			}
			foreach ($hours as $col) {
				$cols  .= ",\nIF(COUNT(1) > 0, REPLACE(FORMAT((SUM(IFNULL($col, 0) > 0) / COUNT(1)) * 100, 1), ',', ''), 0)";
			}
		} elseif ($subreport =="hours") {
			foreach ($hours as $col) {
				$cols .= ",\nFORMAT(AVG(IF($col > 0, $col, NULL)), 2)";
			}
			foreach ($hours as $col) {
				$cols .= ",\nIF(SUM(IF($col > 0 OR $col = 0, `totalHours`, 0)) > 0, REPLACE(FORMAT((SUM(IF($col > 0, $col, 0)) / SUM(IF($col > 0 OR $col = 0, `totalHours`, 0))) * 100, 1), ',', ''), 0)";
			}
		} elseif ($subreport == "wage") {
			$wages	= array('dol_ind', 'dol_Group', 'dol_Facility');
			foreach ($wages as $col) {
				$cols  .= ",\nREPLACE(FORMAT(AVG(IF($col > 0, $col, NULL)), 2), ',', '')";
			}
			$wages	= array('YNInd', 'YNGroup', 'YNFacility');
			foreach ($wages as $col) {
				$cols  .= ",\nIF(SUM(TRIM($col) IN ('N','Y')) > 0, REPLACE(FORMAT((SUM(TRIM($col) ='Y') / SUM(TRIM($col) IN ('N','Y'))) * 100, 1), ',', ''), 0)";
			}
		}
		$having	= '(0' . str_repeat(',0', substr_count($cols, ",\n")) . ") <> ($cols)";
		$where	= dda::getFilterClause($report);
		
		$sql = "SELECT CONCAT('<aa/><strong>', `providers`.`Vendor`, '</strong>') AS `grouping`, $cols FROM `mdda_consumers` LEFT JOIN `mdda_providers` `providers` ON `mdda_consumers`.`provider_id` = `providers`.`provider_id` WHERE `region` IS NOT NULL AND `region` <> '' $where GROUP BY `provider_id` HAVING $having\n";
		if ($report == 'individual' && $f['region']) {
			$sql .= 'UNION ' . "SELECT '<rr/><strong>{$f['region']}</strong>', $cols FROM `mdda_consumers` left join `mdda_regions` `regions` ON `mdda_consumers`.`resp_region` = `regions`.`region_id` WHERE `regions`.`region` = '{$f['region']}' AND `reporting_period` = {$f['year']} GROUP BY `region` HAVING $having\n"; 
		}
		if ($report == 'individual') {
			$sql .= 'UNION ' . "SELECT '<zz/><strong>State</strong>', $cols FROM `mdda_consumers` WHERE `region` IS NOT NULL AND `region` <> '' AND `reporting_period` = {$f['year']} GROUP BY `reporting_period` HAVING $having\n"; 
		}
		print "<!-- $sql\n-->";
		$db = Database::getDatabase();
		$rs = $db->query($sql . ' ORDER BY `grouping`');
		$html = '';
		while ($row = $db->fetch_assoc($rs)) {
			$html .= "<td>" . implode('</td><td>', $row) . '</td></tr>';
		}
		return $html;
	}

	static function getYearSelect($name, $val) {
		$name = htmlentities($name, ENT_COMPAT, 'UTF-8');
		$html = "<select id=\"$name\" name=\"$name\">";
		$db = Database::getDatabase();
		$rs = $db->query('SELECT DISTINCT `period`.`start_date` AS `y` FROM `mdda_consumers` LEFT JOIN `mdda_reporting_period` `period` ON `mdda_consumers`.`reporting_period_id` = `period`.`id` order by `y` ');
		while ($row = $db->fetch_assoc($rs)) {
         $repperiod = date('M Y',strtotime($row['y']));
			$selected = $val == $repperiod ? ' selected="selected"' : '';
			$html .= "<option$selected>{$repperiod}</option>";
		}
		return $html . '</select>';
	}
}

<?php
/**
 * useful functions for DDS.
 *
 * @package dds
 * @author Chris Nagle
 */
class mdda {
	const FLAG_YN_PTO_IN_COMP = 1, FLAG_YN_PTO_IN_CONT = 2, FLAG_YN_PTO_GRP_INT = 4, FLAG_YN_PTO_FAC = 8, FLAG_YN_SETA_IN_CONT = 1, FLAG_YN_SETA_GRP_INT = 2, FLAG_YN_SETA_FAC = 4;


	static private $vars = null;
	function __construct() {}


   	static public function getFlags() {
   		return array(self::FLAG_YN_PTO_IN_COMP, self::FLAG_YN_PTO_IN_CONT, self::FLAG_YN_PTO_GRP_INT, self::FLAG_YN_PTO_FAC);
   	}
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
		$rs = $db->query("SELECT YEAR(NOW()) - MAX(YEAR(`dob`)) AS `min`, YEAR(NOW()) - MIN(YEAR(`dob`)) AS `max` FROM `spec_mdda6` ");
		$range = $db->fetch_assoc($rs);
		$age = '<option value="">All</option>';
		for ($i = max($range['min'], 15); $i <= $range['max']; $i++) {
			$age .= "<option>$i</option>";
		}

		return '<p><label for="y">Select ' . ($report == 'trends' ? 'start' : '') . ' year:</label> ' . self::getYearSelect('y', $f['year']) . '</p>'
				. ($report != 'region' && $report != 'individual' ? '<p><label for="r">Select region:</label> ' . self::getRegions("r", $f['region']) . "</p>"
					. '<p><label for="ao">Select county:</label> ' . self::getAreaOffices('ao', $f['areaOffice']) . "</p>" : '')
				. ($report != 'region' && $report != 'provider' ? '<p><label for="p">Select provider</label> ' . self::getProviders('p', $f['provider']) . '</p>' : '')
				. '<p><label>Select age:</label> <label for="f">from</label> <select id="f" name="age[from]">'
				. str_replace("<option>{$f['from']}</option>", "<option selected=\"selected\">{$f['from']}</option>", $age)
				. '</select> <label for="t">to</label> <select id="t" name="age[to]">'
				. str_replace("<option>{$f['to']}</option>", "<option selected=\"selected\">{$f['to']}</option>", $age)
				. '</select></p>'
            . ($report == 'activity' ? '<p><label for="sumtype">Select Summary Type</label> <select id="sumtype" name ="sumtype"><option value="">Type of summary</option><option value="wages">Wages</option><option value="hours">Hours Worked</option><option value="selfEmployment">Self Employment</option></select></p>' : '');
	}

	static function getFilterValues() {
		return array('year' => !empty($_REQUEST['y']) ? $_REQUEST['y'] : '',
			'region' => !empty($_REQUEST['r']) ? $_REQUEST['r'] : '',
			'areaOffice' => !empty($_REQUEST['ao']) ? $_REQUEST['ao'] : '',
			'provider' => !empty($_REQUEST['p']) ? $_REQUEST['p'] : '',
			'from' => !empty($_REQUEST['age']['from']) && $_REQUEST['age']['from'] > 0 ? abs($_REQUEST['age']['from']) : (!empty($_REQUEST['f']) && $_REQUEST['f'] > 0 ? abs($_REQUEST['f']) : 0),
         'sumtype' => !empty($_REQUEST['sumtype']) ? $_REQUEST['sumtype'] : '',
			'to' => !empty($_REQUEST['age']['to']) && $_REQUEST['age']['to'] > 0 ? abs($_REQUEST['age']['to']) : ( !empty($_REQUEST['t']) && $_REQUEST['t'] > 0 ? abs($_REQUEST['t']) :0));
	}

	static function getURLValues() {
		return array('y' => !empty($_REQUEST['y']) ? abs($_REQUEST['y']) : 0,
			'r' => !empty($_REQUEST['r']) ? $_REQUEST['r'] : '',
			'ao' => !empty($_REQUEST['ao']) ? $_REQUEST['ao'] : '',
			'p' => !empty($_REQUEST['p']) ? $_REQUEST['p'] : '',
			'from' => !empty($_REQUEST['age']['from']) && $_REQUEST['age']['from'] > 0 ? abs($_REQUEST['age']['from']) : 0,
         'sumtype' => !empty($_REQUEST['sumtype']) ? $_REQUEST['sumtype'] : '',
			'to' => !empty($_REQUEST['age']['to']) && $_REQUEST['age']['to'] > 0 ? abs($_REQUEST['age']['to']) : 0);
	}

	static function getFilterClause($report) {
		$f = self::getFilterValues();
		$where	= " AND DATE_FORMAT(`Reporting_Period`,'%M %Y') " . ($report == 'trends' ? '>' : '') . "= " . "'{$f['year']}'";
		if ($f['to'] && $f['from']) {
			$where .= ' AND `dob` BETWEEN DATE_ADD(MAKEDATE(YEAR(`reporting_period`), 92), INTERVAL -' . $f['to']
					. ' YEAR) AND DATE_ADD(MAKEDATE(YEAR(`reporting_period`), 92), INTERVAL -' . $f['from'] . ' YEAR)';
		} else if ($f['to']) {
			$where .= ' AND `dob` < DATE_DIFF(MAKEDATE(YEAR(`reporting_period`), 92), INTERVAL -' . $f['to'] . ' YEAR)';
		} else if ($f['from']) {
			$where .= ' AND `dob` > DATE_DIFF(MAKEDATE(YEAR(`reporting_period`), 92), INTERVAL -' . $f['from'] . ' YEAR)';
		}
		if ($report == 'region') {
			return $where;
		}
		if ($f['region'] && $f['region'] != "all") {
			if (strpos($f['region'], "x_") === 0) {
				$contractNumbers = $this->getContractNumbers(substr($f['region'], 2));
				$where .= $f['region'] == 'x_West' || $region == 'x_Central' ? " AND LEFT(CRS_Contract, 1) = '$contractNumbers' " : " AND CRS_Contract in ($contractNumbers) ";
			} else {
				$where .= " AND region = '{$f['region']}' ";
			}
		}
		if ($f['areaOffice']) { $cleanoffice = mysql_real_escape_string($f['areaOffice']);
			$where .= " AND `area_office` = '$cleanoffice'";
		}
		if ($report != 'comparison' && $f['provider'] && $$f['provider'] != 'ALL') {
			$where .= " AND Vendor_ID = '{$f['provider']}' ";
		}
		return $where;
	}

	static function serializeFilters() {
		$ret = '';
		$sep = '';
		foreach (mdda::getFilterValues() as $f => $v) {
			if (!empty($v)) {
				$ret .= "$sep$f=$v";
				$sep = "&amp;";
			}
		}
		return $ret;
	}

	static function serializeURL() {
		$ret = '';
		$sep = '';
		foreach (mdda::getURLValues() as $f => $v) {
			if (!empty($v)) {
				$ret .= "$sep$f=$v";
				$sep = "&amp;";
			}
		}
		return $ret;
	}

	static function passFilters() {
		$ret = '';
		foreach (mdda::getFilterValues() as $f => $val) { ;
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
		$where = $provider == '0' ? "`region` != 'x'" : "`Vendor_ID` = '$provider'";
		$sql = "SELECT distinct `region` AS `val`, `region` AS `opt` from `spec_mdda6` where $where and `Region` IS NOT NULL AND `Region` <> ''";
		if ($_SERVER['PHP_AUTH_USER'] =='dmruser') {
			if ($regiontype == 'normal') {
				$sql .= " UNION SELECT 'x_Berkshire', 'Berkshire' UNION SELECT 'x_Holyoke/Chicopee', 'Holyoke/Chicopee' UNION SELECT 'x_West', 'West' UNION SELECT 'x_Central', 'Central'";
			} else {
				$sql   .= " UNION SELECT DISTINCT 'x_Berkshire', 'Berkshire' from `spec_mdda6` where vendor_id = '$provider' and `region` and CRS_contract in (" . self::getContractNumbers('Berkshire') . ")"
						. " UNION SELECT DISTINCT 'x_Franklin/Hampshire', 'Franklin/Hampshire' from spec_mdda6 where vendor_id = '$provider' and `region` and CRS_contract in (" . self::getContractNumbers('Franklin/Hampshire') . ")"
						. " UNION SELECT DISTINCT 'x_Springfield/Westfield', 'Springfield/Westfield' from spec_mdda6 where vendor = '$provider' and `region` and `CRS_contract` in (" . self::getContractNumbers('Springfield/Westfield') . ")"
						. " UNION SELECT DISTINCT 'x_Holyoke/Chicopee', 'Holyoke/Chicopee' from spec_mdda6 where vendor_id = '$provider' and `region` and `CRS_contract` in (" . self::getContractNumbers('Holyoke/Chicopee') . ")"
						. " UNION SELECT DISTINCT 'x_West', 'West' from spec_mdda6 where vendor_id = '$provider' and `region` and LEFT(CRS_Contract, 1) = " . self::getContractNumbers('West')
						. " UNION SELECT DISTINCT 'x_Central', 'Central' from spec_mdda6 where vendor_id = '$provider' and `region` and LEFT(CRS_Contract, 1) = " . self::getContractNumbers('Central');
			}
		}

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
		$rs = $db->query("SELECT distinct region from spec_mdda6 where `vendor` = '$provider' and `region` order by `region`");
		while ($row = $db->fetch_assoc($rs)) {
			$ret[] = $row['region'];
		}
		return $ret;
	}

	static function getRegionArrayById($provider_id) {
		$db	 = Database::getDatabase();
		$ret = array();
		$vendor = "Vendor_ID = '$provider_id'";
		if ($provider_id == "all") {
			$vendor = "";
		}
		$rs  = $db->query("SELECT distinct region from spec_mdda6 where $vendor and TRIM(`region`) order by region");
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
				. ' AND DATE_FORMAT(`Reporting_Period`,\'%M %Y\') = \'' . $year . '\'';
		$db = Database::getDatabase();
		$rs = $db->query('SELECT DISTINCT `area_office` FROM `spec_mdda6` WHERE ' . $where . ' ORDER BY `area_office`');
		while ($row = $db->fetch_assoc($rs)) {
			$selected = isset($_REQUEST[$elementName]) && $_REQUEST[$elementName] == $row['area_office'] ? ' selected="selected"' : '';
			$html .= "<option$selected>{$row['area_office']}</option>";
		}
		return "<select id=\"$elementName\" name=\"$elementName\"><option value=\"\">All counties</option>$html</select>";
	}

     /*
	 function: getProviders
	 purpose: returns a dropdown of providers in a given region
     */
	static function getProviders($element_name, $region = 'ALL', $showAll = 1) {
		$db = Database::getDatabase();

		$where = self::getRegionClause($region);

		$rs = $db->query("SELECT distinct `Vendor`, `Vendor_ID` FROM `spec_mdda6` WHERE $where ORDER BY `Vendor`");
		$html = "<select id=\"$element_name\" name=\"$element_name\">";
		if ($showAll == 1) {
			$html .= "<option value=\"\">All Providers</option>";
		}
		while ($row = $db->fetch_assoc($rs)) {
			$selected = isset($_REQUEST[$element_name]) && $_REQUEST[$element_name] == $row['val'] ? ' selected="selected"' : '';
			$html .= "<option value=\"{$row['Vendor_ID']}\"$selected>{$row['Vendor']}</option>";
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
			'numberemployed10of12' => 'Number employed for 10 of the last 12 months', 'paidtimeoff' => 'Percent employed for 10 of the last 12 months',
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

			case 'meanwage':
			case 'numberminimum':
			case 'percentminimum':

	/*		return array('Individual Competitive Job', 'Individual Contracted Job','Group Integrated Job', 'Facility Based/Sheltered Job','Community Based Non Work','Facility Based Non Work');*/

            case 'percent2':
   			case 'numberinactivity2':
            case 'numberinactivity':
            case 'percent':
   				return array('Individual Competitive Job', 'Individual Contracted Job','Group Integrated Job', 'Facility Based/Sheltered Job','Self Employment','Community Based Non Work','Volunteer Job','Facility Based Non Work','No Activity Participation');

   			case 'totalwages':

   				return array('Individual Competitive Job', 'Individual Contracted Job','Group Integrated Job', 'Facility Based/Sheltered Job');
			case 'numberemployed10of12':
			case 'selfEmpnum':
         case 'selfEmpperc':
				return array('Number in self employment');
			case 'paidtimeoff':	return array('Individual Competitive Job', 'Individual Contracted Job','Group Integrated Job', 'Facility Based/Sheltered Job');
        case 'setaside':	return array('Individual Contracted Job','Group Integrated Job', 'Facility Based/Sheltered Job');
			case 'numbernewjobin12months':	return array('Individual Competitive Job', 'Individual Contracted Job','Group Integrated Job','Self Employment', 'Facility Based/Sheltered Job');
			case 'meanhourlywage':
				return array('Individual Competitive Job', 'Individual Contracted Job','Group Integrated Job','Facility Based/Sheltered Job');

            case 'meanSelfemp':
            case 'totalSelfemp':
            case 'lowSelfemp':
            case 'highSelfemp':
			return array('Hours worked in self employment<br />(2 week reporting period)', 'Gross business income<br />over 3 months','Gross business expenses<br />over 3 months', 'Net income<br />over 3 months<br />(income - expenses)');
			case 'totalhours' :
			return array('Individual Competitive Job', 'Individual Contracted Job','Group Integrated Job','Facility Based/Sheltered Job','Self Employment', 'Community Based Non Work');
			case 'avghours' :
			case 'numover20':
			case 'percover20':
			return array('Individual Competitive Job', 'Individual Contracted Job','Group Integrated Job','Facility Based/Sheltered Job','Self Employment', 'Community Based Non Work');
			case 'percvol':
			return array('Individual Competitive Job', 'Individual Contracted Job','Group Integrated Job', 'Facility Based/Sheltered Job','Community Based Non Work','Facility based non work');
			 default:
				return array('Individual Competitive Job', 'Individual Contracted Job','Group Integrated Job', 'Facility Based/Sheltered Job','Self Employment','Community Based Non Work
				','Facility based non work'); 
		}
	}

/*
	function: getActivityColumnNamesArray
	purpose: return the column names for an activity
*/
	static function getRegionColumnNamesArray ($year = "any") {
		$db = Database::getDatabase();
		$rs = $db->query("SELECT DISTINCT `region` FROM `spec_mdda6` WHERE `region` IS NOT NULL AND `region` <> '' order by `region`");

		$ret = array();
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


       $rep_period = self::getReportingDates($f['year']);
		$legend	= ($f['provider'] ? " for " . self::getProviderName($f['provider']) : " for all providers ")
				. ($f['areaOffice'] ? " for {$f['areaOffice']} County" : " in all counties")
				. ($f['region'] && $f['region'] != 'all' ? " in the {$f['region']} region" : " in all regions") . " during the  {$f['year']} Reporting Period"
				. ($f['from'] && $f['to'] ? " between {$f['from']} and {$f['to']}" : '')
				. (!($f['from'] && $f['to']) && $f['from'] ? " {$f['from']} and older" : '')
				. (!($f['from'] && $f['to']) && $f['to'] ? " {$f['to']} and younger" : '');
		switch ($variable) {
			case 'numberinactivity':	return "Number participating in activity" . $legend;
			case 'percent':				return "Wages Summary" . $legend;
			case 'hoursumm':			return "Hours Summary" . $legend;
			case 'selfEmployment':			return "Self Employment Summary" . $legend;
			case 'meanhours':			return "Mean hours per activity" . $legend;
			case 'totalwages':			return "Total wages per activity" . $legend;
			case 'meanwage':			return "Mean wage per activity" . $legend;
			case 'numberminimum':		return "Number earning at least minimum wage" . $legend;
			case 'percentminimum':		return "Percent earning at least minimum wage" . $legend;
			case 'meanhourlywage':		return "Mean hourly wage for individual, group and facility employment" . $legend;
			case 'numberemployed10of12':	return "Number employed for 10 of the last 12 months" . $legend;
			case 'paidtimeoff':	return "Percent employed for 10 of the last 12 months" . $legend;
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
	static function getProviderName($vendor_id) {
	//	if (empty($vendor_id)) {
//		return 'All Providers';
//		}
		$db = Database::getDatabase();
		$rs = $db->query("SELECT distinct `Vendor` from `spec_mdda6` where `Region` is not null and `Region` != '' and `Vendor_ID` = '" . $vendor_id . "'" );
		if ($db->num_rows($rs) > 0) {
			$rs = $db->query("SELECT distinct `Vendor` from `spec_mdda6` where `Vendor_ID` = '" . $vendor_id . "'");
		}
		return $db->num_rows($rs) > 0 ? $db->fetch_result($rs, 0, 'Vendor') : "";
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
		$yesNo	= strpos($col, 'YN') !== false || $col == 'YN_pto' || $col == 'YN_pto';
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
					$bottom = $yesNo ? "SUM(`region` = '$region' AND $col IN ('Y', 'N'))" : ($total ? "SUM(IF(`region` = '$region', `totalHours`, 0))" : "SUM(`region` = '$region')");
					$cols .= $sep . "IF($bottom > 0, FORMAT((SUM($clause) / $bottom) * 100, 2), 0)";
					break;
				case 'Avg':	 $cols .= $sep . "FORMAT(AVG(IF(`region` = '$region', $col, NULL)), 2)";	break;
				case 'Mean':
					switch ($col) { case 'HrsIndComp': $top = 'dol_indComp'; break; case 'HrsGroupInt': $top = 'dol_GroupInt'; break; case 'Fac': $top = 'dol_facility'; break; }
					$clause = "SUM(IF(`region` = '$region', $col, 0))";
					$cols .= $sep . "FORMAT(AVG(IF(`region` = '$region', IF($col > 0, $top/$col, 0), NULL)), 2)";
					break;
			}
			$sep = $cols ? ', ' : '';
		}
		$where = self::getFilterClause('region	');
		$db = Database::getDatabase();
//		print "SELECT $cols FROM `spec_mdda6` WHERE `region` IS NOT NULL AND `region` <> '' $where GROUP BY `reporting_period`";
		$rs = $db->query("SELECT $cols FROM `spec_mdda6` WHERE `region` IS NOT NULL AND `region` <> '' $where GROUP BY `reporting_period`");
		return $db->num_rows($rs) > 0 ? $db->fetch_row($rs) : array();
	}

	static function getProviderComparisonArray($variable) {
		$f		= mdda::getFilterValues();
		$cols	= '';
		$sep	= '';
		$pos	= strpos($variable, '_');
		$type	= substr($variable, 0, $pos);
		$total	= strpos($variable, '_total_') === $pos;
		$col	= $pos !== false ? substr($variable, ($total ? 6 : 0) + $pos + 1) : '1';
		$yesNo	= strpos($col, 'YN') !== false || $col == 'YN_pto' || $col == 'YN_pto';
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
					case 'HrsIndComp': $top = 'dol_indComp'; break;
					case 'HrsGroupInt': $top = 'dol_GroupInt'; break;
					case 'Fac': $top = 'dol_facility'; break;
				}
				$cols .= $sep . "FORMAT(AVG($top/$col), 2)";
				$sort = "AVG($top/$col)";
				break;
		}
		$where	= mdda::getFilterClause('comparison');
		$i	 = 1;
		$ret = array();
		$db  = Database::getDatabase();
		$rs  = $db->query("SELECT $cols AS `var`, `Vendor_ID`, `Vendor` FROM `spec_mdda6` WHERE `region` IS NOT NULL AND `region` <> '' $where GROUP BY `Vendor` ORDER BY $sort DESC");
		while ($row = $db->fetch_assoc($rs)) {
			$key = !$f['provider'] || $f['provider'] == $row['Vendor_ID'] ? $row['Vendor'] : $i;
			$ret[$key] = $row['var'];
			$i++;
		}
		return $ret;
	}

	static function getTrendVariableArray($variable) {
		$f		= mdda::getFilterValues();
		$cols	= '';
		$sep	= '';
		$pos	= strpos($variable, '_');
		$type	= substr($variable, 0, $pos);
		$total	= strpos($variable, '_total_') === $pos;
		$col	= $pos !== false ? substr($variable, ($total ? 6 : 0) + $pos + 1) : '1';
		$yesNo	= strpos($col, 'YN') !== false || $col == 'YN_pto' || $col == 'YN_pto';
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
					case 'HrsIndComp': $top = 'dol_indComp'; break;
					case 'HrsGroupInt': $top = 'dol_GroupInt'; break;
					case 'Fac': $top = 'dol_facility'; break;
				}
				$cols .= $sep . "FORMAT(AVG($top/$col), 2)";
				break;
		}
		$where	= mdda::getFilterClause('trends');
		$i	 = 1;
		$ret = array();
		$db  = Database::getDatabase();
		$rs  = $db->query("SELECT $cols AS `var`, DATE_FORMAT(`Reporting_Period`,'%M %Y') FROM `spec_mdda6` WHERE `region` IS NOT NULL AND `region` <> '' $where GROUP BY `reporting_period` ORDER BY `reporting_period`");
		while ($row = $db->fetch_assoc($rs)) {
			$ret[$row['reporting_period']] = $row['var'];
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
			case 'totalwages': 				$vars = array('dol_indComp','dol_indCont', 'dol_GroupInt', 'dol_Facility');	break;
			case 'meanwage':				$vars = array('dol_indComp','dol_indCont', 'dol_GroupInt', 'dol_Facility'); break;
			case 'numbernewjobin12months':	$vars = array('NewIndJob');	break;
			case 'numberminimum': 			$vars = array('YNInd', 'YNGroup', 'YNFacility');	break;
			case 'percentminimum':			$vars = array('YNInd', 'YNGroup', 'YNFacility');	 break;
			case 'meanhourlywage':			$vars = array('HrsIndComp', 'dol_indComp','HrsIndCont', 'dol_indCont', 'HrsGroupInt', 'dol_GroupInt', 'hrsFac', 'dol_Facility'); break;
			case 'numberemployed10of12':	$vars = array('YN_pto', 'YN_pto');	break;
			case 'paidtimeoff':	$vars = array('HrsIndComp','HrsIndCont', 'HrsGroupInt','HrsFac');	break;

         case 'percvol':

         	$vars = array('HrsIndComp','HrsIndCont', 'HrsGroupInt','HrsFac','HrsComNonWork');	break;
				 case 'percent2':
          case 'numberinactivity2':
          $vars = array('HrsIndComp','HrsIndCont', 'HrsGroupInt','HrsFac','HrsSelfEmp','com_non_work_partic','YN_vol','fac_non_work_partic');	break;
		 case 'avghours':
		 case 'numover20':
         case 'percover20':
         case 'totalhours':
         	$vars = array('HrsIndComp','HrsIndCont', 'HrsGroupInt','HrsFac','HrsSelfEmp','HrsComNonWork');	break;
             case 'numberinactivity':
              case 'percent' :
             	$vars = array('HrsIndComp','HrsIndCont', 'HrsGroupInt','HrsFac','HrsSelfEmp','HrsComNonWork','YN_vol','fac_non_work_partic');	break;
          case 'meanSelfemp':
          case 'totalSelfemp':
          case 'lowSelfemp':
          case 'highSelfemp':
          	$vars = array('HrsSelfEmp','dol_selfEmp', 'expens_selfEmp', 'net_selfEmp');	break;
          case 'setaside':	$vars = array('HrsIndCont', 'HrsGroupInt','HrsFac');	break;
           case 'selfEmpnum':	$vars = array('HrsSelfEmp');	break;
           case 'selfEmpperc':	$vars = array('HrsSelfEmp');	break;
			default: 						$vars = array('HrsIndComp','HrsIndCont', 'HrsGroupInt', 'HrsFac','HrsSelfEmp', 'HrsComNonWork', 'HrsFacNonWork');

		}
		 if ($type == 'paidtimeoff') {
			$cols	.= "FORMAT(SUM(IFNULL(`YN_pto`,0) & " . self::FLAG_YN_PTO_IN_COMP . " = " . self::FLAG_YN_PTO_IN_COMP . ")  / SUM(`HrsIndComp` > 0 OR `dol_indComp` > 0) * 100,1) AS `{$labels[0]}`"
         . "FORMAT(SUM(IFNULL(`YN_pto`,0) & " . self::FLAG_YN_PTO_IN_CONT . " = " . self::FLAG_YN_PTO_IN_CONT . ")  / SUM(`HrsIndCont` > 0 OR `dol_indCont` > 0) * 100,1) AS `{$labels[1]}`"
					. "FORMAT(SUM(IFNULL(`YN_pto`,0) & " . self::FLAG_YN_PTO_GRP_INT . " = " . self::FLAG_YN_PTO_GRP_INT . ")  / SUM(`HrsGroupInt` > 0 OR `dol_GroupInt` > 0) * 100,1) AS `{$labels[2]}`"
					. "FORMAT(SUM(IFNULL(`YN_pto`,0) & " . self::FLAG_YN_PTO_FAC . " = " . self::FLAG_YN_PTO_FAC . ")  / SUM(`HrsFac` > 0 OR `dol_Facility` > 0) * 100,1) AS `{$labels[3]}`";
		}

 else if ($type == 'setaside') {

        $cols	.= "FORMAT(SUM(IFNULL(`YN_sa`,0) & " . self::FLAG_YN_SETA_IN_CONT . " = " . self::FLAG_YN_SETA_IN_CONT . ")  / SUM(`HrsIndCont` > 0 OR `dol_indCont` > 0) * 100,1) AS `{$labels[0]}`"
					. "FORMAT(SUM(IFNULL(`YN_sa`,0) & " . self::FLAG_YN_SETA_GRP_INT . " = " . self::FLAG_YN_SETA_GRP_INT . ")  / SUM(`HrsGroupInt` > 0 OR `dol_GroupInt` > 0) * 100,1) AS `{$labels[1]}`"
					. "FORMAT(SUM(IFNULL(`YN_sa`,0) & " . self::FLAG_YN_SETA_FAC . " = " . self::FLAG_YN_SETA_FAC . ")  / SUM(`HrsFac` > 0 OR `dol_Facility` > 0) * 100, 1) AS `{$labels[2]}`";
		}

      else {
			$cols = '';
			$sep = '';
			for ($i = 0; $i < count($vars); $i++) {
				$col = $vars[$i];
				$cols .= $sep;
				switch ($type) {
					case 'numberinactivity':		$cols .= "SUM((IFNULL(`$col`, 0) > 0)) AS `{$labels[$i]}`";		break;


               case 'selfEmpnum':
               	$cols .= "SUM((IFNULL(`$col`, 0) > 0)) AS `{$labels[$i]}`";		break;
				
					case 'numberinactivity2':

               	$cols .= "SUM((IFNULL(`$col`, 0) > 0)) AS `{$labels[$i]}`";		break;
					case 'percent':					$cols .= "FORMAT((SUM((IFNULL(`$col`, 0) > 0)) / COUNT(1)) * 100, 1) AS `{$labels[$i]}`"; break;
					case 'percent2':
               case 'selfEmpperc':
               				$cols .= "FORMAT((SUM((IFNULL(`$col`, 0) > 0)) / COUNT(1)) * 100, 1) AS `{$labels[$i]}`"; break;


					case 'totalwages':				$cols .= "FORMAT(SUM(IF(`$col` AND 1, `$col`, 0)),2) AS `{$labels[$i]}`";	break;
               case 'totalSelfemp':
									$cols .= "FORMAT(SUM(IF(`$col` AND 1, `$col`, 0)),2) AS `{$labels[$i]}`";	break;
               case 'totalhours':
               	$cols .= "FORMAT(SUM(IF(`$col` AND 1, `$col`, 0)),1) AS `{$labels[$i]}`";	break;
					case 'meanhours':

               case 'meanSelfemp':
               			$cols .= "FORMAT(AVG(IF(`$col` AND 1, $col, NULL)), 2) AS `{$labels[$i]}`";	break;

         					case 'meanwage':

                        			$cols .= "FORMAT(AVG(IF(`$col` AND 1, $col, NULL)), 2) AS `{$labels[$i]}`";	break;
					case 'numberminimum':
					case 'numbernewjobin12months':	$cols .= "SUM(TRIM(`$col`) = 'Y') AS `{$labels[$i]}`";	break;
					case 'percentminimum':			$cols .= "FORMAT((SUM(TRIM(`$col`) = 'Y') / SUM(TRIM(`$col`) IN ('N', 'Y'))) * 100, 2) AS `{$labels[$i]}`";	break;
					case 'meanhourlywage':			$cols .= "FORMAT(AVG(IF(`{$vars[$i + 1]}` AND `$col`, `{$vars[$i+1]}` / `$col`, null)), 2) AS `{$labels[$i/2]}`"; $i++; break;
               case 'avghours':				$cols .= "FORMAT(SUM(IF(`$col` AND `$col` > 0 AND 1, `$col`, 0)) / SUM(IF(`$col` AND `$col` > 0 AND 1, 1, 0)),1) AS `{$labels[$i]}`";	break;

					case 'numberemployed10of12': 	$cols .= "SUM(`$col` = 'Y') AS `{$labels[$i]}`";	break;
               case 'numover20':				$cols .= "FORMAT(SUM(IF(`$col` AND 1 AND ($col / 2) > 20, 1,0)), 0) AS `{$labels[$i]}`";	break;

               case 'percover20':				$cols .= "FORMAT(SUM(IF(`$col` AND 1 AND ($col / 2) > 20, 1,0)) / SUM((IFNULL(`$col`, 0) > 0)) * 100, 1) AS `{$labels[$i]}`";	break;
                 case 'percvol':				$cols .= "FORMAT(SUM(IF(`$col` AND $col > 0 AND 1 AND `YN_vol` = 1  , 1,0)) / SUM((IFNULL(`$col`, 0) > 0)) * 100, 1) AS `{$labels[$i]}`";	break;

                  case 'lowSelfemp':				$cols .= "FORMAT(MIN(IF(`$col` IS NOT NULL , $col,NULL)),1) AS `{$labels[$i]}`";	break;
                  case 'highSelfemp':				$cols .= "FORMAT(MAX(IF(`$col` IS NOT NULL, $col, NULL)),1) AS `{$labels[$i]}`"; break;
				}
				$sep = $cols ? ",\n" : '';
			}
		}
		$db = Database::getDatabase();
		$cols = "REPLACE(" . substr(preg_replace("/ AS `(.+?)`(?:,\n)?/", ", ',', '') AS `\\1`,\nREPLACE(", $cols), 0, -10);
      if ($type == 'numberinactivity2' || $type == 'numberinactivity') $cols .= ', SUM((IFNULL(`HrsIndComp`, 0) = 0) AND (IFNULL(`HrsIndCont`, 0) = 0) AND (IFNULL(`HrsGroupInt`, 0) = 0) AND (IFNULL(`HrsFac`, 0) = 0) AND (IFNULL(`HrsSelfEmp`, 0) = 0) AND (IFNULL(`com_non_work_partic`, 0) = 0) AND (IFNULL(`YN_vol`, 0) = 0)) AS "No Activity Participation" ';

   if ($type == 'percent2' || $type == 'percent') $cols .= ", FORMAT((SUM((IFNULL(`HrsIndComp`, 0) = 0) AND (IFNULL(`HrsIndCont`, 0) = 0) AND (IFNULL(`HrsGroupInt`, 0) = 0) AND (IFNULL(`HrsFac`, 0) = 0) AND (IFNULL(`HrsSelfEmp`, 0) = 0) AND (IFNULL(`HrsComNonWork`, 0) = 0) AND (IFNULL(`YN_vol`, 0) = 0) AND (IFNULL(`fac_non_work_partic`, 0) = 0)) / COUNT(1)) * 100, 1) AS `No Activity Participation`";
		$rs = $db->query("SELECT $cols from `spec_mdda6` where `region` is not null and `region` != '' $where GROUP BY `reporting_period`");

		return $db->num_rows($rs) > 0 ? $db->fetch_assoc($rs) : array();
	}




	static function getActivityTotalArray($type) {

		$labels = 'Totals';
		$f		= self::getFilterValues();
		$where = self::getFilterClause('activity') . " AND (`HrsIndComp` >0 or `HrsIndCont` >0  or `HrsGroupInt` >0  or `HrsFac` > 0  or `HrsSelfEmp` >0 or HrsComNonWork > 0)";


	$vars = array('HrsIndComp', 'HrsGroupInt', 'HrsFac', 'HrsComNonWork', 'HrsTransition');

   switch ($type) {
      case 'grandtotal':
           $where = self::getFilterClause('activity') . "";
			$cols	= "count( DISTINCT `id`) totalparticipants";
         break;
         case 'grandtotalwages':

   			$cols	= "count( DISTINCT `id`) totalparticipants";
            $where = self::getFilterClause('activity') . "";
            break;

         case 'averagegrosswage':
         $cols = "FORMAT(SUM(IFNULL(`dol_indComp`,0) + IFNULL(`dol_indCont`,0) + IFNULL(`dol_GroupInt`,0)   + IFNULL(`dol_Facility`,0)) / count( DISTINCT `id`),2) avggrosswage";
         break;

         case 'averagehourly':
         $cols = "FORMAT(SUM(IFNULL(`dol_indComp`,0) + IFNULL(`dol_indCont`,0) + IFNULL(`dol_GroupInt`,0)  + IFNULL(`dol_Facility`,0)) / SUM(IFNULL(TotalHours,0)),2) averagehourly";
         break;

         case 'coltotwages':
         $cols = "FORMAT(SUM(IFNULL(`dol_indComp`,0) + IFNULL(`dol_indCont`,0) + IFNULL(`dol_GroupInt`,0)  + IFNULL(`dol_SelfEmp`,0) + IFNULL(`dol_Facility`,0)),2) coltotwages";
         break;
         case 'percentpto':
         $cols = "FORMAT((SUM(IF(IFNULL(`YN_pto`,0) > 0, 1, 0)) / count(DISTINCT `id`) ) * 100,0) paidtimeoff";
         break;
         case 'percentsa':
         $cols = "FORMAT((SUM(IF(IFNULL(`YN_sa`,0) > 0, 1, 0)) / count(DISTINCT `id`) ) * 100,0) setaside";
         break;
         case 'coltotalhrs':
         $cols = "FORMAT(SUM(IFNULL(`HrsIndComp`,0) + IFNULL(`HrsIndCont`,0) + IFNULL(`HrsGroupInt`,0) + IFNULL(`HrsFac`,0) + IFNULL(`HrsComNonWork`,0)),2) totalhours";
         break;
         case 'colavghrs':
         $cols = "FORMAT(SUM(IFNULL(`HrsIndComp`,0) + IFNULL(`HrsIndCont`,0) + IFNULL(`HrsGroupInt`,0)  + IFNULL(`HrsSelfEmp`,0) + IFNULL(`HrsFac`,0)  + IFNULL(`HrsComNonWork`,0)) / count(DISTINCT `id`),2) avghrs";
         break;
         case 'colnumover20':
         $cols = "FORMAT(SUM(IF((`HrsIndComp` AND 1 AND (`HrsIndComp` / 2) > 20) OR (`HrsIndCont` AND 1 AND (`HrsIndCont` / 2) > 20) OR (`HrsGroupInt` AND 1 AND (`HrsGroupInt` / 2) > 20) OR (`HrsFac` AND 1 AND (`HrsFac` / 2) > 20) OR (`HrsSelfEmp` AND 1 AND (`HrsSelfEmp` / 2) > 20) OR (`HrsComNonWork` AND 1 AND (`HrsComNonWork` / 2) > 20), 1, 0)), 0) numover20";
         break;
         case 'colpercover20':
         $cols = "FORMAT(SUM(IF((`HrsIndComp` AND 1 AND (`HrsIndComp` / 2) > 20) OR (`HrsIndCont` AND 1 AND (`HrsIndCont` / 2) > 20) OR (`HrsGroupInt` AND 1 AND (`HrsGroupInt` / 2) > 20) OR (`HrsSelfEmp` AND 1 AND (`HrsSelfEmp` / 2) > 20) OR (`HrsComNonWork` AND 1 AND (`HrsComNonWork` / 2) > 20), 1, 0))  / count(DISTINCT `id`) * 100, 1) percover20";
         break;


            case 'colpercvol':
            $cols = "FORMAT(SUM(IF(`YN_vol` = 1, 1,0)) / count(DISTINCT `id`) * 100, 1) percvol";
            break;
      }

				$sep = $cols ? ",\n" : '';


		$db = Database::getDatabase();

		$rs = $db->query("SELECT $cols from `spec_mdda6` where `region` is not null and `region` != '' $where GROUP BY `reporting_period`");
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
			$query = "SELECT distinct vendor from spec_mdda6 where  region is not null and region != '' order by vendor";
		} else if (strpos($region, "x_") === 0) {
			$region = substr($region, 2);
			if ($region == 'West' || $region == 'Central') {
				$where = "LEFT(CRS_Contract, 1) = " . self::getContractNumbers($region) . "";
			} else {
				$where = "`region` is not null and `region` != '' AND `CRS_Contract` IN (". self::getContractNumbers($region) . ")";
			}
		} else {
			$where = "`region` = '$region'";
		}
		$rs = $db->query("SELECT distinct Vendor from spec_mdda6 where $where order by Vendor");
		while ($row = $db->fetch_assoc($rs)) {
			$ret[] =  $row['Vendor'];
		}
		return $ret;
	}

/*
	function: getRowData
	purpose: outputs a row in the report
*/
	static function getRowData($report, $subreport, $level = 'provider') {
		$f		= mdda::getFilterValues();
		$totalhours = "IFNULL(`HrsIndComp`,0) + IFNULL(`HrsIndCont`,0) + IFNULL(`HrsGroupInt`,0)  + IFNULL(`HrsFac`,0)  + IFNULL(`HrsSelfEmp`,0)  + IFNULL(`HrsComNonWork`,0)";
       if ($subreport == 'hours') { $hours = array('HrsIndComp','HrsIndCont', 'HrsGroupInt', 'HrsFac','HrsSelfEmp','HrsComNonWork'); }
       elseif ($subreport == "number") { $hours = array('HrsIndComp','HrsIndCont','HrsSelfEmp', 'HrsGroupInt', 'HrsFac','com_non_work_partic','YN_vol','fac_non_work_partic'); }
		else  { $hours = array('HrsIndComp','HrsIndCont','HrsSelfEmp', 'HrsGroupInt', 'HrsFac', 'HrsComNonWork', 'HrsFacNonWork'); }
		if ($extra) {

		}
		$cols = 'count(1) ';
		if ($subreport == "number") {
			foreach ($hours as $col) {
				$cols  .= ",\nSUM(IFNULL($col, 0) > 0)";
			}
			foreach ($hours as $col) {
				$cols  .= ",\nIF(COUNT(1) > 0, REPLACE(FORMAT((SUM(IFNULL($col, 0) > 0) / COUNT(1)) * 100, 1), ',', ''), 0)";
			}
		} elseif ($subreport =="hours") {
			foreach ($hours as $col) {
				$cols .= ",\nFORMAT(AVG(IF($col > 0, $col, NULL)), 1)";
			}
			foreach ($hours as $col) {
				$cols .= ",\nIF(SUM(IF($col > 0 OR $col = 0, $totalhours, 0)) > 0, REPLACE(FORMAT((SUM(IF($col > 0, $col, 0)) / SUM(IF($col > 0 OR $col = 0, $totalhours, 0))) * 100, 1), ',', ''), 0)";
			}
		} elseif ($subreport == "wage") {
			$wages	= array('dol_indComp','dol_indCont', 'dol_GroupInt', 'dol_Facility');

			foreach ($wages as $col) {
				$cols  .= ",\nREPLACE(FORMAT(AVG(IF($col > 0, $col, NULL)), 2), ',', '')";
			}

			foreach ($wages as $col) {
				$cols .= ",\nFORMAT(SUM(IF($col > 0, $col, 0)), 2)";
			}
		}
      elseif ($subreport == "pto") {
      			$wages	= array('HrsIndComp' => self::FLAG_YN_PTO_IN_COMP,'HrsIndCont' => self::FLAG_YN_PTO_IN_CONT, 'HrsGroupInt' => self::FLAG_YN_PTO_GRP_INT, 'HrsFac' => self::FLAG_YN_PTO_FAC);
      			foreach ($wages as $key => $val) {
                  $cols .= ",\nSUM(IF(IFNULL(`YN_pto`,0) & $val = $val, 1, 0))";

      			}

      			foreach ($wages as $key =>$val) {
                  $cols  .= ",\nFORMAT(REPLACE(SUM(IF(IFNULL(`YN_pto`,0) & $val = $val, 1, 0)), ',', '') / REPLACE(SUM(IF(IFNULL(`$key`,0) > 0, 1, 0)),',', '') * 100,1)";

      			}
      		}
		$having	= '(0' . str_repeat(',0', substr_count($cols, ",\n")) . ") <> ($cols)";
		$where	= mdda::getFilterClause($report);

		$sql = "SELECT CONCAT('<aa/><strong>', `vendor`, '</strong>') AS `grouping`, $cols FROM `spec_mdda6` WHERE `region` IS NOT NULL AND `region` <> '' $where GROUP BY `vendor_id` HAVING $having\n";
		if ($report == 'individual' && $f['region']) {
			$sql .= 'UNION ' . "SELECT '<rr/><strong>{$f['region']}</strong>', $cols FROM `spec_mdda6` WHERE `region` = '{$f['region']}' AND DATE_FORMAT(`Reporting_Period`,'%M %Y') = '{$f['year']}'"
            .
                      ( $f['from'] ? 'AND `dob` BETWEEN DATE_ADD(MAKEDATE(YEAR(`reporting_period`), 92), INTERVAL -' . $f['to']
                       					. ' YEAR) AND DATE_ADD(MAKEDATE(YEAR(`reporting_period`), 92), INTERVAL -' . $f['from'] . ' YEAR) ' : '') .
            " GROUP BY `region` HAVING $having\n";

		}
		if ($report == 'individual') {
			$sql .= 'UNION ' . "SELECT '<zz/><strong>State</strong>', $cols FROM `spec_mdda6` WHERE `region` IS NOT NULL AND `region` <> '' AND DATE_FORMAT(`Reporting_Period`,'%M %Y') = '{$f['year']}' " .
           ( $f['from'] ? 'AND `dob` BETWEEN DATE_ADD(MAKEDATE(YEAR(`reporting_period`), 92), INTERVAL -' . $f['to']
            					. ' YEAR) AND DATE_ADD(MAKEDATE(YEAR(`reporting_period`), 92), INTERVAL -' . $f['from'] . ' YEAR) ' : '') .

            "GROUP BY `reporting_period` HAVING $having\n";

		}
	//	print "<!-- $sql\n-->";
		$db = Database::getDatabase();
		$rs = $db->query($sql . ' ORDER BY ' . ($_REQUEST['orderby'] && $report != 'individual' ? $_REQUEST['orderby'] : '`grouping`'));
		$html = '';
		while ($row = $db->fetch_assoc($rs)) {
         foreach($row as $key => $value) {
            if ($row[$key] == '') {$row[$key] = 0;} }
			$html .= "<td>" . implode('</td><td>', $row) . '</td></tr>';
		}
		return $html;
	}

	static function getYearSelect($name, $val) {
		$name = htmlentities($name, ENT_COMPAT, 'UTF-8');
		$html = "<select id=\"$name\" name=\"$name\">";
		$db = Database::getDatabase();
		$rs = $db->query("SELECT DISTINCT DATE_FORMAT(`Reporting_Period`,'%M %Y') AS `y` FROM `spec_mdda6` order by `Reporting_Period` DESC");
		while ($row = $db->fetch_assoc($rs)) {
			$selected = $val == $row['y'] ? ' selected="selected"' : '';

			$html .= "<option$selected>{$row['y']}</option>";
		}
		return $html . '</select>';
	}
	static function getReportingDates($year) {
		$yearlen = strlen($year) -4;
      $modyear = substr($year, $yearlen,4);
      $monthlen = strlen($year - 5);
      $month = substr($year, 0, $monthlen);
		$db = Database::getDatabase();
		$rs = $db->query("SELECT CONCAT(`joined`.`start_date`,' to ', `joined`.`end_date`) from `mdda_reporting_period` joined WHERE `joined`.`end_date` LIKE '%$modyear' and (date_format(str_to_date(`start_date`, '%m/%d/%Y'), '%M') LIKE '$month%' OR date_format(str_to_date(`end_date`, '%m/%d/%Y'), '%M') LIKE '$month%')") ;

$rep_period = $db->fetch_result($rs);
		return $rep_period;
	}


   static function formatCurrency($data) {

      foreach ($data as $key => $val) {
         if($key != 'Hours worked in self employment<br />(2 week reporting period)')
         $data[$key] =  '$' . number_format($val,2,'.',',');
         else   $data[$key] =  number_format($val,1,'.',',');

       }
       return $data;
      }

      static function formatUS($data) {

         foreach ($data as $key => $val) {

            $data[$key] =  number_format($val,0,'.',',');

          }
          return $data;
         }
}

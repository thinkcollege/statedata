<?php    
/*
class: sample
purpose: useful functions for sample
*/
class sample extends mre_base{

function sample () {
	
	$this->ar_region_variables[] ='Num_HrsInd';
	$this->ar_region_variables_name[] = 'Number in individual supported employment';
	$this->ar_region_variables_axis[] = 'Total';
	$this->ar_region_variables[] ='Num_HrsGroup';
	$this->ar_region_variables_name[] = 'Number in Group Supported Employment';
	$this->ar_region_variables_axis[] = 'Total';
	$this->ar_region_variables[] ='Num_HrsFac';
	$this->ar_region_variables_name[] = 'Number in Facility-Based Employment';
	$this->ar_region_variables_axis[] = 'Total';
	$this->ar_region_variables[] ='Num_HrsVolunteer';
	$this->ar_region_variables_name[] = 'Number in Volunteer or Non-Work Day Activities';
	$this->ar_region_variables_axis[] = 'Total';
	$this->ar_region_variables[] ='Num_HrsTransition';
	$this->ar_region_variables_name[] = 'Number reporting “in transition” hours';
	$this->ar_region_variables_axis[] = 'Total';
	
	
	$this->ar_region_variables[] ='Per_HrsInd';
	$this->ar_region_variables_name[] = 'Percent in individual supported employment';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_HrsGroup';
	$this->ar_region_variables_name[] = 'Percent in Group Supported Employment';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_HrsFac';
	$this->ar_region_variables_name[] = 'Percent in Facility-Based Employment';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_HrsVolunteer';
	$this->ar_region_variables_name[] = 'Percent in Volunteer or Non-Work Day Activities';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_HrsTransition';
	$this->ar_region_variables_name[] = 'Percent reporting “in transition” hours';
	$this->ar_region_variables_axis[] = 'Percent';
	
	$this->ar_region_variables[] ='Avg_HrsInd';
	$this->ar_region_variables_name[] = 'Mean hours/month per person in individual supported employment';
	$this->ar_region_variables_axis[] = 'Mean';
	$this->ar_region_variables[] ='Avg_hrsGroup';
	$this->ar_region_variables_name[] = 'Mean hours/month per person in Group Supported Employment';
	$this->ar_region_variables_axis[] = 'Mean';
	$this->ar_region_variables[] ='Avg_HrsFac';
	$this->ar_region_variables_name[] = 'Mean hours/month per person in Facility-Based Employment';
	$this->ar_region_variables_axis[] = 'Mean';
	$this->ar_region_variables[] ='Avg_HrsVolunteer';
	$this->ar_region_variables_name[] = 'Mean hours/month per person in Volunteer or Non-Work Day Activities';
	$this->ar_region_variables_axis[] = 'Mean';
	$this->ar_region_variables[] ='Avg_HrsTransition';
	$this->ar_region_variables_name[] = 'Mean hours/month per person reporting "in transition" hours';
	$this->ar_region_variables_axis[] = 'Mean';
	
	$this->ar_region_variables[] ='Mean_HrsInd';
	$this->ar_region_variables_name[] = 'Mean hourly wage in individual supported employment (for those who are participating)';
	$this->ar_region_variables_axis[] = 'Mean';
	$this->ar_region_variables[] ='Mean_hrsGroup';
	$this->ar_region_variables_name[] = 'Mean hourly wage in Group Supported Employment';
	$this->ar_region_variables_axis[] = 'Mean';
	$this->ar_region_variables[] ='Mean_HrsFac';
	$this->ar_region_variables_name[] = 'Mean hourly wage in Facility-Based Employment';
	$this->ar_region_variables_axis[] = 'Mean';
	
	
	$this->ar_region_variables[] ='Per_total_HrsInd';
	$this->ar_region_variables_name[] = 'Percent of total hours in individual supported employment (for those who are participating)';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_total_HrsGroup';
	$this->ar_region_variables_name[] = 'Percent of total hours in Group Supported Employment';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_total_HrsFac';
	$this->ar_region_variables_name[] = 'Percent of total hours in Facility-Based Employment';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_total_HrsVolunteer';
	$this->ar_region_variables_name[] = 'Percent of total hours in Volunteer or Non-Work Day Activities';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_total_HrsTransition';
	$this->ar_region_variables_name[] = 'Percent of total hours in transition ';
	$this->ar_region_variables_axis[] = 'Percent';
	
	$this->ar_region_variables[] ='Avg_dol_ind';
	$this->ar_region_variables_name[] = 'Mean monthly wages per person in individual supported employment (for those who are participating)';
	$this->ar_region_variables_axis[] = 'Mean&#xa;wage&#xa;/month';
	$this->ar_region_variables[] ='Avg_dol_group';
	$this->ar_region_variables_name[] = 'Mean monthly wages per person in Group Supported Employment';
	$this->ar_region_variables_axis[] = 'Mean&#xa;wage&#xa;/month';
	$this->ar_region_variables[] ='Avg_dol_Facility';
	$this->ar_region_variables_name[] = 'Mean monthly wages per person in Facility-Based Employment';
	$this->ar_region_variables_axis[] = 'Mean&#xa;wage&#xa;/month';
	
	$this->ar_region_variables[] ='Per_YNInd';
	$this->ar_region_variables_name[] = 'Percent earning at least minimum wage in individual supported employment (for those who are participating)';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_YNGroup';
	$this->ar_region_variables_name[] = 'Percent earning at least minimum wage in Group Supported Employment';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_YNFacility';
	$this->ar_region_variables_name[] = 'Percent earning at least minimum wage in Facility-Based Employment';
	$this->ar_region_variables_axis[] = 'Percent';
	
	
	$this->ar_region_variables[] ='Num_IndSupEmp';
	$this->ar_region_variables_name[] = 'Number employed in Individual Supported Employment for 10 of the last 12 months (for those who are participating)';
	$this->ar_region_variables_axis[] = 'Total';
	$this->ar_region_variables[] ='Num_GroupSupEmp';
	$this->ar_region_variables_name[] = 'Number employed in Group Supported Employment for 10 of the last 12 months (for those who are participating)';
	$this->ar_region_variables_axis[] = 'Total';
	
	$this->ar_region_variables[] ='Per_IndSupEmp';
	$this->ar_region_variables_name[] = 'Percent employed in Individual Supported Employment for 10 of the last 12 months (for those who are participating)';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_GroupSupEmp';
	$this->ar_region_variables_name[] = 'Percent employed in Group Supported Employment for 10 of the last 12 months (for those who are participating)';
	$this->ar_region_variables_axis[] = 'Percent';
		
}

/*
function: safehtml
purpose: strip out non-safe tags
*/
function safehtml($html,$safetags="<b><a><br><i><u><ul><ol><li>") { 
	$html=strip_tags($html,$safetags);
	return($html); 
}

/*
function: getRegions
purpose: returns a dropdown of regions
*/
function getRegions($element_name, $showAll = 1, $provider = 'ALL', $regiontype='normal') { 
	$database = Database::getDatabase();
	
	if ($provider == 'ALL'){
		$results = $database->query("Select distinct region from spec_sample where region != 'x' order by region");
	} else {
		$results = $database->query("Select distinct region from spec_sample where vendor = '$provider' order by region");
	}
	$html = "<select id=$element_name  name=$element_name onkeydown=\"return on_keydown_form(document.form1,event,'login');\">";
	//$html = $html . "<option value=0>Choose Region</option>";
	
	if ($showAll == 1 && $database->num_rows($results) > 1) {
		$html = $html . "<option value=ALL>All Regions</option>";
	}
	
	for ($result=0;$result< $database->num_rows($results);$result++){
		$html= $html . "<option value='". $database->fetch_result($results,$result,'region') ."'>" . $database->fetch_result($results,$result,'region') . "</option>\n";
	}
	
	$html= $html . "</select>\n";
	$database->close();
	return($html); 
}
function getRegionArray($provider) {
	$database = Database::getDatabase();
	$returnArray = array();
	$results = $database->query("Select distinct region from spec_sample where vendor = '" . $provider . "' order by region");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$returnArray[$result] = $database->fetch_result($results,$result,'region');
	}
	return $returnArray;
}

/*
function: getProviders
purpose: returns a dropdown of providers in a given region
*/
function getProviders($element_name, $region, $showAll = 1) { 
	$database = Database::getDatabase();
	
	if ($region == 'ALL' || $region=='0') {
		$query = "Select distinct vendor from spec_sample order by vendor";
	} else {
		if (substr_count($region, "x_") > 0 ) {
			$region = substr($region,2);
			if ($region =='Central' || $region == 'West') {
				$query = "Select distinct vendor from spec_sample where LEFT( CRS_Contract, 1 ) = '". $this->getContractNumbers ($region) ."' order by vendor";
			} else {
				$query = "Select distinct vendor from spec_sample where CRS_Contract in (". $this->getContractNumbers($region) .") order by vendor";
			}
		} else {
			$query = "Select distinct vendor from spec_sample where region='". $region ."' order by vendor";
		}
	}//else {
	//	$query = "Select distinct vendor from spec_sample where region='". $region ."' order by vendor";
	//}

	$results = $database->query($query);
	$html = "<select id=$element_name name=$element_name onkeydown=\"return on_keydown_form(document.form1,event,'login');\">";
	//$html = $html . "<option value=0>Choose Provider</option>";
	if ($showAll == 1) {
		$html = $html . "<option value=ALL>All Providers</option>";
	}
	for ($result=0;$result< $database->num_rows($results);$result++){
		$html= $html . "<option value='". $database->fetch_result($results,$result,'vendor') ."'>" . $database->fetch_result($results,$result,'vendor') . "</option>\n";
	}
	$html= $html . "</select>\n";
	$database->close();
	return($html); 
}

/*
function: getProviders
purpose: returns a dropdown of providers in a given region
*/
function getActivityVariables() { 
	$html = "<table cellpadding=5>";
	
	$html= $html . "<tr><td><input type=radio name=variable id='v1' value='numberinactivity'></td><td><label for='v1'>Number participating in activity</label></td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable id='v2' value='percent'></td><td><label for='v2'>Percent participating in activity</label></td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable id='v3' value='totalhours'></td><td><label for='v3'>Total # hours for activity</label></td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable id='v4' value='meanhours'></td><td><label for='v4'>Mean hours per activity (of those participating)</label></td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable id='v5' value='totalwages'></td><td><label for='v5'>Total wages per activity</label></td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable id='v6' value='meanwage'></td><td><label for='v6'>Mean wage per activity</label></td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable id='v7' value='meanhourlywage'></td><td><label for='v7'>Mean hourly wage for individual, group and facility employment</label></td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable id='v8' value='numberminimum'></td><td><label for='v8'>Number earning at least minimum wage</label></td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable id='v9' value='percentminimum'></td><td><label for='v9'>Percent earning at least minimum wage</label></td></tr>\n";
	$html= $html . "</table>\n";

	/*$html= $html . "<tr><td><input type=radio name=variable value='numberinactivity'></td><td>Number participating in activity</td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable value='percent'></td><td>Percent participating in activity</td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable value='totalhours'></td><td>Total # hours for activity</td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable value='meanhours'></td><td>Mean hours per activity (of those participating)</td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable value='totalwages'></td><td>Total wages per activity</td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable value='meanwage'></td><td>Mean wage per activity</td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable value='numberminimum'></td><td>Number earning at least minimum wage</td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable value='percentminimum'></td><td>Percent earning at least minimum wage</td></tr>\n";
	$html= $html . "</table>\n";
	*/
	
	return($html); 
}



/*
function: getRegionVariables
purpose: returns a dropdown of providers in a given region
*/
function getRegionVariables() { 
	$html = "<table cellpadding=5>";
	for($i=0; $i<count($this->ar_region_variables); $i++) {
		$html= $html . "<tr><td><input type=radio name=variable id=$i value='".$this->ar_region_variables[$i]."'></td><td><label for='$i'>". $this->ar_region_variables_name[$i] ."</label></td></tr>\n";
	}
	
	//$html= $html . "<tr><td><input type=radio name=variable value='Num_HrsInd'></td><td>Number participating in individual supported employment</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Num_HrsGroup'></td><td>Number participating in Group Supported Employment</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Num_HrsFac'></td><td>Number participating in Facility-Based Employment</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Num_HrsVolunteer'></td><td>Number participating in Volunteer or Non-Work Day Activities</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Num_HrsTransition'></td><td>Number participating reporting “in transition” hours</td></tr>\n";
	
	
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_HrsInd'></td><td>Percent participating in individual supported employment</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_HrsGroup'></td><td>Percent participating in Group Supported Employment</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_HrsFac'></td><td>Percent participating in Facility-Based Employment</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_HrsVolunteer'></td><td>Percent participating in Volunteer or Non-Work Day Activities</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_HrsTransition'></td><td>Percent reporting “in transition” hours</td></tr>\n";
	
	//$html= $html . "<tr><td><input type=radio name=variable value='Avg_HrsInd'></td><td>Mean hours/month per person in individual supported employment (for those who are participating)</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Avg_hrsGroup'></td><td>Mean hours/month per person in Group Supported Employment</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Avg_HrsFac'></td><td>Mean hours/month per person in Facility-Based Employment</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Avg_HrsVolunteer'></td><td>Mean hours/month per person in Volunteer or Non-Work Day Activities</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Avg_HrsTransition'></td><td>Mean hours/month per person reporting “in transition” hours</td></tr>\n";
	
	
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_total_HrsInd'></td><td>Percent of total hours in individual supported employment (for those who are participating)</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_total_HrsGroup'></td><td>Percent of total hours in Group Supported Employment</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_total_HrsFac'></td><td>Percent of total hours in Facility-Based Employment</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_total_HrsVolunteer'></td><td>Percent of total hours in Volunteer or Non-Work Day Activities</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_total_HrsTransition'></td><td>Percent of total hours in transition </td></tr>\n";
	
	//$html= $html . "<tr><td><input type=radio name=variable value='Avg_dol_ind'></td><td>Mean monthly wages per person in individual supported employment (for those who are participating)</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Avg_dol_group'></td><td>Mean monthly wages per person in Group Supported Employment</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Avg_dol_Facility'></td><td>Mean monthly wages per person in Facility-Based Employment</td></tr>\n";
	
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_YNInd'></td><td>Percent earning at least minimum wage in individual supported employment (for those who are participating)</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_YNGroup'></td><td>Percent earning at least minimum wage in Group Supported Employment</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_YNFacility'></td><td>Percent earning at least minimum wage in Facility-Based Employment</td></tr>\n";
	
	
	//$html= $html . "<tr><td><input type=radio name=variable value='Num_IndSupEmp'></td><td>Number employed in Individual Supported Employment for 10 of the last 112 months (of those participating in individual supported employment)</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Num_GroupSupEmp'></td><td>Number employed in Group Supported Employment for 10 of the last 112 months (of those participating in individual supported employment)</td></tr>\n";
	
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_IndSupEmp'></td><td>Percent employed in Individual Supported Employment for 10 of the last 112 months (of those participating in individual supported employment)</td></tr>\n";
	//$html= $html . "<tr><td><input type=radio name=variable value='Per_GroupSupEmp'></td><td>Percent employed in Group Supported Employment for 10 of the last 112 months (of those participating in individual supported employment)</td></tr>\n";
		
	$html= $html . "</table>\n";

	return($html); 
}



/*
function: getActivityColumnNamesArray 
purpose: return the column names for an activity
*/
function getActivityColumnNamesArray ($variable) {

	if ($variable == 'totalwages' || $variable == 'meanwage' || $variable == 'numberminimum' || $variable == 'percentminimum') {
		$columArray[] = 'Individual Supported Employment';
		$columArray[] = 'Group Supported Employment';
		$columArray[] = 'Facility Based Employment';
	} elseif ($variable == 'meanhourlywage') {
		$columArray[] = 'Mean hourly wage Individual Employment';
		$columArray[] = 'Mean hourly wage Group Employment';
		$columArray[] = 'Mean hourly wage Facility Based Employment';
	}else {
		$columArray[] = 'Individual Supported Employment';
		$columArray[] = 'Group Supported Employment';
		$columArray[] = 'Facility Based Employment';
		$columArray[] = 'Volunteer or Non-Paid Day Services';
		$columArray[] = 'in Transition';
	}
	return($columArray);
}

/*
function: getActivityColumnNamesArray 
purpose: return the column names for an activity
*/
function getRegionColumnNamesArray () {
	$database = Database::getDatabase();
	

	$results = $database->query("Select distinct region from spec_sample where region != 'x' order by region");

	for ($result=0;$result< $database->num_rows($results);$result++){
		$columArray[] =  $database->fetch_result($results,$result,'region');
	}
	
	return($columArray);
}


/*
function: getLegendName
purpose: return the legend name for an activity
*/
function getLegendName($variable, $region, $provider, $year = '04') {
	$legendClause ="";
	if ($provider != "ALL") {
		$legendClause = $legendClause . " for ". $provider ." ";
	} else {
		$legendClause = $legendClause . " for all providers ";
	}
	if (substr_count($region, "x_") > 0 ) {
		$region = substr($region,2);
	}
	if ($region != "ALL") {
		$legendClause = $legendClause .  " in the ". $region ." region"; 
	} else {
		$legendClause = $legendClause .  " in all regions"; 
	}
	
	$legendClause = $legendClause .  " in 20" . $year;
	
	$legend = "";
	if ($variable == 'numberinactivity') {
		$legend = "Number participating in activity ";
	} elseif ($variable == 'percent') {
		$legend = "Percent participating in activity ";
	} elseif ($variableType == 'totalhours') {
		$legend = "Total hours for activity ";
	} elseif ($variable == 'meanhours') {
		$legend = "Mean hours per activity ";
	} elseif ($variable == 'totalwages') {
		$legend = "Total wages per activity ";
	} elseif ($variable == 'meanwage') {
		$legend = "Mean wage per activity ";
	} elseif ($variable == 'numberminimum') {
		$legend = "Number earning at least minimum wage ";
	} elseif ($variable == 'percentminimum') {
		$legend = "Percent earning at least minimum wage ";
	} elseif ($variable == 'meanhourlywage') {
		$legend = "Mean hourly wage for individual, group and facility employment ";
	}
	$legend = $legend . $legendClause;
	return ($legend);
}

/*
function: getRegionLegendName
purpose: return the legend name for an region view
*/
function getRegionLegendName($variable, $year = '-1') {
	$legend = "";
	for($i=0; $i<count($this->ar_region_variables); $i++) {
		if ($this->ar_region_variables[$i] == $variable) {
			$legend = $this->ar_region_variables_name[$i];
			if ($year != '-1') {
				$legend = $legend . " in 20" . $year;
			}
		}
	}
	return ($legend);
}


/*
function: getAxisLabel
purpose: return the legend name for an activity
*/
function getAxisLabel($variable) {


	if ($variable == 'numberinactivity') {
		$axisLabel = "Total";
	} elseif ($variable == 'percent') {
		$axisLabel = "Percent";
	} elseif ($variable == 'totalhours') {
		$axisLabel = "Hours";
	} elseif ($variable == 'meanhours') {
		$axisLabel = "Hours";
	} elseif ($variable == 'totalwages') {
		$axisLabel = "Wages/&#xa;month";
	} elseif ($variable == 'meanwage') {
		$axisLabel = "Wages/&#xa;month";
	} elseif ($variable == 'numberminimum') {
		$axisLabel = "Total";
	} elseif ($variable == 'percentminimum') {
		$axisLabel = "Percent";
	} elseif ($variable == 'meanhourlywage') {
		$axisLabel = "Mean";
	}
	
	return ($axisLabel);
}

/*
function: getRegionAxisLabel
purpose: return the axis label for the region view
*/
function getRegionAxisLabel($variable) {
	$axisLabel = "";
	for($i=0; $i<count($this->ar_region_variables); $i++) {
		if ($this->ar_region_variables[$i] == $variable) {
			$axisLabel = $this->ar_region_variables_axis[$i];
		}
	}
	return ($axisLabel);
}

/*
function: getContractNmbers
purpose: return the contract numbersfor a given region
*/
function getContractNumbers ($region) {
	if ($region =='Berkshire') {
		$contractNumbers ="110314,110304,110305,110306";
	} elseif($region =='Franklin/Hampshire') {
		$contractNumbers ="120326,120612,120325,120334";
	} elseif($region =='Springfield/Westfield') {
		$contractNumbers ="161362,140388,140349,140345,140317,160334,160307";
	} elseif($region =='Holyoke/Chicopee') {
		$contractNumbers ="150300,150320,150336,150615,150340,150318,150325";
	} elseif($region =='Central') {
		$contractNumbers ="2";
	} elseif($region =='West') {
		$contractNumbers ="1";
	}
	return($contractNumbers);
}

/*
function: getRegionVariableArray
purpose: return the values in each column for an region query
*/
function getRegionVariableArray ($variable, $year ='04') {
	$database = Database::getDatabase();
	$arRegions = $this->getRegionColumnNamesArray ();
	$whereClause = " and reporting_period='" . $year . "' ";
	
	for($i=0; $i<count($arRegions); $i++) {
		$badmin = 0;
		$useIn = true;
		$contractNumbers = "";
		if ($variable == 'Num_HrsInd') {
			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsInd is not null and HrsInd != 0" . $whereClause;

			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Num_HrsGroup') {
			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsGroup is not null and HrsGroup != 0" . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Num_HrsFac') {
			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsFac is not null and HrsFac != 0" . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Num_HrsVolunteer') {
			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsVolunteer is not null and HrsVolunteer != 0" . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Num_HrsTransition') {
			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsTransition is not null and HrsTransition != 0" . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
			
			
		} elseif ($variable == 'Per_HrsInd') {
			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsInd is not null and HrsInd != 0 " . $whereClause;
			$results = $database->query($query);
			$fraction_top = $database->fetch_result($results,$result,'total');

			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' " . $whereClause;
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($fraction_top/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
		} elseif ($variable == 'Per_HrsGroup') {
			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsGroup is not null and HrsGroup != 0" . $whereClause;
			$results = $database->query($query);
			$fraction_top = $database->fetch_result($results,$result,'total');

			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' " . $whereClause;
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($fraction_top/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
		} elseif ($variable == 'Per_HrsFac') {
			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsFac is not null and HrsFac != 0" . $whereClause;
			$results = $database->query($query);
			$fraction_top = $database->fetch_result($results,$result,'total');

			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' " . $whereClause;
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($fraction_top/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
		} elseif ($variable == 'Per_HrsVolunteer') {
			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsVolunteer is not null and HrsVolunteer != 0" . $whereClause;
			$results = $database->query($query);
			$fraction_top = $database->fetch_result($results,$result,'total');

			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' " . $whereClause;
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($fraction_top/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
		} elseif ($variable == 'Per_HrsTransition') {
			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsTransition is not null and HrsTransition != 0" . $whereClause;
			$results = $database->query($query);
			$fraction_top = $database->fetch_result($results,$result,'total');

			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' " . $whereClause;
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($fraction_top/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}


			
		} elseif ($variable == 'Avg_HrsInd') {
			$query = "Select avg(HrsInd) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsInd is not null and HrsInd != 0" . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
			
		} elseif ($variable == 'Avg_hrsGroup') {
			$query = "Select avg(hrsGroup) as total from spec_sample where region='" . $arRegions[$i] . "' and hrsGroup is not null and hrsGroup != 0" . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Avg_HrsFac') {
			$query = "Select avg(HrsFac) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsFac is not null and HrsFac != 0" . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Avg_HrsVolunteer') {
			$query = "Select avg(HrsVolunteer) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsVolunteer is not null and HrsVolunteer != 0" . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Avg_HrsTransition') {
			$query = "Select avg(HrsTransition) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsTransition is not null and HrsTransition != 0" . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
	
	
		} elseif ($variable == 'Mean_HrsInd') {
			
			$query = "Select avg(dol_ind/HrsInd) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsInd is not null and HrsInd != 0 and dol_ind is not null and dol_ind != 0" . $whereClause;
			
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');

		} elseif ($variable == 'Mean_hrsGroup') {
			$query = "Select avg(dol_group/hrsGroup) as total from spec_sample where region='" . $arRegions[$i] . "' and hrsGroup is not null and hrsGroup != 0 and dol_group is not null and dol_group != 0" . $whereClause;
			
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Mean_HrsFac') {
			$query = "Select  avg(dol_facility/HrsFac) as total from spec_sample where region='" . $arRegions[$i] . "' and HrsFac is not null and HrsFac != 0 and dol_facility is not null and dol_facility != 0" . $whereClause;
			
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');



		} elseif ($variable == 'Per_total_HrsInd') {
			$query = "Select sum(HrsInd) as part from spec_sample where region='" . $arRegions[$i] . "' and HrsInd is not null and HrsInd != 0" . $whereClause;

			$results = $database->query($query);
			$part = $database->fetch_result($results,$result,'part');
		
			$query = "Select sum(totalHours) as total from spec_sample where region='" . $arRegions[$i] . "' " . $whereClause;

			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($part/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
		
		} elseif ($variable == 'Per_total_HrsGroup') {
			$query = "Select sum(HrsGroup) as part from spec_sample where region='" . $arRegions[$i] . "' and HrsGroup is not null and HrsGroup != 0" . $whereClause;
			$results = $database->query($query);
			$part = $database->fetch_result($results,$result,'part');

			$query = "Select sum(totalHours) as total from spec_sample where region='" . $arRegions[$i] . "' " . $whereClause;
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($part/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}

		} elseif ($variable == 'Per_total_HrsFac') {
			$query = "Select sum(HrsFac) as part from spec_sample where region='" . $arRegions[$i] . "' and HrsFac is not null and HrsFac != 0" . $whereClause;
			$results = $database->query($query);
			$part = $database->fetch_result($results,$result,'part');

			$query = "Select sum(totalHours) as total from spec_sample where region='" . $arRegions[$i] . "' " . $whereClause;
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($part/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}

		} elseif ($variable == 'Per_total_HrsVolunteer') {
			$query = "Select sum(HrsVolunteer) as part from spec_sample where region='" . $arRegions[$i] . "' and HrsVolunteer is not null and HrsVolunteer != 0" . $whereClause;
			$results = $database->query($query);
			$part = $database->fetch_result($results,$result,'part');

			$query = "Select sum(totalHours) as total from spec_sample where region='" . $arRegions[$i] . "' " . $whereClause;
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($part/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}

		} elseif ($variable == 'Per_total_HrsTransition') {
			$query = "Select sum(HrsTransition) as part from spec_sample where region='" . $arRegions[$i] . "' and HrsTransition is not null and HrsTransition != 0" . $whereClause;
			$results = $database->query($query);
			$part = $database->fetch_result($results,$result,'part');

			$query = "Select sum(totalHours) as total from spec_sample where region='" . $arRegions[$i] . "' " . $whereClause;
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($part/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}

			
		} elseif ($variable == 'Avg_dol_ind') {
			$query = "Select avg(dol_ind) as total from spec_sample where region='" . $arRegions[$i] . "' and dol_ind is not null  and dol_ind != 0" . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Avg_dol_group') {
			$query = "Select avg(dol_group) as total from spec_sample where region='" . $arRegions[$i] . "' and dol_group is not null  and dol_group != 0" . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');

		} elseif ($variable == 'Avg_dol_Facility') {
			$query = "Select avg(dol_Facility) as total from spec_sample where region='" . $arRegions[$i] . "' and dol_Facility is not null  and dol_Facility != 0" . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
			
		} elseif ($variable == 'Per_YNInd') {
			$query = "Select count(*) as ys from spec_sample where region='" . $arRegions[$i] . "' and trim(YNInd) = 'Y'" . $whereClause;
			$results = $database->query($query);
			$ys = $database->fetch_result($results,$result,'ys');

			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and ( trim(YNInd) in ('Y','N')) " . $whereClause;
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($ys/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}

		} elseif ($variable == 'Per_YNGroup') {
			$query = "Select count(*) as ys from spec_sample where region='" . $arRegions[$i] . "' and trim(YNGroup) = 'Y'" . $whereClause;
			$results = $database->query($query);
			$ys = $database->fetch_result($results,$result,'ys');

			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "'and ( trim(YNGroup) in ('Y','N')) " . $whereClause;
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($ys/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
		} elseif ($variable == 'Per_YNFacility') {
			$query = "Select count(*) as ys from spec_sample where region='" . $arRegions[$i] . "' and trim(YNFacility) = 'Y'" . $whereClause;
			$results = $database->query($query);
			$ys = $database->fetch_result($results,$result,'ys');

			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and ( trim(YNFacility) in ('Y','N'))" . $whereClause;
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($ys/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
			
			
		} elseif ($variable == 'Num_IndSupEmp') {
			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and trim(IndSupEmp) = 'Y'" . $whereClause;
			$results = $database->query($query);
			$returnArray[$i]  = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Num_GroupSupEmp') {
			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and trim(GroupSupEmp) = 'Y'" . $whereClause;
			$results = $database->query($query);
			$returnArray[$i]  = $database->fetch_result($results,$result,'total');


		} elseif ($variable == 'Per_IndSupEmp') {
			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and trim(IndSupEmp) = 'Y'" . $whereClause;
			$results = $database->query($query);
			$fraction_top  = $database->fetch_result($results,$result,'total');

			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and ( trim(IndSupEmp) in ('Y','N'))" . $whereClause;
			$results = $database->query($query);
			$total  = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($fraction_top/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
			
		} elseif ($variable == 'Per_GroupSupEmp') {
			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and trim(GroupSupEmp) = 'Y'" . $whereClause;
			$results = $database->query($query);
			$fraction_top  = $database->fetch_result($results,$result,'total');

			$query = "Select count(*) as total from spec_sample where region='" . $arRegions[$i] . "' and ( trim(GroupSupEmp) in ('Y', 'N')) " . $whereClause;
			$results = $database->query($query);
			$total  = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($fraction_top/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
		}
	}
	$database->close();
	return($returnArray);
}

/*
function: getActivityVariableArray
purpose: return the values in each column for an activity query
*/
function getActivityVariableArray ($variableType, $region, $provider, $year = '04') {
	$database = Database::getDatabase();
	
	$columArray[] = 'HrsInd';
	$columArray[] = 'HrsGroup';
	$columArray[] = 'HrsFac';
	$columArray[] = 'HrsVolunteer';
	$columArray[] = 'HrsTransition';
	
	$whereClause = " and reporting_period='". $year ."' ";

	if ($region != "ALL") {
		$whereClause = $whereClause . " and region = '". $region ."' "; 
	} 

	if ($provider != "ALL") {
		$whereClause = $whereClause . " and vendor='". $provider ."'";
	} 

	$results = $database->query("Select count(*) as total from spec_sample where 1=1" . $whereClause );
	$totalRecords = $database->fetch_result($results,$result,'total');
			
	if ($variableType == 'numberinactivity') {
		for($i=0; $i<count($columArray); $i++) {
			$query = "Select count(*) as total from spec_sample where " . $columArray[$i] . " is not null and ". $columArray[$i] . " !=0 ". $whereClause ;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		}
	} elseif ($variableType == 'percent') {
		for($i=0; $i<count($columArray); $i++) {
			$results = $database->query("Select count(*) as total from spec_sample where " . $columArray[$i] . " is not null and ". $columArray[$i] . " !=0  ". $whereClause);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		}
		for($i=0; $i<count($returnArray); $i++) {
			$returnArray[$i] = ($returnArray[$i]/$totalRecords) * 100;
		}
	} elseif ($variableType == 'totalhours') {
		for($i=0; $i<count($columArray); $i++) {
			$query = "Select sum(" . $columArray[$i] . ") as total from spec_sample where " . $columArray[$i] . " is not null and ". $columArray[$i] . " !=0  " . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		}
	} elseif ($variableType == 'meanhours') {
		for($i=0; $i<count($columArray); $i++) {
			//$query = "DROP TABLE IF EXISTS medians";
			//$temp_table_q = $database->query($query);
	
			//$query = "CREATE TEMPORARY TABLE medians SELECT x." . $columArray[$i] . " medians FROM spec_sample x, spec_sample y	GROUP BY x." . $columArray[$i] . "	HAVING SUM(y." . $columArray[$i] . " <= x." . $columArray[$i] . ") >= COUNT(*)/2 AND SUM(y." . $columArray[$i] . " >= x." . $columArray[$i] . ") >= COUNT(*)/2;";
	
			//$temp_table_q = $database->query($query);
			
			//$query = "SELECT AVG(medians) AS median FROM medians";
			$query = "SELECT AVG(" . $columArray[$i] . ") AS mean FROM spec_sample where  " . $columArray[$i] . " is not null and ". $columArray[$i] . " !=0  " . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'mean');
		}
		

	} elseif ($variableType == 'totalwages') {
		$columWagesArray[] = 'dol_ind';
		$columWagesArray[] = 'dol_Group';
		$columWagesArray[] = 'dol_Facility';
	
		//$results = $database->query("Select count(*) as total from spec_sample where 1=1 " . $columWagesArray[$i] . " is not null  ". $whereClause);
		//$totalRecords = $database->fetch_result($results,$result,'total');

		for($i=0; $i<count($columWagesArray); $i++) {
		$query = "Select sum(" . $columWagesArray[$i] . ") as total from spec_sample where " . $columWagesArray[$i] . " is not null and ". $columWagesArray[$i] . " !=0  ". $whereClause;
	//	echo $query ."<BR>";
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		}
	} elseif ($variableType == 'meanwage') {
		$columWagesArray[] = 'dol_ind';
		$columWagesArray[] = 'dol_Group';
		$columWagesArray[] = 'dol_Facility';
	
		for($i=0; $i<count($columWagesArray); $i++) {
			$results = $database->query("Select avg(" . $columWagesArray[$i] . ") as total from spec_sample where " . $columWagesArray[$i] . " is not null and ". $columWagesArray[$i] . " !=0  " . $whereClause);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		}
	} elseif ($variableType == 'numberminimum') {
		$columWagesArray[] = 'YNInd';
		$columWagesArray[] = 'YNGroup';
		$columWagesArray[] = 'YNFacility';

		for($i=0; $i<count($columWagesArray); $i++) {
			$query = "Select count(" . $columWagesArray[$i] . ") as total from spec_sample where trim(" . $columWagesArray[$i] . ") = 'Y' ". $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		}
	} elseif ($variableType == 'percentminimum') {
		$columWagesArray[] = 'YNInd';
		$columWagesArray[] = 'YNGroup';
		$columWagesArray[] = 'YNFacility';
	
		for($i=0; $i<count($columWagesArray); $i++) {
			$query = "Select count(*) as total from spec_sample where trim( " . $columWagesArray[$i] . " ) IN ('N', 'Y') ". $whereClause;
			
			$results = $database->query($query);
			$totalRecords = $database->fetch_result($results,$result,'total');
			
			$query = "Select count(" . $columWagesArray[$i] . ") as total from spec_sample where trim(" . $columWagesArray[$i] . ") = 'Y' ". $whereClause;
			$results = $database->query($query);
			
			$Y = $database->fetch_result($results,$result,'total');
			if ($totalRecords == 0 ) {
				$returnArray[$i] = 0;
			} else {
				$returnArray[$i] = ($Y/$totalRecords) * 100;
			}
		}
		//for($i=0; $i<count($returnArray); $i++) {
		//	$returnArray[$i] = ($returnArray[$i]/$totalRecords) * 100;
		//}
	}  elseif ($variableType == 'meanhourlywage') {
		$columWagesArray[] = 'dol_ind';
		$columWagesArray[] = 'dol_Group';
		$columWagesArray[] = 'dol_Facility';

		$columHoursArray[] = 'HrsInd';
		$columHoursArray[] = 'HrsGroup';
		$columHoursArray[] = 'hrsFac';
		for($i=0; $i<count($columWagesArray); $i++) {
			//$query = "Select AVG(" . $columWagesArray[$i] . ") as total from spec_dmr4 where " . $columWagesArray[$i] . " is not null and ". $columWagesArray[$i] . " !=0  and " . $columHoursArray[$i] . " is not null and ". $columHoursArray[$i] . " !=0  " . $whereClause;
			$query = "Select avg(" . $columWagesArray[$i] . "/" . $columHoursArray[$i] . ") as total from spec_sample where " . $columWagesArray[$i] . " is not null and ". $columWagesArray[$i] . " !=0  and " . $columHoursArray[$i] . " is not null and ". $columHoursArray[$i] . " !=0  " . $whereClause;
			//echo $query;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		}
	}
	$database->close();
	return($returnArray);
}
/*
function: getProvidersArray
purpose: returns an array of providers in a region
*/
function getProvidersArray ($region) {
	$database = Database::getDatabase();
	if ($region == "ALL") {
		$query = "Select distinct vendor from spec_sample order by vendor";
	} else {
		$query = "Select distinct vendor from spec_sample where region='".$region."' order by vendor";
	}
	$results = $database->query($query);
	for ($result=0;$result< $database->num_rows($results);$result++){
		$returnArray[] =  $database->fetch_result($results,$result,'vendor') ;
	}
	$database->close();
	return($returnArray);
}
/*
function: getRowData
purpose: outputs a row in the report
*/
function getRowData($provider, $report, $region, $year ='none', $showregion = 0) {
	$database = Database::getDatabase();
	$sRegion = $region;
//echo $sRegion ;
	if ($region == "ALL") {
		$region = " ";
	} else {
		if ($region != "" ) {
			$region = " and region='". $region ."' ";
		}
	}
	if ($year != "none") {
		$region = $region . " and reporting_period='" . $year . "' ";
	}

	echo "<tr>\n";
	if ($showregion == 1) {
		echo "<td nowrap><nobr><b>" . $sRegion ."&nbsp;</b></nobr></td>\n";
	} else {
		if ($provider =="") {
			echo "<td>&nbsp;<b>State&nbsp;</b></td>\n";
		} else {
			echo "<td nowrap><nobr><b>" .$provider ."&nbsp;</b></nobr></td>\n";
		}
	}
	if ($provider == "") {
		$provderWhere = "1=1";
	} else {
		$provderWhere = "Vendor='" . $provider . "'";
	}
	$query = "Select count(*) as total from spec_sample where  " . $provderWhere . " " . $region;
	$results = $database->query($query);
	$total = $database->fetch_result($results,$result,'total');
	echo "<td>&nbsp;" .$total ."</td>\n";
	
	if ($report == "number") {

		$query = "Select count(*) as total from spec_sample where " . $provderWhere . " and HrsInd is not null and HrsInd != 0" . $region;
		$results = $database->query($query);
		$HrsInd = $database->fetch_result($results,$result,'total');
		echo "<td>&nbsp;" . $HrsInd ."</td>\n";
	
		$query = "Select count(*) as total from spec_sample where " . $provderWhere . " and HrsGroup is not null and HrsGroup != 0" . $region;
		$results = $database->query($query);
		$HrsGroup = $database->fetch_result($results,$result,'total');
		echo "<td>&nbsp;" . $HrsGroup ."</td>\n";
	
		$query = "Select count(*) as total from spec_sample where " . $provderWhere . " and HrsFac is not null and HrsFac != 0" . $region;
		$results = $database->query($query);
		$HrsFac = $database->fetch_result($results,$result,'total');
		echo "<td>&nbsp;" . $HrsFac ."</td>\n";
	
		$query = "Select count(*) as total from spec_sample where " . $provderWhere . " and (HrsVolunteer > 0  )";
		//$query = "Select sum(HrsVolunteer) as total from spec_sample where Vendor='" . $provider . "' and (HrsVolunteer > 0  )" . $region;
		$results = $database->query($query);
		$HrsVolunteer = $database->fetch_result($results,$result,'total');
		echo "<td>&nbsp;" . $HrsVolunteer ."</td>\n";
	
		$query = "Select count(*) as total from spec_sample where " . $provderWhere . " and HrsTransition is not null and HrsTransition != 0" . $region;
		$results = $database->query($query);
		$HrsTransition = $database->fetch_result($results,$result,'total');
		echo "<td>&nbsp;" . $HrsTransition  ."</td>\n";
		
		
		if ($total != 0 ) {
			echo "<td>&nbsp;" . number_format(($HrsInd/$total)*100, 1, '.', '') ."</td>\n";
		} else {
			echo "<td>&nbsp;" . 0 ."</td>\n";
		}

		
		if ($total != 0 ) {
			echo "<td>&nbsp;" . number_format(($HrsGroup/$total)*100, 1, '.', '') ."</td>\n";
		} else {
			echo "<td>&nbsp;" . 0 ."</td>\n";
		}
	

		if ($total != 0 ) {
			echo "<td>&nbsp;" . number_format(($HrsFac/$total)*100, 1, '.', '') ."</td>\n";
		} else {
			echo "<td>&nbsp;" . 0 ."</td>\n";
		}

		
		if ($total != 0 ) {
			echo "<td>&nbsp;" . number_format(($HrsVolunteer/$total)*100, 1, '.', '') ."</td>\n";
		} else {
			echo "<td>&nbsp;" . 0 ."</td>\n";
		}

		
		if ($total != 0 ) {
			echo "<td>&nbsp;" .  number_format(($HrsTransition/$total)*100, 1, '.', '') ."</td>\n";
		} else {
			echo "<td>&nbsp;" . 0 ."</td>\n";
		}

	}elseif ($report =="hours") {
		$columArray[] = 'HrsInd';
		$columArray[] = 'HrsGroup';
		$columArray[] = 'HrsFac';
		$columArray[] = 'HrsVolunteer';
		$columArray[] = 'HrsTransition';
		
		for($i=0; $i<count($columArray); $i++) {
			$query = "SELECT AVG(" . $columArray[$i] . ") AS mean FROM spec_sample where " . $provderWhere . "  and (" . $columArray[$i] . " > 0 ) " . $region;
			//echo "<td>&nbsp;" .$query ."</td>";
			$results = $database->query($query);
			echo "<td>&nbsp;" . number_format($database->fetch_result($results,$result,'mean'), 1, '.', '') . "</td>\n";
		}
		for($i=0; $i<count($columArray); $i++) {
			$query = "Select sum(" . $columArray[$i] . ") as part from spec_sample where " . $provderWhere . " and " . $columArray[$i] . " > 0" . $region;

			$results = $database->query($query);
			$part = $database->fetch_result($results,$result,'part');

			$query = "Select sum(totalHours) as total from spec_sample where " . $provderWhere . "  and (" . $columArray[$i] . " > 0 or " . $columArray[$i] . " = 0) " . $region;

			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');

			if ($total != 0 ) {

				echo "<td>&nbsp;" . number_format(($part/$total)*100, 1, '.', '') . "%</td>\n";
			} else {
				echo "<td>&nbsp;" . 0 . "</td>\n";
			}
		}
		
	}elseif ($report =="wage") {
		$columWagesArray[] = 'dol_ind';
		$columWagesArray[] = 'dol_Group';
		$columWagesArray[] = 'dol_Facility';
	
		for($i=0; $i<count($columWagesArray); $i++) {
			$results = $database->query("Select avg(" . $columWagesArray[$i] . ") as total from spec_sample where " . $provderWhere . " and " . $columWagesArray[$i] . " is not null and ". $columWagesArray[$i] . " !=0  " . $region);

			echo "<td>&nbsp;\$" . number_format( $database->fetch_result($results,$result,'total'), 2, '.', ',') ."</td>\n";
		}

		$columWagesOverArray[] = 'YNInd';
		$columWagesOverArray[] = 'YNGroup';
		$columWagesOverArray[] = 'YNFacility';

		for($i=0; $i<count($columWagesOverArray); $i++) {
			$results = $database->query("Select count(*) as total from spec_sample where " . $provderWhere . " and trim(" . $columWagesOverArray[$i] . ") in ('N','Y') " . $region);
			$totalRecords =  $database->fetch_result($results,$result,'total') ;

			$results = $database->query("Select count(*) as total from spec_sample where " . $provderWhere . " and trim(" . $columWagesOverArray[$i] . ") ='Y'" . $region);
			$part =  $database->fetch_result($results,$result,'total') ;

			if ($totalRecords != 0) {
				echo "<td>&nbsp;" .  number_format(($part/$totalRecords) * 100, 1, '.', '') ."%</td>\n";
			} else {
				echo "<td>&nbsp;0</td>\n";
			}
		}
	}
	echo "</tr>\n";
	$database->close();
}

var $ar_region_variables;
var $ar_region_variables_name;
var $ar_region_variables_axis;


}
?>
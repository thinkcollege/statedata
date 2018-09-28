<?php    
/*
class: dmr
purpose: useful functions for dmr
*/
class dmr extends mre_base{

function dmr () {
	
	$this->ar_region_variables[] ='Num_HrsInd';
	$this->ar_region_variables_name[] = 'Number participating in individual supported employment';
	$this->ar_region_variables_axis[] = 'Total';
	$this->ar_region_variables[] ='Num_HrsGroup';
	$this->ar_region_variables_name[] = 'Number participating in Group Supported Employment';
	$this->ar_region_variables_axis[] = 'Total';
	$this->ar_region_variables[] ='Num_HrsFac';
	$this->ar_region_variables_name[] = 'Number participating in Facility-Based Employment';
	$this->ar_region_variables_axis[] = 'Total';
	$this->ar_region_variables[] ='Num_HrsVolunteer';
	$this->ar_region_variables_name[] = 'Number participating in Volunteer or Non-Work Day Activities';
	$this->ar_region_variables_axis[] = 'Total';
	$this->ar_region_variables[] ='Num_HrsTransition';
	$this->ar_region_variables_name[] = 'Number participating reporting “in transition” hours';
	$this->ar_region_variables_axis[] = 'Total';
	
	
	$this->ar_region_variables[] ='Per_HrsInd';
	$this->ar_region_variables_name[] = 'Percent participating in individual supported employment';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_HrsGroup';
	$this->ar_region_variables_name[] = 'Percent participating in Group Supported Employment';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_HrsFac';
	$this->ar_region_variables_name[] = 'Percent participating in Facility-Based Employment';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_HrsVolunteer';
	$this->ar_region_variables_name[] = 'Percent participating in Volunteer or Non-Work Day Activities';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_HrsTransition';
	$this->ar_region_variables_name[] = 'Percent reporting “in transition” hours';
	$this->ar_region_variables_axis[] = 'Percent';
	
	$this->ar_region_variables[] ='Avg_HrsInd';
	$this->ar_region_variables_name[] = 'Mean hours/month per person in individual supported employment (for those who are participating)';
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
	$this->ar_region_variables_name[] = 'Mean hours/month per person reporting “in transition” hours';
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
	$this->ar_region_variables_name[] = 'Number employed in Individual Supported Employment for 10 of the last 12 months (of those participating in individual supported employment)';
	$this->ar_region_variables_axis[] = 'Total';
	$this->ar_region_variables[] ='Num_GroupSupEmp';
	$this->ar_region_variables_name[] = 'Number employed in Group Supported Employment for 10 of the last 12 months (of those participating in individual supported employment)';
	$this->ar_region_variables_axis[] = 'Total';
	
	$this->ar_region_variables[] ='Per_IndSupEmp';
	$this->ar_region_variables_name[] = 'Percent employed in Individual Supported Employment for 10 of the last 12 months (of those participating in individual supported employment)';
	$this->ar_region_variables_axis[] = 'Percent';
	$this->ar_region_variables[] ='Per_GroupSupEmp';
	$this->ar_region_variables_name[] = 'Percent employed in Group Supported Employment for 10 of the last 12 months (of those participating in individual supported employment)';
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
function getRegions($element_name, $showAll = 1) { 
	$database=new database;
	$database->connect();
	

	$results = $database->query("Select distinct region from spec_dmr2 where region != 'x' order by region");
	$html = "<select name=$element_name onkeydown=\"return on_keydown_form(document.form1,event,'login');\">";
	//$html = $html . "<option value=0>Choose Region</option>";
	
	if ($showAll == 1) {
		$html = $html . "<option value=ALL>All Regions</option>";
	}
	for ($result=0;$result< $database->num_rows($results);$result++){
		$html= $html . "<option value='". $database->fetch_result($results,$result,'region') ."'>" . $database->fetch_result($results,$result,'region') . "</option>\n";
	}
	
	$html= $html . "</select>\n";
	$database->close();
	return($html); 
}

/*
function: getProviders
purpose: returns a dropdown of providers in a given region
*/
function getProviders($element_name, $region, $showAll = 1) { 
	$database=new database;
	$database->connect();
	
	if ($region == 'ALL' || $region=='0') {
		$query = "Select distinct vendor from spec_dmr2 order by vendor";
	} else {
		$query = "Select distinct vendor from spec_dmr2 where region='". $region ."' order by vendor";
	}

	$results = $database->query($query);
	$html = "<select name=$element_name onkeydown=\"return on_keydown_form(document.form1,event,'login');\">";
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
	
	$html= $html . "<tr><td><input type=radio name=variable value='numberinactivity'></td><td>Number participating in activity</td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable value='percent'></td><td>Percent participating in activity</td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable value='totalhours'></td><td>Total # hours for activity</td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable value='meanhours'></td><td>Mean hours per activity (of those participating)</td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable value='totalwages'></td><td>Total wages per activity</td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable value='meanwage'></td><td>Mean wage per activity</td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable value='numberminimum'></td><td>Number earning at least minimum wage</td></tr>\n";
	$html= $html . "<tr><td><input type=radio name=variable value='percentminimum'></td><td>Percent earning at least minimum wage</td></tr>\n";
	$html= $html . "</table>\n";
	
	
	return($html); 
}



/*
function: getRegionVariables
purpose: returns a dropdown of providers in a given region
*/
function getRegionVariables() { 
	$html = "<table cellpadding=5>";
	for($i=0; $i<count($this->ar_region_variables); $i++) {
		$html= $html . "<tr><td><input type=radio name=variable value='".$this->ar_region_variables[$i]."'></td><td>". $this->ar_region_variables_name[$i] ."</td></tr>\n";
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

	} else {
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
	$database=new database;
	$database->connect();
	

	$results = $database->query("Select distinct region from spec_dmr2 where region != 'x' order by region");

	for ($result=0;$result< $database->num_rows($results);$result++){
		$columArray[] =  $database->fetch_result($results,$result,'region');
	}
	
	return($columArray);
}


/*
function: getLegendName
purpose: return the legend name for an activity
*/
function getLegendName($variable, $region, $provider) {
	$legendClause ="";
	if ($provider != "ALL") {
		$legendClause = $legendClause . " for ". $provider ." ";
	} else {
		$legendClause = $legendClause . " for all providers ";
	}
	
	if ($region != "ALL") {
		$legendClause = $legendClause .  " in the ". $region ." region"; 
	} else {
		$legendClause = $legendClause .  " in all regions"; 
	}
	
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
	}
	$legend = $legend . $legendClause;
	return ($legend);
}

/*
function: getRegionLegendName
purpose: return the legend name for an region view
*/
function getRegionLegendName($variable) {
	$legend = "";
	for($i=0; $i<count($this->ar_region_variables); $i++) {
		if ($this->ar_region_variables[$i] == $variable) {
			$legend = $this->ar_region_variables_name[$i];
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
function: getRegionVariableArray
purpose: return the values in each column for an region query
*/
function getRegionVariableArray ($variable) {
	$database=new database;
	$database->connect();
	$arRegions = $this->getRegionColumnNamesArray ();
	
	for($i=0; $i<count($arRegions); $i++) {

		if ($variable == 'Num_HrsInd') {
			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsInd is not null and HrsInd != 0";

			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Num_HrsGroup') {
			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsGroup is not null and HrsGroup != 0";
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Num_HrsFac') {
			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsFac is not null and HrsFac != 0";
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Num_HrsVolunteer') {
			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsVolunteer is not null and HrsVolunteer != 0";
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Num_HrsTransition') {
			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsTransition is not null and HrsTransition != 0";
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
			
			
		} elseif ($variable == 'Per_HrsInd') {
			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsInd is not null and HrsInd != 0 ";
			$results = $database->query($query);
			$fraction_top = $database->fetch_result($results,$result,'total');

			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' ";
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($fraction_top/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
		} elseif ($variable == 'Per_HrsGroup') {
			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsGroup is not null and HrsGroup != 0";
			$results = $database->query($query);
			$fraction_top = $database->fetch_result($results,$result,'total');

			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' ";
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($fraction_top/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
		} elseif ($variable == 'Per_HrsFac') {
			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsFac is not null and HrsFac != 0";
			$results = $database->query($query);
			$fraction_top = $database->fetch_result($results,$result,'total');

			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' ";
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($fraction_top/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
		} elseif ($variable == 'Per_HrsVolunteer') {
			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsVolunteer is not null and HrsVolunteer != 0";
			$results = $database->query($query);
			$fraction_top = $database->fetch_result($results,$result,'total');

			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' ";
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($fraction_top/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
		} elseif ($variable == 'Per_HrsTransition') {
			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsTransition is not null and HrsTransition != 0";
			$results = $database->query($query);
			$fraction_top = $database->fetch_result($results,$result,'total');

			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' ";
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($fraction_top/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}


			
		} elseif ($variable == 'Avg_HrsInd') {
			$query = "Select avg(HrsInd) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsInd is not null and HrsInd != 0";
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
			
		} elseif ($variable == 'Avg_hrsGroup') {
			$query = "Select avg(hrsGroup) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and hrsGroup is not null and hrsGroup != 0";
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Avg_HrsFac') {
			$query = "Select avg(HrsFac) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsFac is not null and HrsFac != 0";
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Avg_HrsVolunteer') {
			$query = "Select avg(HrsVolunteer) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsVolunteer is not null and HrsVolunteer != 0";
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Avg_HrsTransition') {
			$query = "Select avg(HrsTransition) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsTransition is not null and HrsTransition != 0";
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');


			
		} elseif ($variable == 'Per_total_HrsInd') {
			$query = "Select sum(HrsInd) as part from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsInd is not null and HrsInd != 0";

			$results = $database->query($query);
			$part = $database->fetch_result($results,$result,'part');
		
			$query = "Select sum(totalHours) as total from spec_dmr2 where region='" . $arRegions[$i] . "' ";

			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($part/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
		
		} elseif ($variable == 'Per_total_HrsGroup') {
			$query = "Select sum(HrsGroup) as part from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsGroup is not null and HrsGroup != 0";
			$results = $database->query($query);
			$part = $database->fetch_result($results,$result,'part');

			$query = "Select sum(totalHours) as total from spec_dmr2 where region='" . $arRegions[$i] . "' ";
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($part/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}

		} elseif ($variable == 'Per_total_HrsFac') {
			$query = "Select sum(HrsFac) as part from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsFac is not null and HrsFac != 0";
			$results = $database->query($query);
			$part = $database->fetch_result($results,$result,'part');

			$query = "Select sum(totalHours) as total from spec_dmr2 where region='" . $arRegions[$i] . "' ";
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($part/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}

		} elseif ($variable == 'Per_total_HrsVolunteer') {
			$query = "Select sum(HrsVolunteer) as part from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsVolunteer is not null and HrsVolunteer != 0";
			$results = $database->query($query);
			$part = $database->fetch_result($results,$result,'part');

			$query = "Select sum(totalHours) as total from spec_dmr2 where region='" . $arRegions[$i] . "' ";
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($part/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}

		} elseif ($variable == 'Per_total_HrsTransition') {
			$query = "Select sum(HrsTransition) as part from spec_dmr2 where region='" . $arRegions[$i] . "' and HrsTransition is not null and HrsTransition != 0";
			$results = $database->query($query);
			$part = $database->fetch_result($results,$result,'part');

			$query = "Select sum(totalHours) as total from spec_dmr2 where region='" . $arRegions[$i] . "' ";
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($part/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}

			
		} elseif ($variable == 'Avg_dol_ind') {
			$query = "Select avg(dol_ind) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and dol_ind is not null  and dol_ind != 0";
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Avg_dol_group') {
			$query = "Select avg(dol_group) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and dol_group is not null  and dol_group != 0";
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');

		} elseif ($variable == 'Avg_dol_Facility') {
			$query = "Select avg(dol_Facility) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and dol_Facility is not null  and dol_Facility != 0";
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
			
		} elseif ($variable == 'Per_YNInd') {
			$query = "Select count(*) as ys from spec_dmr2 where region='" . $arRegions[$i] . "' and trim(YNInd) = 'Y'";
			$results = $database->query($query);
			$ys = $database->fetch_result($results,$result,'ys');

			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and ( trim(YNInd) in ('Y','N')) ";
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($ys/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}

		} elseif ($variable == 'Per_YNGroup') {
			$query = "Select count(*) as ys from spec_dmr2 where region='" . $arRegions[$i] . "' and trim(YNGroup) = 'Y'";
			$results = $database->query($query);
			$ys = $database->fetch_result($results,$result,'ys');

			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "'and ( trim(YNGroup) in ('Y','N')) ";
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($ys/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
		} elseif ($variable == 'Per_YNFacility') {
			$query = "Select count(*) as ys from spec_dmr2 where region='" . $arRegions[$i] . "' and trim(YNFacility) = 'Y'";
			$results = $database->query($query);
			$ys = $database->fetch_result($results,$result,'ys');

			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and ( trim(YNFacility) in ('Y','N'))";
			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($ys/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
			
			
		} elseif ($variable == 'Num_IndSupEmp') {
			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and trim(IndSupEmp) = 'Y'";
			$results = $database->query($query);
			$returnArray[$i]  = $database->fetch_result($results,$result,'total');
		} elseif ($variable == 'Num_GroupSupEmp') {
			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and trim(GroupSupEmp) = 'Y'";
			$results = $database->query($query);
			$returnArray[$i]  = $database->fetch_result($results,$result,'total');


		} elseif ($variable == 'Per_IndSupEmp') {
			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and trim(IndSupEmp) = 'Y'";
			$results = $database->query($query);
			$fraction_top  = $database->fetch_result($results,$result,'total');

			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and ( trim(IndSupEmp) in ('Y','N'))";
			$results = $database->query($query);
			$total  = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
				$returnArray[$i] = ($fraction_top/$total)*100;
			} else {
				$returnArray[$i] = 0;
			}
			
		} elseif ($variable == 'Per_GroupSupEmp') {
			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and trim(GroupSupEmp) = 'Y'";
			$results = $database->query($query);
			$fraction_top  = $database->fetch_result($results,$result,'total');

			$query = "Select count(*) as total from spec_dmr2 where region='" . $arRegions[$i] . "' and ( trim(GroupSupEmp) in ('Y', 'N')) ";
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
function getActivityVariableArray ($variableType, $region, $provider) {
	$database=new database;
	$database->connect();
	
	$columArray[] = 'HrsInd';
	$columArray[] = 'HrsGroup';
	$columArray[] = 'HrsFac';
	$columArray[] = 'HrsVolunteer';
	$columArray[] = 'HrsTransition';
	
	$whereClause = "";

	if ($region != "ALL") {
		$whereClause = " and region = '". $region ."' "; 
	} 

	if ($provider != "ALL") {
		$whereClause = $whereClause . " and vendor='". $provider ."'";
	} 

	$results = $database->query("Select count(*) as total from spec_dmr2 where 1=1" . $whereClause );
	$totalRecords = $database->fetch_result($results,$result,'total');
			
	if ($variableType == 'numberinactivity') {
		for($i=0; $i<count($columArray); $i++) {
			$query = "Select count(*) as total from spec_dmr2 where " . $columArray[$i] . " is not null and ". $columArray[$i] . " !=0 ". $whereClause ;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		}
	} elseif ($variableType == 'percent') {
		for($i=0; $i<count($columArray); $i++) {
			$results = $database->query("Select count(*) as total from spec_dmr2 where " . $columArray[$i] . " is not null and ". $columArray[$i] . " !=0  ". $whereClause);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		}
		for($i=0; $i<count($returnArray); $i++) {
			$returnArray[$i] = ($returnArray[$i]/$totalRecords) * 100;
		}
	} elseif ($variableType == 'totalhours') {
		for($i=0; $i<count($columArray); $i++) {
			$query = "Select sum(" . $columArray[$i] . ") as total from spec_dmr2 where " . $columArray[$i] . " is not null and ". $columArray[$i] . " !=0  " . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		}
	} elseif ($variableType == 'meanhours') {
		for($i=0; $i<count($columArray); $i++) {
			//$query = "DROP TABLE IF EXISTS medians";
			//$temp_table_q = $database->query($query);
	
			//$query = "CREATE TEMPORARY TABLE medians SELECT x." . $columArray[$i] . " medians FROM spec_dmr2 x, spec_dmr2 y	GROUP BY x." . $columArray[$i] . "	HAVING SUM(y." . $columArray[$i] . " <= x." . $columArray[$i] . ") >= COUNT(*)/2 AND SUM(y." . $columArray[$i] . " >= x." . $columArray[$i] . ") >= COUNT(*)/2;";
	
			//$temp_table_q = $database->query($query);
			
			//$query = "SELECT AVG(medians) AS median FROM medians";
			$query = "SELECT AVG(" . $columArray[$i] . ") AS mean FROM spec_dmr2 where  " . $columArray[$i] . " is not null and ". $columArray[$i] . " !=0  " . $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'mean');
		}
		

	} elseif ($variableType == 'totalwages') {
		$columWagesArray[] = 'dol_ind';
		$columWagesArray[] = 'dol_Group';
		$columWagesArray[] = 'dol_Facility';
	
		$results = $database->query("Select count(*) as total from spec_dmr2 where 1=1 " . $columWagesArray[$i] . " is not null  ". $whereClause);
		$totalRecords = $database->fetch_result($results,$result,'total');

		for($i=0; $i<count($columWagesArray); $i++) {
			$results = $database->query("Select sum(" . $columWagesArray[$i] . ") as total from spec_dmr2 where " . $columWagesArray[$i] . " is not null and ". $columWagesArray[$i] . " !=0  ". $whereClause);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		}
	} elseif ($variableType == 'meanwage') {
		$columWagesArray[] = 'dol_ind';
		$columWagesArray[] = 'dol_Group';
		$columWagesArray[] = 'dol_Facility';
	
		for($i=0; $i<count($columWagesArray); $i++) {
			$results = $database->query("Select avg(" . $columWagesArray[$i] . ") as total from spec_dmr2 where " . $columWagesArray[$i] . " is not null and ". $columWagesArray[$i] . " !=0  " . $whereClause);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		}
	} elseif ($variableType == 'numberminimum') {
		$columWagesArray[] = 'YNInd';
		$columWagesArray[] = 'YNGroup';
		$columWagesArray[] = 'YNFacility';

		for($i=0; $i<count($columWagesArray); $i++) {
			$query = "Select count(" . $columWagesArray[$i] . ") as total from spec_dmr2 where trim(" . $columWagesArray[$i] . ") = 'Y' ". $whereClause;
			$results = $database->query($query);
			$returnArray[$i] = $database->fetch_result($results,$result,'total');
		}
	} elseif ($variableType == 'percentminimum') {
		$columWagesArray[] = 'YNInd';
		$columWagesArray[] = 'YNGroup';
		$columWagesArray[] = 'YNFacility';
	
		for($i=0; $i<count($columWagesArray); $i++) {
			$query = "Select count(*) as total from spec_dmr2 where trim( " . $columWagesArray[$i] . " ) IN ('N', 'Y') ". $whereClause;
			
			$results = $database->query($query);
			$totalRecords = $database->fetch_result($results,$result,'total');
			
			$query = "Select count(" . $columWagesArray[$i] . ") as total from spec_dmr2 where trim(" . $columWagesArray[$i] . ") = 'Y' ". $whereClause;
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
	}

	$database->close();
	return($returnArray);
}
/*
function: getProvidersArray
purpose: returns an array of providers in a region
*/
function getProvidersArray ($region) {
	$database=new database;
	$database->connect();
	if ($region == "ALL") {
		$query = "Select distinct vendor from spec_dmr2 order by vendor";
	} else {
		$query = "Select distinct vendor from spec_dmr2 where region='".$region."' order by vendor";
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
function getRowData($provider, $report, $region, $year ='none') {
	$database=new database;
	$database->connect();
	if ($region == "ALL") {
		$region = " ";
	} else {
		$region = " and region='". $region ."' ";
	}
	if ($year != "none") {
		$region = $region . " and reporting_period='" . $year . "' ";
	}
	
	echo "<tr>\n";
	echo "<td>" .$provider ."</td>\n";
	$query = "Select count(*) as total from spec_dmr2 where Vendor='" . $provider . "' " . $region;
	$results = $database->query($query);
	$total = $database->fetch_result($results,$result,'total');
	echo "<td>" .$total ."</td>\n";
	if ($report == "number") {

		$query = "Select count(*) as total from spec_dmr2 where Vendor='" . $provider . "' and HrsInd is not null and HrsInd != 0" . $region;
		$results = $database->query($query);
		$HrsInd = $database->fetch_result($results,$result,'total');
		echo "<td>" . $HrsInd ."</td>\n";
	
		$query = "Select count(*) as total from spec_dmr2 where Vendor='" . $provider . "' and HrsGroup is not null and HrsGroup != 0" . $region;
		$results = $database->query($query);
		$HrsGroup = $database->fetch_result($results,$result,'total');
		echo "<td>" . $HrsGroup ."</td>\n";
	
		$query = "Select count(*) as total from spec_dmr2 where Vendor='" . $provider . "' and HrsFac is not null and HrsFac != 0" . $region;
		$results = $database->query($query);
		$HrsFac = $database->fetch_result($results,$result,'total');
		echo "<td>" . $HrsFac ."</td>\n";
	
		$query = "Select count(*) as total from spec_dmr2 where Vendor='" . $provider . "' and (HrsVolunteer > 0  )" . $region;
		$results = $database->query($query);
		$HrsVolunteer = $database->fetch_result($results,$result,'total');
		echo "<td>" . $HrsVolunteer ."</td>\n";
	
		$query = "Select count(*) as total from spec_dmr2 where Vendor='" . $provider . "' and HrsTransition is not null and HrsTransition != 0" . $region;
		$results = $database->query($query);
		$HrsTransition = $database->fetch_result($results,$result,'total');
		echo "<td>" . $HrsTransition  ."</td>\n";
		
		
		if ($total != 0 ) {
			echo "<td>" . number_format(($HrsInd/$total)*100, 1, '.', '') ."%</td>\n";
		} else {
			echo "<td>" . 0 ."</td>\n";
		}

		
		if ($total != 0 ) {
			echo "<td>" . number_format(($HrsGroup/$total)*100, 1, '.', '') ."%</td>\n";
		} else {
			echo "<td>" . 0 ."</td>\n";
		}
	

		if ($total != 0 ) {
			echo "<td>" . number_format(($HrsFac/$total)*100, 1, '.', '') ."%</td>\n";
		} else {
			echo "<td>" . 0 ."</td>\n";
		}

		
		if ($total != 0 ) {
			echo "<td>" . number_format(($HrsVolunteer/$total)*100, 1, '.', '') ."%</td>\n";
		} else {
			echo "<td>" . 0 ."</td>\n";
		}

		
		if ($total != 0 ) {
			echo "<td>" .  number_format(($HrsTransition/$total)*100, 1, '.', '') ."%</td>\n";
		} else {
			echo "<td>" . 0 ."</td>\n";
		}

	}elseif ($report =="hours") {
		$columArray[] = 'HrsInd';
		$columArray[] = 'HrsGroup';
		$columArray[] = 'HrsFac';
		$columArray[] = 'HrsVolunteer';
		$columArray[] = 'HrsTransition';
		
		for($i=0; $i<count($columArray); $i++) {
			$query = "SELECT AVG(" . $columArray[$i] . ") AS mean FROM spec_dmr2 where Vendor='" . $provider . "'  and (" . $columArray[$i] . " > 0 or " . $columArray[$i] . " = 0) " . $region;
			$results = $database->query($query);
			echo "<td>" . number_format($database->fetch_result($results,$result,'mean'), 1, '.', '') . "</td>\n";
		}
		for($i=0; $i<count($columArray); $i++) {
			$query = "Select sum(" . $columArray[$i] . ") as part from spec_dmr2 where Vendor='" . $provider . "' and " . $columArray[$i] . " > 0" . $region;

			$results = $database->query($query);
			$part = $database->fetch_result($results,$result,'part');
		
			$query = "Select sum(totalHours) as total from spec_dmr2 where Vendor='" . $provider . "'  and (" . $columArray[$i] . " > 0 or " . $columArray[$i] . " = 0) " . $region;

			$results = $database->query($query);
			$total = $database->fetch_result($results,$result,'total');
			
			if ($total != 0 ) {
			
				echo "<td>" . number_format(($part/$total)*100, 1, '.', '') . "%</td>\n";
			} else {
				echo "<td>" . 0 . "</td>\n";
			}
		}
		
	}elseif ($report =="wage") {
		$columWagesArray[] = 'dol_ind';
		$columWagesArray[] = 'dol_Group';
		$columWagesArray[] = 'dol_Facility';
	
		for($i=0; $i<count($columWagesArray); $i++) {
			$results = $database->query("Select avg(" . $columWagesArray[$i] . ") as total from spec_dmr2 where Vendor='" . $provider . "' and " . $columWagesArray[$i] . " is not null and ". $columWagesArray[$i] . " !=0  " . $region);
			
			echo "<td>" . number_format( $database->fetch_result($results,$result,'total'), 1, '.', '') ."</td>\n";
		}
		
		$columWagesOverArray[] = 'YNInd';
		$columWagesOverArray[] = 'YNGroup';
		$columWagesOverArray[] = 'YNFacility';
	
		for($i=0; $i<count($columWagesOverArray); $i++) {
			$results = $database->query("Select count(*) as total from spec_dmr2 where Vendor='" . $provider . "' and trim(" . $columWagesOverArray[$i] . ") in ('N','Y') " . $region);
			$totalRecords =  $database->fetch_result($results,$result,'total') ;
		
			$results = $database->query("Select count(*) as total from spec_dmr2 where Vendor='" . $provider . "' and trim(" . $columWagesOverArray[$i] . ") ='Y'" . $region);
			$part =  $database->fetch_result($results,$result,'total') ;

			if ($totalRecords != 0) {
				echo "<td>" .  number_format(($part/$totalRecords) * 100, 1, '.', '') ."%</td>\n";
			} else {
				echo "<td>0</td>\n";
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
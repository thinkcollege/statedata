<?php    
/*
class: information
purpose: support information
*/
class information extends basedata{

/*
function: generate_devices
*/
function generate_devices($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("ia");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["IS_participanttotal"], $headings["IS_disability"], $headings["IS_family"], $headings["IS_education"],
			 $headings["IS_employ"], $headings["IS_health"], $headings["IS_commliving"], $headings["IS_tech"], $headings["IS_otherpaticipant"]);
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["IS_participanttotal"], $headings["IS_disability"], $headings["IS_family"], $headings["IS_education"],
			 $headings["IS_employ"], $headings["IS_health"], $headings["IS_commliving"], $headings["IS_tech"], $headings["IS_otherpaticipant"]);

	} else {
		$dd["headings"] = array("", $headings["IS_participanttotal"], $headings["IS_disability"], $headings["IS_family"], $headings["IS_education"],
			 $headings["IS_employ"], $headings["IS_health"], $headings["IS_commliving"], $headings["IS_tech"], $headings["IS_otherpaticipant"]);
	}
	$dd["pscript_headings"] = "Disability;Family;Education;Employ;Health;Commliving living;Technology;Other paticipant";
	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and data.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program" || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."ia`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."ia`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			FORMAT(IS_participanttotal,0) as participanttotal, 
			IS_participanttotal as participanttotal_num, 
			IF((((IS_disability)/IS_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IS_disability)/IS_participanttotal)*100),1),'%'))  as Disability, 
			IF((((IS_disability)/IS_participanttotal)*100) is NULL, '0' ,ROUND((((IS_disability)/IS_participanttotal)*100),1))  as Disability_num, 
			IF((((IS_family)/IS_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IS_family)/IS_participanttotal)*100),1),'%'))  as Family, 
			IF((((IS_family)/IS_participanttotal)*100) is NULL, '0' , ROUND((((IS_family)/IS_participanttotal)*100),1))  as Family_num, 
			IF((((IS_education)/IS_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IS_education)/IS_participanttotal)*100),1),'%'))  as Education, 
			IF((((IS_education)/IS_participanttotal)*100) is NULL, '0' ,ROUND((((IS_education)/IS_participanttotal)*100),1))  as Education_num, 
			IF((((IS_employ)/IS_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IS_employ)/IS_participanttotal)*100),1),'%'))  as Employ, 
			IF((((IS_employ)/IS_participanttotal)*100) is NULL, '0' ,ROUND((((IS_employ)/IS_participanttotal)*100),1))  as Employ_num, 
			IF((((IS_health)/IS_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IS_health)/IS_participanttotal)*100),1),'%'))  as Health, 
			IF((((IS_health)/IS_participanttotal)*100) is NULL, '0' ,ROUND((((IS_health)/IS_participanttotal)*100),1))  as Health_num, 
			IF((((IS_commliving)/IS_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IS_commliving)/IS_participanttotal)*100),1),'%'))  as Commliving, 
			IF((((IS_commliving)/IS_participanttotal)*100) is NULL, '0' ,ROUND((((IS_commliving)/IS_participanttotal)*100),1))  as Commliving_num, 
			IF((((IS_tech)/IS_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IS_tech)/IS_participanttotal)*100),1),'%'))  as Tech, 
			IF((((IS_tech)/IS_participanttotal)*100) is NULL, '0' ,ROUND((((IS_tech)/IS_participanttotal)*100),1))  as Tech_num, 
			IF((((IS_otherpaticipant)/IS_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IS_otherpaticipant)/IS_participanttotal)*100),1),'%'))  as Otherpaticipant, 
			IF((((IS_otherpaticipant)/IS_participanttotal)*100) is NULL, '0' ,ROUND((((IS_otherpaticipant)/IS_participanttotal)*100),1))  as Otherpaticipant_num 
			from ". $this->database_table_prefix ."ia data $join , ". $this->database_table_prefix ."states s
			where  s.abbreviation = data.State $whereYear and data.State in ($states) order by data.Year, data.State ";
	//echo $query;
	$results = $database->query($query);
	for ($result=0;$result< $database->num_rows($results);$result++){
		$state = $database->fetch_result($results,$result,'State');
		$rowYear = $database->fetch_result($results,$result,'Year');
		$stateName = $database->fetch_result($results,$result,'StateName');
		$participanttotal = $database->fetch_result($results,$result,'participanttotal');
		$disability = $database->fetch_result($results,$result,'Disability');
		$family = $database->fetch_result($results,$result,'Family');
		$education = $database->fetch_result($results,$result,'Education');
		$employ = $database->fetch_result($results,$result,'Employ');
		$health = $database->fetch_result($results,$result,'Health');
		$commliving = $database->fetch_result($results,$result,'Commliving');
		$tech = $database->fetch_result($results,$result,'Tech');
		$otherpaticipant = $database->fetch_result($results,$result,'Otherpaticipant');
		
		$disability_num = $database->fetch_result($results,$result,'Disability_num');
		$family_num = $database->fetch_result($results,$result,'Family_num');
		$education_num = $database->fetch_result($results,$result,'Education_num');
		$employ_num = $database->fetch_result($results,$result,'Employ_num');
		$health_num = $database->fetch_result($results,$result,'Health_num');
		$commliving_num = $database->fetch_result($results,$result,'Commliving_num');
		$tech_num = $database->fetch_result($results,$result,'Tech_num');
		$otherpaticipant_num = $database->fetch_result($results,$result,'Otherpaticipant_num');

		if ($reporttype == "single"){
			$dd["data"][] = array($rowYear,$participanttotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
		} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
			$dd["data"][] = array($stateName,$rowYear,$participanttotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
		} else {
			$dd["data"][] = array($stateName,$participanttotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
		}
		if ($reporttype == "oneyear"){
			$dd["pscript_data"][] = "'$stateName';$disability_num;$family_num;$education_num;$employ_num;$health_num;$commliving_num;$tech_num;$otherpaticipant_num";
		} else if ($reporttype == "single"){
			$dd["pscript_data"][] = "'$rowYear';$disability_num;$family_num;$education_num;$employ_num;$health_num;$commliving_num;$tech_num;$otherpaticipant_num";
		}
	}
	$database->close();
	return($dd); 
}

/*
function: generate_funding
*/
function generate_funding($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("ia");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["IF_participanttotal"], $headings["IF_disability"], $headings["IF_family"], $headings["IF_education"],
			 $headings["IF_employ"], $headings["IF_health"], $headings["IF_commliving"], $headings["IF_tech"], $headings["IF_otherpaticipant"]);
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["IF_participanttotal"], $headings["IF_disability"], $headings["IF_family"], $headings["IF_education"],
			 $headings["IF_employ"], $headings["IF_health"], $headings["IF_commliving"], $headings["IF_tech"], $headings["IF_otherpaticipant"]);

	} else {
		$dd["headings"] = array("", $headings["IF_participanttotal"], $headings["IF_disability"], $headings["IF_family"], $headings["IF_education"],
			 $headings["IF_employ"], $headings["IF_health"], $headings["IF_commliving"], $headings["IF_tech"], $headings["IF_otherpaticipant"]);
	}
	$dd["pscript_headings"] = "Disability;Family;Education;Employ;Health;Commliving living;Technology;Other paticipant";
	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and data.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program" || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."ia`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."ia`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			FORMAT(IF_participanttotal,0) as participanttotal, 
			IF_participanttotal as participanttotal_num, 
			IF((((IF_disability)/IF_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IF_disability)/IF_participanttotal)*100),1),'%'))  as Disability, 
			IF((((IF_disability)/IF_participanttotal)*100) is NULL, '0' ,ROUND((((IF_disability)/IF_participanttotal)*100),1))  as Disability_num, 
			IF((((IF_family)/IF_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IF_family)/IF_participanttotal)*100),1),'%'))  as Family, 
			IF((((IF_family)/IF_participanttotal)*100) is NULL, '0' , ROUND((((IF_family)/IF_participanttotal)*100),1))  as Family_num, 
			IF((((IF_education)/IF_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IF_education)/IF_participanttotal)*100),1),'%'))  as Education, 
			IF((((IF_education)/IF_participanttotal)*100) is NULL, '0' ,ROUND((((IF_education)/IF_participanttotal)*100),1))  as Education_num, 
			IF((((IF_employ)/IF_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IF_employ)/IF_participanttotal)*100),1),'%'))  as Employ, 
			IF((((IF_employ)/IF_participanttotal)*100) is NULL, '0' ,ROUND((((IF_employ)/IF_participanttotal)*100),1))  as Employ_num, 
			IF((((IF_health)/IF_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IF_health)/IF_participanttotal)*100),1),'%'))  as Health, 
			IF((((IF_health)/IF_participanttotal)*100) is NULL, '0' ,ROUND((((IF_health)/IF_participanttotal)*100),1))  as Health_num, 
			IF((((IF_commliving)/IF_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IF_commliving)/IF_participanttotal)*100),1),'%'))  as Commliving, 
			IF((((IF_commliving)/IF_participanttotal)*100) is NULL, '0' ,ROUND((((IF_commliving)/IF_participanttotal)*100),1))  as Commliving_num, 
			IF((((IF_tech)/IF_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IF_tech)/IF_participanttotal)*100),1),'%'))  as Tech, 
			IF((((IF_tech)/IF_participanttotal)*100) is NULL, '0' ,ROUND((((IF_tech)/IF_participanttotal)*100),1))  as Tech_num, 
			IF((((IF_otherpaticipant)/IF_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((IF_otherpaticipant)/IF_participanttotal)*100),1),'%'))  as Otherpaticipant, 
			IF((((IF_otherpaticipant)/IF_participanttotal)*100) is NULL, '0' ,ROUND((((IF_otherpaticipant)/IF_participanttotal)*100),1))  as Otherpaticipant_num 
			from ". $this->database_table_prefix ."ia data $join , ". $this->database_table_prefix ."states s
			where  s.abbreviation = data.State $whereYear and data.State in ($states) order by data.Year, data.State ";
	//echo $query;
	$results = $database->query($query);
	for ($result=0;$result< $database->num_rows($results);$result++){
		$state = $database->fetch_result($results,$result,'State');
		$rowYear = $database->fetch_result($results,$result,'Year');
		$stateName = $database->fetch_result($results,$result,'StateName');
		$participanttotal = $database->fetch_result($results,$result,'participanttotal');
		$disability = $database->fetch_result($results,$result,'Disability');
		$family = $database->fetch_result($results,$result,'Family');
		$education = $database->fetch_result($results,$result,'Education');
		$employ = $database->fetch_result($results,$result,'Employ');
		$health = $database->fetch_result($results,$result,'Health');
		$commliving = $database->fetch_result($results,$result,'Commliving');
		$tech = $database->fetch_result($results,$result,'Tech');
		$otherpaticipant = $database->fetch_result($results,$result,'Otherpaticipant');
		
		$disability_num = $database->fetch_result($results,$result,'Disability_num');
		$family_num = $database->fetch_result($results,$result,'Family_num');
		$education_num = $database->fetch_result($results,$result,'Education_num');
		$employ_num = $database->fetch_result($results,$result,'Employ_num');
		$health_num = $database->fetch_result($results,$result,'Health_num');
		$commliving_num = $database->fetch_result($results,$result,'Commliving_num');
		$tech_num = $database->fetch_result($results,$result,'Tech_num');
		$otherpaticipant_num = $database->fetch_result($results,$result,'Otherpaticipant_num');

		if ($reporttype == "single"){
			$dd["data"][] = array($rowYear,$participanttotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
		} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
			$dd["data"][] = array($stateName,$rowYear,$participanttotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
		} else {
			$dd["data"][] = array($stateName,$participanttotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
		}
		if ($reporttype == "oneyear"){
			$dd["pscript_data"][] = "'$stateName';$disability_num;$family_num;$education_num;$employ_num;$health_num;$commliving_num;$tech_num;$otherpaticipant_num";
		} else if ($reporttype == "single"){
			$dd["pscript_data"][] = "'$rowYear';$disability_num;$family_num;$education_num;$employ_num;$health_num;$commliving_num;$tech_num;$otherpaticipant_num";
		}
	}
	$database->close();
	return($dd); 
}

/*
function: generate_disability
*/
function generate_disability($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("ia");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["ID_participanttotal"], $headings["ID_disability"], $headings["ID_family"], $headings["ID_education"],
			 $headings["ID_employ"], $headings["ID_health"], $headings["ID_commliving"], $headings["ID_tech"], $headings["ID_otherpaticipant"]);
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["ID_participanttotal"], $headings["ID_disability"], $headings["ID_family"], $headings["ID_education"],
			 $headings["ID_employ"], $headings["ID_health"], $headings["ID_commliving"], $headings["ID_tech"], $headings["ID_otherpaticipant"]);

	} else {
		$dd["headings"] = array("", $headings["ID_participanttotal"], $headings["ID_disability"], $headings["ID_family"], $headings["ID_education"],
			 $headings["ID_employ"], $headings["ID_health"], $headings["ID_commliving"], $headings["ID_tech"], $headings["ID_otherpaticipant"]);
	}
	$dd["pscript_headings"] = "Disability;Family;Education;Employ;Health;Commliving living;Technology;Other paticipant";
	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and data.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program" || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."ia`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."ia`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			FORMAT(ID_participanttotal,0) as participanttotal, 
			ID_participanttotal as participanttotal_num, 
			IF((((ID_disability)/ID_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((ID_disability)/ID_participanttotal)*100),1),'%'))  as Disability, 
			IF((((ID_disability)/ID_participanttotal)*100) is NULL, '0' ,ROUND((((ID_disability)/ID_participanttotal)*100),1))  as Disability_num, 
			IF((((ID_family)/ID_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((ID_family)/ID_participanttotal)*100),1),'%'))  as Family, 
			IF((((ID_family)/ID_participanttotal)*100) is NULL, '0' , ROUND((((ID_family)/ID_participanttotal)*100),1))  as Family_num, 
			IF((((ID_education)/ID_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((ID_education)/ID_participanttotal)*100),1),'%'))  as Education, 
			IF((((ID_education)/ID_participanttotal)*100) is NULL, '0' ,ROUND((((ID_education)/ID_participanttotal)*100),1))  as Education_num, 
			IF((((ID_employ)/ID_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((ID_employ)/ID_participanttotal)*100),1),'%'))  as Employ, 
			IF((((ID_employ)/ID_participanttotal)*100) is NULL, '0' ,ROUND((((ID_employ)/ID_participanttotal)*100),1))  as Employ_num, 
			IF((((ID_health)/ID_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((ID_health)/ID_participanttotal)*100),1),'%'))  as Health, 
			IF((((ID_health)/ID_participanttotal)*100) is NULL, '0' ,ROUND((((ID_health)/ID_participanttotal)*100),1))  as Health_num, 
			IF((((ID_commliving)/ID_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((ID_commliving)/ID_participanttotal)*100),1),'%'))  as Commliving, 
			IF((((ID_commliving)/ID_participanttotal)*100) is NULL, '0' ,ROUND((((ID_commliving)/ID_participanttotal)*100),1))  as Commliving_num, 
			IF((((ID_tech)/ID_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((ID_tech)/ID_participanttotal)*100),1),'%'))  as Tech, 
			IF((((ID_tech)/ID_participanttotal)*100) is NULL, '0' ,ROUND((((ID_tech)/ID_participanttotal)*100),1))  as Tech_num, 
			IF((((ID_otherpaticipant)/ID_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((ID_otherpaticipant)/ID_participanttotal)*100),1),'%'))  as Otherpaticipant, 
			IF((((ID_otherpaticipant)/ID_participanttotal)*100) is NULL, '0' ,ROUND((((ID_otherpaticipant)/ID_participanttotal)*100),1))  as Otherpaticipant_num 
			from ". $this->database_table_prefix ."ia data $join , ". $this->database_table_prefix ."states s
			where  s.abbreviation = data.State $whereYear and data.State in ($states) order by data.Year, data.State ";
	//echo $query;
	$results = $database->query($query);
	for ($result=0;$result< $database->num_rows($results);$result++){
		$state = $database->fetch_result($results,$result,'State');
		$rowYear = $database->fetch_result($results,$result,'Year');
		$stateName = $database->fetch_result($results,$result,'StateName');
		$participanttotal = $database->fetch_result($results,$result,'participanttotal');
		$disability = $database->fetch_result($results,$result,'Disability');
		$family = $database->fetch_result($results,$result,'Family');
		$education = $database->fetch_result($results,$result,'Education');
		$employ = $database->fetch_result($results,$result,'Employ');
		$health = $database->fetch_result($results,$result,'Health');
		$commliving = $database->fetch_result($results,$result,'Commliving');
		$tech = $database->fetch_result($results,$result,'Tech');
		$otherpaticipant = $database->fetch_result($results,$result,'Otherpaticipant');
		
		$disability_num = $database->fetch_result($results,$result,'Disability_num');
		$family_num = $database->fetch_result($results,$result,'Family_num');
		$education_num = $database->fetch_result($results,$result,'Education_num');
		$employ_num = $database->fetch_result($results,$result,'Employ_num');
		$health_num = $database->fetch_result($results,$result,'Health_num');
		$commliving_num = $database->fetch_result($results,$result,'Commliving_num');
		$tech_num = $database->fetch_result($results,$result,'Tech_num');
		$otherpaticipant_num = $database->fetch_result($results,$result,'Otherpaticipant_num');

		if ($reporttype == "single"){
			$dd["data"][] = array($rowYear,$participanttotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
		} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
			$dd["data"][] = array($stateName,$rowYear,$participanttotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
		} else {
			$dd["data"][] = array($stateName,$participanttotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
		}
		if ($reporttype == "oneyear"){
			$dd["pscript_data"][] = "'$stateName';$disability_num;$family_num;$education_num;$employ_num;$health_num;$commliving_num;$tech_num;$otherpaticipant_num";
		} else if ($reporttype == "single"){
			$dd["pscript_data"][] = "'$rowYear';$disability_num;$family_num;$education_num;$employ_num;$health_num;$commliving_num;$tech_num;$otherpaticipant_num";
		}
	}
	$database->close();
	return($dd); 
}


		
}
?>
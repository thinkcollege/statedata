<?php    
/*
class: trainings
purpose: support trainings
*/
class trainings extends basedata{


/*
function: generate_training_partcipants
*/
function generate_training_partcipants($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("tp");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["TP_participanttotal"], $headings["TP_disability"], $headings["TP_family"], $headings["TP_education"],
			 $headings["TP_employ"], $headings["TP_health"], $headings["TP_commliving"], $headings["TP_tech"], $headings["TP_otherpaticipant"]);
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["TP_participanttotal"], $headings["TP_disability"], $headings["TP_family"], $headings["TP_education"],
			 $headings["TP_employ"], $headings["TP_health"], $headings["TP_commliving"], $headings["TP_tech"], $headings["TP_otherpaticipant"]);

	} else {
		$dd["headings"] = array("", $headings["TP_participanttotal"], $headings["TP_disability"], $headings["TP_family"], $headings["TP_education"],
			 $headings["TP_employ"], $headings["TP_health"], $headings["TP_commliving"], $headings["TP_tech"], $headings["TP_otherpaticipant"]);
	}
	$dd["pscript_headings"] = "Disability;Family;Education;Employ;Health;Commliving living;Technology;Other paticipant";
	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and data.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program" || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."tp`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."tp`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			FORMAT(TP_participanttotal,0) as typetotal, 
			TP_participanttotal as typetotal_num, 
			IF((((TP_disability)/TP_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((TP_disability)/TP_participanttotal)*100),1),'%'))  as Disability, 
			IF((((TP_disability)/TP_participanttotal)*100) is NULL, '0' ,ROUND((((TP_disability)/TP_participanttotal)*100),1))  as Disability_num, 
			IF((((TP_family)/TP_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((TP_family)/TP_participanttotal)*100),1),'%'))  as Family, 
			IF((((TP_family)/TP_participanttotal)*100) is NULL, '0' , ROUND((((TP_family)/TP_participanttotal)*100),1))  as Family_num, 
			IF((((TP_education)/TP_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((TP_education)/TP_participanttotal)*100),1),'%'))  as Education, 
			IF((((TP_education)/TP_participanttotal)*100) is NULL, '0' ,ROUND((((TP_education)/TP_participanttotal)*100),1))  as Education_num, 
			IF((((TP_employ)/TP_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((TP_employ)/TP_participanttotal)*100),1),'%'))  as Employ, 
			IF((((TP_employ)/TP_participanttotal)*100) is NULL, '0' ,ROUND((((TP_employ)/TP_participanttotal)*100),1))  as Employ_num, 
			IF((((TP_health)/TP_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((TP_health)/TP_participanttotal)*100),1),'%'))  as Health, 
			IF((((TP_health)/TP_participanttotal)*100) is NULL, '0' ,ROUND((((TP_health)/TP_participanttotal)*100),1))  as Health_num, 
			IF((((TP_commliving)/TP_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((TP_commliving)/TP_participanttotal)*100),1),'%'))  as Commliving, 
			IF((((TP_commliving)/TP_participanttotal)*100) is NULL, '0' ,ROUND((((TP_commliving)/TP_participanttotal)*100),1))  as Commliving_num, 
			IF((((TP_tech)/TP_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((TP_tech)/TP_participanttotal)*100),1),'%'))  as Tech, 
			IF((((TP_tech)/TP_participanttotal)*100) is NULL, '0' ,ROUND((((TP_tech)/TP_participanttotal)*100),1))  as Tech_num, 
			IF((((TP_otherpaticipant)/TP_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((TP_otherpaticipant)/TP_participanttotal)*100),1),'%'))  as Otherpaticipant, 
			IF((((TP_otherpaticipant)/TP_participanttotal)*100) is NULL, '0' ,ROUND((((TP_otherpaticipant)/TP_participanttotal)*100),1))  as Otherpaticipant_num 
			from ". $this->database_table_prefix ."tp data $join , ". $this->database_table_prefix ."states s
			where  s.abbreviation = data.State $whereYear and data.State in ($states) order by data.Year, data.State ";
	//echo $query;
	$results = $database->query($query);
	for ($result=0;$result< $database->num_rows($results);$result++){
		$state = $database->fetch_result($results,$result,'State');
		$rowYear = $database->fetch_result($results,$result,'Year');
		$stateName = $database->fetch_result($results,$result,'StateName');
		$typeTotal = $database->fetch_result($results,$result,'typetotal');
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
			$dd["data"][] = array($rowYear,$typeTotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
		} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
			$dd["data"][] = array($stateName,$rowYear,$typeTotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
		} else {
			$dd["data"][] = array($stateName,$typeTotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
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
function: generate_training_topics
*/
function generate_training_topics($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("tp");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["TT_topictotal"], $headings["TT_products"], $headings["TT_funding"], $headings["TT_technology"],
			 $headings["TT_combo"], $headings["TT_other"]);
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["TT_topictotal"], $headings["TT_products"], $headings["TT_funding"], $headings["TT_technology"],
			 $headings["TT_combo"], $headings["TT_other"]);

	} else {
		$dd["headings"] = array("", $headings["TT_topictotal"], $headings["TT_products"], $headings["TT_funding"], $headings["TT_technology"],
			 $headings["TT_combo"], $headings["TT_other"]);
	}
	$dd["pscript_headings"] = "Products;Funding;Technology;Combo;Other";
	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and data.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program" || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."tp`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."tp`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			FORMAT(TT_topictotal,0) as topictotal, 
			TT_topictotal as topictotal_num, 
			IF((((TT_products)/TT_topictotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((TT_products)/TT_topictotal)*100),1),'%'))  as Products, 
			IF((((TT_products)/TT_topictotal)*100) is NULL, '0' ,ROUND((((TT_products)/TT_topictotal)*100),1))  as Products_num, 
			IF((((TT_funding)/TT_topictotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((TT_funding)/TT_topictotal)*100),1),'%'))  as Funding, 
			IF((((TT_funding)/TT_topictotal)*100) is NULL, '0' , ROUND((((TT_funding)/TT_topictotal)*100),1))  as Funding_num, 
			IF((((TT_technology)/TT_topictotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((TT_technology)/TT_topictotal)*100),1),'%'))  as Technology, 
			IF((((TT_technology)/TT_topictotal)*100) is NULL, '0' ,ROUND((((TT_technology)/TT_topictotal)*100),1))  as Technology_num, 
			IF((((TT_combo)/TT_topictotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((TT_combo)/TT_topictotal)*100),1),'%'))  as Combo, 
			IF((((TT_combo)/TT_topictotal)*100) is NULL, '0' ,ROUND((((TT_combo)/TT_topictotal)*100),1))  as Combo_num, 
			IF((((TT_other)/TT_topictotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((TT_other)/TT_topictotal)*100),1),'%'))  as Other, 
			IF((((TT_other)/TT_topictotal)*100) is NULL, '0' ,ROUND((((TT_other)/TT_topictotal)*100),1))  as Other_num 
			from ". $this->database_table_prefix ."tp data $join , ". $this->database_table_prefix ."states s
			where  s.abbreviation = data.State $whereYear and data.State in ($states) order by data.Year, data.State ";
	//echo $query;
	$results = $database->query($query);
	for ($result=0;$result< $database->num_rows($results);$result++){
		$state = $database->fetch_result($results,$result,'State');
		$rowYear = $database->fetch_result($results,$result,'Year');
		$stateName = $database->fetch_result($results,$result,'StateName');
		$topictotal = $database->fetch_result($results,$result,'topictotal');
		$products = $database->fetch_result($results,$result,'Products');
		$funding = $database->fetch_result($results,$result,'Funding');
		$technology = $database->fetch_result($results,$result,'Technology');
		$combo = $database->fetch_result($results,$result,'Combo');
		$other = $database->fetch_result($results,$result,'Other');
		
		$products_num = $database->fetch_result($results,$result,'Products_num');
		$funding_num = $database->fetch_result($results,$result,'Funding_num');
		$technology_num = $database->fetch_result($results,$result,'Technology_num');
		$combo_num = $database->fetch_result($results,$result,'Combo_num');
		$other_num = $database->fetch_result($results,$result,'Other_num');
		
		if ($reporttype == "single"){
			$dd["data"][] = array($rowYear,$topictotal,$products,$funding,$technology,$combo,$other);
		} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
			$dd["data"][] = array($stateName,$rowYear,$topictotal,$products,$funding,$technology,$combo,$other);
		} else {
			$dd["data"][] = array($stateName,$topictotal,$products,$funding,$technology,$combo,$other);
		}
		if ($reporttype == "oneyear"){
			$dd["pscript_data"][] = "'$stateName';$products_num;$funding_num;$technology_num;$combo_num;$other_num";
		} else if ($reporttype == "single"){
			$dd["pscript_data"][] = "'$rowYear';$products_num;$funding_num;$technology_num;$combo_num;$other_num";
		}
	}
	$database->close();
	return($dd); 
}		
}
?>
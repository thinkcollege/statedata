<?php    
/*
class: deviceprogram
purpose: support deviceprogram
*/
class deviceprogram extends basedata{

/*
function: generate_dd_at_type
*/
function generate_dd_at_type($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	if ($reporttype == "single"){
		$dd["headings"] = array("Year","Total # of Devices<br/> Demonstrated","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("","Year","Total # of Devices<br/> Demonstrated","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );

	} else {
		$dd["headings"] = array("","Total # of Devices<br/> Demonstrated","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/>  and transportation","Computers and related","Recreation, sports, and leisure","Other" );
	}
	$dd["pscript_headings"] = "Vision;Hearing;Speech;Learning;Mobility;Daily living;Environmental;Vehicle;Computers;Recreation;Other";
	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and dd.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program" || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `x_dd`  order by Year desc Limit 0,1 ) years on (dd.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `x_dd`  order by Year desc Limit 0,3 ) years on (dd.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, dd.Year, 
			FORMAT(DD_typetotal,0) as typetotal, 
			DD_typetotal as typetotal_num, 
			IF((((DD_vision)/DD_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_vision)/DD_typetotal)*100),1),'%'))  as Vision, 
			IF((((DD_vision)/DD_typetotal)*100) is NULL, '0' ,ROUND((((DD_vision)/DD_typetotal)*100),1))  as Vision_num, 
			IF((((DD_hearing)/DD_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_hearing)/DD_typetotal)*100),1),'%'))  as Hearing, 
			IF((((DD_hearing)/DD_typetotal)*100) is NULL, '0' , ROUND((((DD_hearing)/DD_typetotal)*100),1))  as Hearing_num, 
			IF((((DD_speech)/DD_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_speech)/DD_typetotal)*100),1),'%'))  as Speech, 
			IF((((DD_speech)/DD_typetotal)*100) is NULL, '0' ,ROUND((((DD_speech)/DD_typetotal)*100),1))  as Speech_num, 
			IF((((DD_learning)/DD_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_learning)/DD_typetotal)*100),1),'%'))  as Learning, 
			IF((((DD_learning)/DD_typetotal)*100) is NULL, '0' ,ROUND((((DD_learning)/DD_typetotal)*100),1))  as Learning_num, 
			IF((((DD_mobility)/DD_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_mobility)/DD_typetotal)*100),1),'%'))  as Mobility, 
			IF((((DD_mobility)/DD_typetotal)*100) is NULL, '0' ,ROUND((((DD_mobility)/DD_typetotal)*100),1))  as Mobility_num, 
			IF((((DD_daily)/DD_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_daily)/DD_typetotal)*100),1),'%'))  as Daily, 
			IF((((DD_daily)/DD_typetotal)*100) is NULL, '0' ,ROUND((((DD_daily)/DD_typetotal)*100),1))  as Daily_num, 
			IF((((DD_environ)/DD_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_environ)/DD_typetotal)*100),1),'%'))  as Environ, 
			IF((((DD_environ)/DD_typetotal)*100) is NULL, '0' ,ROUND((((DD_environ)/DD_typetotal)*100),1))  as Environ_num, 
			IF((((DD_vehicle)/DD_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_vehicle)/DD_typetotal)*100),1),'%'))  as Vehicle, 
			IF((((DD_vehicle)/DD_typetotal)*100) is NULL, '0' ,ROUND((((DD_vehicle)/DD_typetotal)*100),1))  as Vehicle_num, 
			IF((((DD_computer)/DD_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_computer)/DD_typetotal)*100),1),'%'))  as Computer, 
			IF((((DD_computer)/DD_typetotal)*100) is NULL, '0' ,ROUND((((DD_computer)/DD_typetotal)*100),1))  as Computer_num, 
			IF((((DD_rec)/DD_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_rec)/DD_typetotal)*100),1),'%'))  as Rec, 
			IF((((DD_rec)/DD_typetotal)*100) is NULL, '0.' ,ROUND((((DD_rec)/DD_typetotal)*100),1))  as Rec_num, 
			IF((((DD_othertype)/DD_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_othertype)/DD_typetotal)*100),1),'%'))  as Othertype,
			IF((((DD_othertype)/DD_typetotal)*100) is NULL, '0' ,ROUND((((DD_othertype)/DD_typetotal)*100),1))  as Othertype_num 
			from ". $this->database_table_prefix ."dd dd $join , ". $this->database_table_prefix ."states s
			where  s.abbreviation = dd.State $whereYear and dd.State in ($states) order by dd.Year, dd.State ";
	//echo $query;
	$results = $database->query($query);
	for ($result=0;$result< $database->num_rows($results);$result++){
		$state = $database->fetch_result($results,$result,'State');
		$rowYear = $database->fetch_result($results,$result,'Year');
		$stateName = $database->fetch_result($results,$result,'StateName');
		$typeTotal = $database->fetch_result($results,$result,'typetotal');
		$vision = $database->fetch_result($results,$result,'Vision');
		$hearing = $database->fetch_result($results,$result,'Hearing');
		$speech = $database->fetch_result($results,$result,'Speech');
		$learning = $database->fetch_result($results,$result,'Learning');
		$mobility = $database->fetch_result($results,$result,'Mobility');
		$daily = $database->fetch_result($results,$result,'Daily');
		$environ = $database->fetch_result($results,$result,'Environ');
		$vehicle = $database->fetch_result($results,$result,'Vehicle');
		$computer = $database->fetch_result($results,$result,'Computer');
		$rec = $database->fetch_result($results,$result,'Rec');
		$othertype = $database->fetch_result($results,$result,'Othertype');
		
		$vision_num = $database->fetch_result($results,$result,'Vision_num');
		$hearing_num = $database->fetch_result($results,$result,'Hearing_num');
		$speech_num = $database->fetch_result($results,$result,'Speech_num');
		$learning_num = $database->fetch_result($results,$result,'Learning_num');
		$mobility_num = $database->fetch_result($results,$result,'Mobility_num');
		$daily_num = $database->fetch_result($results,$result,'Daily_num');
		$environ_num = $database->fetch_result($results,$result,'Environ_num');
		$vehicle_num = $database->fetch_result($results,$result,'Vehicle_num');
		$computer_num = $database->fetch_result($results,$result,'Computer_num');
		$rec_num = $database->fetch_result($results,$result,'Rec_num');
		$othertype_num = $database->fetch_result($results,$result,'Othertype_num');
		if ($reporttype == "single"){
			$dd["data"][] = array($rowYear,$typeTotal,$vision,$hearing,$speech,$learning,$mobility,$daily,$environ,$vehicle,$computer,$rec,$othertype);
		} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
			$dd["data"][] = array($stateName,$rowYear,$typeTotal,$vision,$hearing,$speech,$learning,$mobility,$daily,$environ,$vehicle,$computer,$rec,$othertype);
		} else {
			$dd["data"][] = array($stateName,$typeTotal,$vision,$hearing,$speech,$learning,$mobility,$daily,$environ,$vehicle,$computer,$rec,$othertype);
		}
		if ($reporttype == "oneyear"){
			$dd["pscript_data"][] = "'$stateName';$vision_num;$hearing_num;$speech_num;$learning_num;$mobility_num;$daily_num;$environ_num;$vehicle_num;$computer_num;$rec_num;$othertype_num";
		} else if ($reporttype == "single"){
			$dd["pscript_data"][] = "'$rowYear';$vision_num;$hearing_num;$speech_num;$learning_num;$mobility_num;$daily_num;$environ_num;$vehicle_num;$computer_num;$rec_num;$othertype_num";
		}
	}
	$database->close();
	return($dd); 
}


/*
function: generate_dd_participants
*/
function generate_dd_participants($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	if ($reporttype == "single"){
		$dd["headings"] = array("Year","Total Individuals attending demos","Individuals with disabilities","Family members, guardians,<br/> and authorized representatives","Reps of Education","Reps of employment","Reps of health, allied health,<br/>  and rehabilitation","Reps of community living","Reps of technology","Others" );
	} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
	
		$dd["headings"] = array("","Year","Total Individuals attending demos","Individuals with disabilities","Family members, guardians,<br/> and authorized representatives","Reps of Education","Reps of employment","Reps of health, allied health,<br/>  and rehabilitation","Reps of community living","Reps of technology","Others" );

	} else {
		$dd["headings"] = array("","Total Individuals attending demos","Individuals with disabilities","Family members, guardians,<br/> and authorized representatives","Reps of Education","Reps of employment","Reps of health, allied health,<br/>  and rehabilitation","Reps of community living","Reps of technology","Others" );
	}
	$dd["pscript_headings"] = "Individuals with disabilities;Family members;Reps of Education;Reps of employment;Reps of health;Reps of community living;Reps of technology;Others";

	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and dd.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program"  || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `x_dd`  order by Year desc Limit 0,1 ) years on (dd.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `x_dd`  order by Year desc Limit 0,3 ) years on (dd.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, dd.Year, FORMAT(DD_participanttotal,0) as participatingtotal, 
			IF(((DD_disability/DD_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_disability)/DD_participanttotal)*100),1),'%'))  as Disability, 
			IF(((DD_disability/DD_participanttotal)*100) is NULL, '0' ,ROUND((((DD_disability)/DD_participanttotal)*100),1))  as Disability_num, 
			IF((((DD_family)/DD_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_family)/DD_participanttotal)*100),1),'%'))  as Family, 
			IF((((DD_family)/DD_participanttotal)*100) is NULL, '0' ,ROUND((((DD_family)/DD_participanttotal)*100),1))  as Family_num, 
			IF((((DD_education)/DD_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_education)/DD_participanttotal)*100),1),'%'))  as Education, 
			IF((((DD_education)/DD_participanttotal)*100) is NULL, '0' ,ROUND((((DD_education)/DD_participanttotal)*100),1))  as Education_num, 
			IF((((DD_employ)/DD_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_employ)/DD_participanttotal)*100),1),'%'))  as Employ, 
			IF((((DD_employ)/DD_participanttotal)*100) is NULL, '0' ,ROUND((((DD_employ)/DD_participanttotal)*100),1))  as Employ_num, 
			IF((((DD_health)/DD_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_health)/DD_participanttotal)*100),1),'%'))  as Health, 
			IF((((DD_health)/DD_participanttotal)*100) is NULL, '0' ,ROUND((((DD_health)/DD_participanttotal)*100),1))  as Health_num, 
			IF((((DD_commliving)/DD_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_commliving)/DD_participanttotal)*100),1),'%'))  as Commliving, 
			IF((((DD_commliving)/DD_participanttotal)*100) is NULL, '0' ,ROUND((((DD_commliving)/DD_participanttotal)*100),1))  as Commliving_num, 
			IF((((DD_tech)/DD_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_tech)/DD_participanttotal)*100),1),'%'))  as Tech, 
			IF((((DD_tech)/DD_participanttotal)*100) is NULL, '0' ,ROUND((((DD_tech)/DD_participanttotal)*100),1))  as Tech_num, 
			IF((((DD_otherpaticipant)/DD_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_otherpaticipant)/DD_participanttotal)*100),1),'%'))  as Otherpaticipant,
			IF((((DD_otherpaticipant)/DD_participanttotal)*100) is NULL, '0' ,ROUND((((DD_otherpaticipant)/DD_participanttotal)*100),1))  as Otherpaticipant_num
			from ". $this->database_table_prefix ."dd dd $join , ". $this->database_table_prefix ."states s
			where  s.abbreviation = dd.State $whereYear and dd.State in ($states) order by dd.Year, dd.State ";
	//echo $query;
	$results = $database->query($query);
	for ($result=0;$result< $database->num_rows($results);$result++){
		$state = $database->fetch_result($results,$result,'State');
		$rowYear = $database->fetch_result($results,$result,'Year');
		$stateName = $database->fetch_result($results,$result,'StateName');
		$participatingtotal = $database->fetch_result($results,$result,'participatingtotal');
		$disability = $database->fetch_result($results,$result,'Disability');
		$family = $database->fetch_result($results,$result,'Family');
		$education = $database->fetch_result($results,$result,'Education');
		$employ = $database->fetch_result($results,$result,'Employ');
		$health = $database->fetch_result($results,$result,'Health');
		$commliving = $database->fetch_result($results,$result,'Commliving');
		$tech = $database->fetch_result($results,$result,'Tech');
		$otherpaticipant = $database->fetch_result($results,$result,'Otherpaticipant');
		if ($reporttype == "single"){
			$dd["data"][] = array($rowYear,$participatingtotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
		} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
			$dd["data"][] = array($stateName,$rowYear,$participatingtotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
		} else {
			$dd["data"][] = array($stateName,$participatingtotal,$disability,$family,$education,$employ,$health,$commliving,$tech,$otherpaticipant);
		}
		
		if ($reporttype == "oneyear"){
			$dd["pscript_data"][] = "'$stateName';$disability;$family;$education;$employ;$health;$commliving;$tech;$otherpaticipant";
		} else if ($reporttype == "single"){
			$dd["pscript_data"][] = "'$rowYear';$disability;$family;$education;$employ;$health;$commliving;$tech;$otherpaticipant";
		}
	}
	$database->close();
	return($dd); 
}

/*
function: generate_dd_sat
*/
function generate_dd_sat($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	if ($reporttype == "single"){
		$dd["headings"] = array("Year","Total number of responses<br/>to satisfaction question","Highly satisfied","Satisfied","Satisfied somewhat","Not at all satisfied" );
	} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
	
		$dd["headings"] = array("","Year","Total number of responses<br/>to satisfaction question","Highly satisfied","Satisfied","Satisfied somewhat","Not at all satisfied" );

	} else {
		$dd["headings"] = array("","Total number of responses<br/>to satisfaction question","Highly satisfied","Satisfied","Satisfied somewhat","Not at all satisfied" );
	}
	$dd["pscript_headings"] = "Highly satisfied;Satisfied;Satisfied somewhat;Not at all satisfied";
	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and dd.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program"  || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `x_dd`  order by Year desc Limit 0,1 ) years on (dd.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `x_dd`  order by Year desc Limit 0,3 ) years on (dd.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, dd.Year, FORMAT(DD_sattot,0) as Sattot, 
			IF(((DD_highsat/DD_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_highsat)/DD_sattot)*100),1),'%'))  as Highsat, 
			IF(((DD_highsat/DD_sattot)*100) is NULL, '0' ,ROUND((((DD_highsat)/DD_sattot)*100),1))  as Highsat_num, 
			IF((((DD_sat)/DD_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_sat)/DD_sattot)*100),1),'%'))  as Sat, 
			IF((((DD_sat)/DD_sattot)*100) is NULL, '0' ,ROUND((((DD_sat)/DD_sattot)*100),1))  as Sat_num, 
			IF((((DD_somesat)/DD_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_somesat)/DD_sattot)*100),1),'%'))  as Somesat, 
			IF((((DD_somesat)/DD_sattot)*100) is NULL, '0' ,ROUND((((DD_somesat)/DD_sattot)*100),1))  as Somesat_num, 
			IF((((DD_notsat)/DD_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_notsat)/DD_sattot)*100),1),'%'))  as Notsat,
			IF((((DD_notsat)/DD_sattot)*100) is NULL, '0' ,ROUND((((DD_notsat)/DD_sattot)*100),1))  as Notsat_num 
			from ". $this->database_table_prefix ."dd dd $join , ". $this->database_table_prefix ."states s
			where  s.abbreviation = dd.State $whereYear and dd.State in ($states) order by dd.Year, dd.State ";
	//echo $query;
	$results = $database->query($query);
	for ($result=0;$result< $database->num_rows($results);$result++){
		$state = $database->fetch_result($results,$result,'State');
		$rowYear = $database->fetch_result($results,$result,'Year');
		$stateName = $database->fetch_result($results,$result,'StateName');
		$sattot = $database->fetch_result($results,$result,'Sattot');
		$highsat = $database->fetch_result($results,$result,'Highsat');
		$sat = $database->fetch_result($results,$result,'Sat');
		$somesat = $database->fetch_result($results,$result,'Somesat');
		$notsat = $database->fetch_result($results,$result,'Notsat');
		
		if($reporttype == "single") {
			$dd["data"][] = array($rowYear,$sattot,$highsat,$sat,$somesat,$notsat);
		} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
			$dd["data"][] = array($stateName,$rowYear,$sattot,$highsat,$sat,$somesat,$notsat);
		} else {
			$dd["data"][] = array($stateName,$sattot,$highsat,$sat,$somesat,$notsat);
			
		}
		if ($reporttype == "oneyear"){
			$dd["pscript_data"][] = "'$stateName';$highsat;$sat;$somesat;$notsat";
		} else if ($reporttype == "single"){
			$dd["pscript_data"][] = "'$rowYear';$highsat;$sat;$somesat;$notsat";
		}
	}
	$database->close();
	return($dd); 
}
		
}
?>
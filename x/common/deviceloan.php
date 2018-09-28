<?php    
/*
class: deviceloan
purpose: support deviceloan
*/
class deviceloan extends basedata{

/*
function: generate_purpose
*/
function generate_purpose($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("dL");
	
	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["DL_total"], $headings["DL_decision"], $headings["DL_loaner"], $headings["DL_accom"],
			 $headings["DL_other"]);
		//$dd["headings"] = array("Year","Total number of Device<br/> loans made","Assist in decision making","Server as loaner","Provide accomodation","other purpose" );
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["DL_total"], $headings["DL_decision"], $headings["DL_loaner"], $headings["DL_accom"],
			 $headings["DL_other"]);
		//$dd["headings"] = array("","Year","Total number of Device<br/> loans made","Assist in decision making","Server as loaner","Provide accomodation","other purpose" );

	} else {
		$dd["headings"] = array("",  $headings["DL_total"], $headings["DL_decision"], $headings["DL_loaner"], $headings["DL_accom"],
			 $headings["DL_other"]);
		//$dd["headings"] = array("","Total number of Device<br/> loans made","Assist in decision making","Serve as loaner","Provide accomodation","other purpose" );
	}
	$dd["pscript_headings"] = "Assist in decision making;serve loaner;provide accomodation;other";
	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and data.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program" || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."dl`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."dl`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			FORMAT(DL_Total,0) as total, 
			DL_Total as total_num, 
			IF((((DL_Decision)/DL_Total)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_Decision)/DL_Total)*100),1),'%'))  as Decision, 
			IF((((DL_Decision)/DL_Total)*100) is NULL, '0' ,ROUND((((DL_Decision)/DL_Total)*100),1))  as Decision_num, 
			IF((((DL_Loaner)/DL_Total)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_Loaner)/DL_Total)*100),1),'%'))  as Loaner, 
			IF((((DL_Loaner)/DL_Total)*100) is NULL, '0' , ROUND((((DL_Loaner)/DL_Total)*100),1))  as Loaner_num, 
			IF((((DL_Accom)/DL_Total)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_Accom)/DL_Total)*100),1),'%'))  as Accom, 
			IF((((DL_Accom)/DL_Total)*100) is NULL, '0' ,ROUND((((DL_Accom)/DL_Total)*100),1))  as Accom_num, 
			IF((((DL_Other)/DL_Total)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_Other)/DL_Total)*100),1),'%'))  as Other, 
			IF((((DL_Other)/DL_Total)*100) is NULL, '0' ,ROUND((((DL_Other)/DL_Total)*100),1))  as Other_num 
			from ". $this->database_table_prefix ."dl data $join , ". $this->database_table_prefix ."states s
			where  s.abbreviation = data.State $whereYear and data.State in ($states) order by data.Year, data.State ";
	//echo $query;
	$results = $database->query($query);
	for ($result=0;$result< $database->num_rows($results);$result++){
		$state = $database->fetch_result($results,$result,'State');
		$rowYear = $database->fetch_result($results,$result,'Year');
		$stateName = $database->fetch_result($results,$result,'StateName');
		$total = $database->fetch_result($results,$result,'total');
		$decision = $database->fetch_result($results,$result,'Decision');
		$loaner = $database->fetch_result($results,$result,'Loaner');
		$accom = $database->fetch_result($results,$result,'Accom');
		$other = $database->fetch_result($results,$result,'Other');
		
		$decision_num = $database->fetch_result($results,$result,'Decision_num');
		$loaner_num = $database->fetch_result($results,$result,'Loaner_num');
		$accom_num = $database->fetch_result($results,$result,'Accom_num');
		$other_num = $database->fetch_result($results,$result,'Other_num');
		
		
		if ($reporttype == "single"){
			$dd["data"][] = array($rowYear,$total,$decision,$loaner,$accom,$other);
		} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
			$dd["data"][] = array($stateName,$rowYear,$total,$decision,$loaner,$accom,$other);
		} else {
			$dd["data"][] = array($stateName,$total,$decision,$loaner,$accom,$other);
		}
		if ($reporttype == "oneyear"){
			$dd["pscript_data"][] = "'$stateName';$decision_num;$loaner_num;$accom_num;$other_num";
		} else if ($reporttype == "single"){
			$dd["pscript_data"][] = "'$rowYear';$decision_num;$loaner_num;$accom_num;$other_num";
		}
	}
	$database->close();
	return($dd); 
}


/*
function: generate_at_type
*/
function generate_at_type($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("dL");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["DL_typetotal"], $headings["DL_vision"], $headings["DL_hearing"], $headings["DL_speech"],
			 $headings["DL_learning"], $headings["DL_mobility"], $headings["DL_daily"], $headings["DL_environ"], $headings["DL_vehicle"],
			 $headings["DL_computer"], $headings["DL_rec"], $headings["DL_othertype"]);
		//$dd["headings"] = array("Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["DL_typetotal"], $headings["DL_vision"], $headings["DL_hearing"], $headings["DL_speech"],
			 $headings["DL_learning"], $headings["DL_mobility"], $headings["DL_daily"], $headings["DL_environ"], $headings["DL_vehicle"],
			 $headings["DL_computer"], $headings["DL_rec"], $headings["DL_othertype"]);
		//$dd["headings"] = array("","Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );

	} else {
		$dd["headings"] = array("", $headings["DL_typetotal"], $headings["DL_vision"], $headings["DL_hearing"], $headings["DL_speech"],
			 $headings["DL_learning"], $headings["DL_mobility"], $headings["DL_daily"], $headings["DL_environ"], $headings["DL_vehicle"],
			 $headings["DL_computer"], $headings["DL_rec"], $headings["DL_othertype"]);
		//$dd["headings"] = array("","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/>  and transportation","Computers and related","Recreation, sports, and leisure","Other" );
	}
	$dd["pscript_headings"] = "Vision;Hearing;Speech;Learning;Mobility;Daily living;Environmental;Vehicle;Computers;Recreation;Other";
	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and data.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program" || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."dl`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."dl`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			FORMAT(DL_typetotal,0) as typetotal, 
			DL_typetotal as typetotal_num, 
			IF((((DL_vision)/DL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_Vision)/DL_typetotal)*100),1),'%'))  as Vision, 
			IF((((DL_vision)/DL_typetotal)*100) is NULL, '0' ,ROUND((((DL_Vision)/DL_typetotal)*100),1))  as Vision_num, 
			IF((((DL_hearing)/DL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_hearing)/DL_typetotal)*100),1),'%'))  as Hearing, 
			IF((((DL_hearing)/DL_typetotal)*100) is NULL, '0' , ROUND((((DL_hearing)/DL_typetotal)*100),1))  as Hearing_num, 
			IF((((DL_speech)/DL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_speech)/DL_typetotal)*100),1),'%'))  as Speech, 
			IF((((DL_speech)/DL_typetotal)*100) is NULL, '0' ,ROUND((((DL_speech)/DL_typetotal)*100),1))  as Speech_num, 
			IF((((DL_learning)/DL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_learning)/DL_typetotal)*100),1),'%'))  as Learning, 
			IF((((DL_learning)/DL_typetotal)*100) is NULL, '0' ,ROUND((((DL_learning)/DL_typetotal)*100),1))  as Learning_num, 
			IF((((DL_mobility)/DL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_mobility)/DL_typetotal)*100),1),'%'))  as Mobility, 
			IF((((DL_mobility)/DL_typetotal)*100) is NULL, '0' ,ROUND((((DL_mobility)/DL_typetotal)*100),1))  as Mobility_num, 
			IF((((DL_daily)/DL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_daily)/DL_typetotal)*100),1),'%'))  as Daily, 
			IF((((DL_daily)/DL_typetotal)*100) is NULL, '0' ,ROUND((((DL_daily)/DL_typetotal)*100),1))  as Daily_num, 
			IF((((DL_environ)/DL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_environ)/DL_typetotal)*100),1),'%'))  as Environ, 
			IF((((DL_environ)/DL_typetotal)*100) is NULL, '0' ,ROUND((((DL_environ)/DL_typetotal)*100),1))  as Environ_num, 
			IF((((DL_vehicle)/DL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_vehicle)/DL_typetotal)*100),1),'%'))  as Vehicle, 
			IF((((DL_vehicle)/DL_typetotal)*100) is NULL, '0' ,ROUND((((DL_vehicle)/DL_typetotal)*100),1))  as Vehicle_num, 
			IF((((DL_computer)/DL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_computer)/DL_typetotal)*100),1),'%'))  as Computer, 
			IF((((DL_computer)/DL_typetotal)*100) is NULL, '0' ,ROUND((((DL_computer)/DL_typetotal)*100),1))  as Computer_num, 
			IF((((DL_rec)/DL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_rec)/DL_typetotal)*100),1),'%'))  as Rec, 
			IF((((DL_rec)/DL_typetotal)*100) is NULL, '0.' ,ROUND((((DL_rec)/DL_typetotal)*100),1))  as Rec_num, 
			IF((((DL_othertype)/DL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_othertype)/DL_typetotal)*100),1),'%'))  as Othertype,
			IF((((DL_othertype)/DL_typetotal)*100) is NULL, '0' ,ROUND((((DL_othertype)/DL_typetotal)*100),1))  as Othertype_num 
			from ". $this->database_table_prefix ."dl data $join , ". $this->database_table_prefix ."states s
			where  s.abbreviation = data.State $whereYear and data.State in ($states) order by data.Year, data.State ";
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
function: generate_participants
*/
function generate_participants($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("dL");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["DL_participanttotal"], $headings["DL_disability"], $headings["DL_family"],
			$headings["DL_education"], $headings["DL_employ"], $headings["DL_health"], $headings["DL_commliving"], $headings["DL_tech"], $headings["DL_otherpaticipant"]);
		
		//$dd["headings"] = array("Year","Total Individuals who received device loans","Individuals with disabilities","Family members, guardians,<br/> and authorized representatives","Reps of Education","Reps of employment","Reps of health, allied health,<br/>  and rehabilitation","Reps of community living","Reps of technology","Others" );
	} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["DL_participanttotal"], $headings["DL_disability"], $headings["DL_family"],
			$headings["DL_education"], $headings["DL_employ"], $headings["DL_health"], $headings["DL_commliving"], $headings["DL_tech"], $headings["DL_otherpaticipant"]);
		
		//$dd["headings"] = array("","Year","Total Individuals attending demos","Individuals with disabilities","Family members, guardians,<br/> and authorized representatives","Reps of Education","Reps of employment","Reps of health, allied health,<br/>  and rehabilitation","Reps of community living","Reps of technology","Others" );

	} else {
		$dd["headings"] = array("", $headings["DL_participanttotal"], $headings["DL_disability"], $headings["DL_family"],
			$headings["DL_education"], $headings["DL_employ"], $headings["DL_health"], $headings["DL_commliving"], $headings["DL_tech"], $headings["DL_otherpaticipant"]);
		//$dd["headings"] = array("","Total Individuals attending demos","Individuals with disabilities","Family members, guardians,<br/> and authorized representatives","Reps of Education","Reps of employment","Reps of health, allied health,<br/>  and rehabilitation","Reps of community living","Reps of technology","Others" );
	}
	$dd["pscript_headings"] = "Individuals with disabilities;Family members;Reps of Education;Reps of employment;Reps of health;Reps of community living;Reps of technology;Others";

	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and data.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program"  || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."dl`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."dl`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, FORMAT(DL_participanttotal,0) as participatingtotal, 
			IF(((DL_disability/DL_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_disability)/DL_participanttotal)*100),1),'%'))  as Disability, 
			IF(((DL_disability/DL_participanttotal)*100) is NULL, '0' ,ROUND((((DL_disability)/DL_participanttotal)*100),1))  as Disability_num, 
			IF((((DL_family)/DL_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_family)/DL_participanttotal)*100),1),'%'))  as Family, 
			IF((((DL_family)/DL_participanttotal)*100) is NULL, '0' ,ROUND((((DL_family)/DL_participanttotal)*100),1))  as Family_num, 
			IF((((DL_education)/DL_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_education)/DL_participanttotal)*100),1),'%'))  as Education, 
			IF((((DL_education)/DL_participanttotal)*100) is NULL, '0' ,ROUND((((DL_education)/DL_participanttotal)*100),1))  as Education_num, 
			IF((((DL_employ)/DL_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_employ)/DL_participanttotal)*100),1),'%'))  as Employ, 
			IF((((DL_employ)/DL_participanttotal)*100) is NULL, '0' ,ROUND((((DL_employ)/DL_participanttotal)*100),1))  as Employ_num, 
			IF((((DL_health)/DL_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_health)/DL_participanttotal)*100),1),'%'))  as Health, 
			IF((((DL_health)/DL_participanttotal)*100) is NULL, '0' ,ROUND((((DL_health)/DL_participanttotal)*100),1))  as Health_num, 
			IF((((DL_commliving)/DL_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_commliving)/DL_participanttotal)*100),1),'%'))  as Commliving, 
			IF((((DL_commliving)/DL_participanttotal)*100) is NULL, '0' ,ROUND((((DL_commliving)/DL_participanttotal)*100),1))  as Commliving_num, 
			IF((((DL_tech)/DL_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_tech)/DL_participanttotal)*100),1),'%'))  as Tech, 
			IF((((DL_tech)/DL_participanttotal)*100) is NULL, '0' ,ROUND((((DL_tech)/DL_participanttotal)*100),1))  as Tech_num, 
			IF((((DL_otherpaticipant)/DL_participanttotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_otherpaticipant)/DL_participanttotal)*100),1),'%'))  as Otherpaticipant,
			IF((((DL_otherpaticipant)/DL_participanttotal)*100) is NULL, '0' ,ROUND((((DL_otherpaticipant)/DL_participanttotal)*100),1))  as Otherpaticipant_num
			from ". $this->database_table_prefix ."dl data $join , ". $this->database_table_prefix ."states s
			where  s.abbreviation = data.State $whereYear and data.State in ($states) order by data.Year, data.State ";
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
function: generate_sat
*/
function generate_sat($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("dL");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["DL_sattot"], $headings["DL_highsat"], $headings["DL_sat"], $headings["DL_somesat"],
			 $headings["DL_notsat"]);
		
		//$dd["headings"] = array("Year","Total Individuals<br/>who answered<br/>Satisfation Survey","Highly satisfied","Satisfied","Satisfied somewhat","Not at all satisfied" );
	} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["DL_sattot"], $headings["DL_highsat"], $headings["DL_sat"], $headings["DL_somesat"],
			 $headings["DL_notsat"]);
		
		//$dd["headings"] = array("","Year","Total Individuals<br/>who answered<br/>Satisfation Survey","Highly satisfied","Satisfied","Satisfied somewhat","Not at all satisfied" );

	} else {
		$dd["headings"] = array("", $headings["DL_sattot"], $headings["DL_highsat"], $headings["DL_sat"], $headings["DL_somesat"],
			 $headings["DL_notsat"]);
		//$dd["headings"] = array("","Total Individuals<br/>who answered<br/>Satisfation Survey","Highly satisfied","Satisfied","Satisfied somewhat","Not at all satisfied" );
	}
	$dd["pscript_headings"] = "Highly satisfied;Satisfied;Satisfied somewhat;Not at all satisfied";
	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and data.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program"  || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."dl`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."dl`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, FORMAT(DL_sattot,0) as Sattot, 
			IF(((DL_highsat/DL_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_highsat)/DL_sattot)*100),1),'%'))  as Highsat, 
			IF(((DL_highsat/DL_sattot)*100) is NULL, '0' ,ROUND((((DL_highsat)/DL_sattot)*100),1))  as Highsat_num, 
			IF((((DL_sat)/DL_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_sat)/DL_sattot)*100),1),'%'))  as Sat, 
			IF((((DL_sat)/DL_sattot)*100) is NULL, '0' ,ROUND((((DL_sat)/DL_sattot)*100),1))  as Sat_num, 
			IF((((DL_somesat)/DL_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_somesat)/DL_sattot)*100),1),'%'))  as Somesat, 
			IF((((DL_somesat)/DL_sattot)*100) is NULL, '0' ,ROUND((((DL_somesat)/DL_sattot)*100),1))  as Somesat_num, 
			IF((((DL_notsat)/DL_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_notsat)/DL_sattot)*100),1),'%'))  as Notsat,
			IF((((DL_notsat)/DL_sattot)*100) is NULL, '0' ,ROUND((((DL_notsat)/DL_sattot)*100),1))  as Notsat_num 
			from ". $this->database_table_prefix ."dl data $join , ". $this->database_table_prefix ."states s
			where  s.abbreviation = data.State $whereYear and data.State in ($states) order by data.Year, data.State ";
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
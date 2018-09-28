<?php    
/*
class: financialactivites
purpose: support financialactivites
*/
class financialactivites extends basedata{


/*
function: generate_financialactivites_at_type
*/
function generate_financialactivites_at_type($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("fl");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["FL_typetotal"], $headings["FL_vision"], $headings["FL_hearing"], $headings["FL_speech"],
			 $headings["FL_learning"], $headings["FL_mobility"], $headings["FL_daily"], $headings["FL_environ"], $headings["FL_vehicle"],
			 $headings["FL_computer"], $headings["FL_rec"], $headings["FL_othertype"]);
		//$dd["headings"] = array("Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["FL_typetotal"], $headings["FL_vision"], $headings["FL_hearing"], $headings["FL_speech"],
			 $headings["FL_learning"], $headings["FL_mobility"], $headings["FL_daily"], $headings["FL_environ"], $headings["FL_vehicle"],
			 $headings["FL_computer"], $headings["FL_rec"], $headings["FL_othertype"]);
		//$dd["headings"] = array("","Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );

	} else {
		$dd["headings"] = array("", $headings["FL_typetotal"], $headings["FL_vision"], $headings["FL_hearing"], $headings["FL_speech"],
			 $headings["FL_learning"], $headings["FL_mobility"], $headings["FL_daily"], $headings["FL_environ"], $headings["FL_vehicle"],
			 $headings["FL_computer"], $headings["FL_rec"], $headings["FL_othertype"]);
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
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."fl`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."fl`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			FORMAT(FL_typetotal,0) as typetotal, 
			FL_typetotal as typetotal_num, 
			IF((((FL_vision)/FL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FL_Vision)/FL_typetotal)*100),1),'%'))  as Vision, 
			IF((((FL_vision)/FL_typetotal)*100) is NULL, '0' ,ROUND((((FL_Vision)/FL_typetotal)*100),1))  as Vision_num, 
			IF((((FL_hearing)/FL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FL_hearing)/FL_typetotal)*100),1),'%'))  as Hearing, 
			IF((((FL_hearing)/FL_typetotal)*100) is NULL, '0' , ROUND((((FL_hearing)/FL_typetotal)*100),1))  as Hearing_num, 
			IF((((FL_speech)/FL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FL_speech)/FL_typetotal)*100),1),'%'))  as Speech, 
			IF((((FL_speech)/FL_typetotal)*100) is NULL, '0' ,ROUND((((FL_speech)/FL_typetotal)*100),1))  as Speech_num, 
			IF((((FL_learning)/FL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FL_learning)/FL_typetotal)*100),1),'%'))  as Learning, 
			IF((((FL_learning)/FL_typetotal)*100) is NULL, '0' ,ROUND((((FL_learning)/FL_typetotal)*100),1))  as Learning_num, 
			IF((((FL_mobility)/FL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FL_mobility)/FL_typetotal)*100),1),'%'))  as Mobility, 
			IF((((FL_mobility)/FL_typetotal)*100) is NULL, '0' ,ROUND((((FL_mobility)/FL_typetotal)*100),1))  as Mobility_num, 
			IF((((FL_daily)/FL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FL_daily)/FL_typetotal)*100),1),'%'))  as Daily, 
			IF((((FL_daily)/FL_typetotal)*100) is NULL, '0' ,ROUND((((FL_daily)/FL_typetotal)*100),1))  as Daily_num, 
			IF((((FL_environ)/FL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FL_environ)/FL_typetotal)*100),1),'%'))  as Environ, 
			IF((((FL_environ)/FL_typetotal)*100) is NULL, '0' ,ROUND((((FL_environ)/FL_typetotal)*100),1))  as Environ_num, 
			IF((((FL_vehicle)/FL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FL_vehicle)/FL_typetotal)*100),1),'%'))  as Vehicle, 
			IF((((FL_vehicle)/FL_typetotal)*100) is NULL, '0' ,ROUND((((FL_vehicle)/FL_typetotal)*100),1))  as Vehicle_num, 
			IF((((FL_computer)/FL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FL_computer)/FL_typetotal)*100),1),'%'))  as Computer, 
			IF((((FL_computer)/FL_typetotal)*100) is NULL, '0' ,ROUND((((FL_computer)/FL_typetotal)*100),1))  as Computer_num, 
			IF((((FL_rec)/FL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FL_rec)/FL_typetotal)*100),1),'%'))  as Rec, 
			IF((((FL_rec)/FL_typetotal)*100) is NULL, '0.' ,ROUND((((FL_rec)/FL_typetotal)*100),1))  as Rec_num, 
			IF((((FL_othertype)/FL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FL_othertype)/FL_typetotal)*100),1),'%'))  as Othertype,
			IF((((FL_othertype)/FL_typetotal)*100) is NULL, '0' ,ROUND((((FL_othertype)/FL_typetotal)*100),1))  as Othertype_num 
			from ". $this->database_table_prefix ."fl data $join , ". $this->database_table_prefix ."states s
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
function: generate_financialactivites_exchange_at_type_dol
*/
function generate_financialactivites_at_type_dol($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("fl");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["FL_typetotal_dol"], $headings["FL_vision_dol"], $headings["FL_hearing_dol"], $headings["FL_speech_dol"],
			 $headings["FL_learning_dol"], $headings["FL_mobility_dol"], $headings["FL_daily_dol"], $headings["FL_environ_dol"], $headings["FL_vehicle_dol"],
			 $headings["FL_computer_dol"], $headings["FL_rec_dol"], $headings["FL_othertype_dol"]);
		//$dd["headings"] = array("Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["FL_typetotal_dol"], $headings["FL_vision_dol"], $headings["FL_hearing_dol"], $headings["FL_speech_dol"],
			 $headings["FL_learning_dol"], $headings["FL_mobility_dol"], $headings["FL_daily_dol"], $headings["FL_environ_dol"], $headings["FL_vehicle_dol"],
			 $headings["FL_computer_dol"], $headings["FL_rec_dol"], $headings["FL_othertype_dol"]);
		//$dd["headings"] = array("","Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );

	} else {
		$dd["headings"] = array("", $headings["FL_typetotal_dol"], $headings["FL_vision_dol"], $headings["FL_hearing_dol"], $headings["FL_speech_dol"],
			 $headings["FL_learning_dol"], $headings["FL_mobility_dol"], $headings["FL_daily_dol"], $headings["FL_environ_dol"], $headings["FL_vehicle_dol"],
			 $headings["FL_computer_dol"], $headings["FL_rec_dol"], $headings["FL_othertype_dol"]);
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
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."fl`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."fl`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			CONCAT('$',FORMAT(FL_typetotal_dol,0)) as typetotal, 
			FL_typetotal_dol as typetotal_num, 
			IF((FL_vision_dol) is NULL, '$0' ,CONCAT('$',FL_Vision_dol))  as Vision, 
			IF((FL_vision_dol) is NULL, '0' ,FL_Vision_dol)  as Vision_num, 
			IF((FL_hearing_dol) is NULL, '$0' ,CONCAT('$',FL_hearing_dol))  as Hearing, 
			IF((FL_hearing_dol) is NULL, '0' ,FL_hearing_dol)  as Hearing_num, 
			IF((FL_speech_dol) is NULL, '$0' ,CONCAT('$',FL_speech_dol))  as Speech, 
			IF((FL_speech_dol) is NULL, '0' ,FL_speech_dol)  as Speech_num, 
			IF((FL_learning_dol) is NULL, '$0' ,CONCAT('$',FL_learning_dol))  as Learning, 
			IF((FL_learning_dol) is NULL, '0' ,FL_learning_dol)  as Learning_num, 
			IF((FL_mobility_dol) is NULL, '$0' ,CONCAT('$',FL_mobility_dol))  as Mobility, 
			IF((FL_mobility_dol) is NULL, '0' ,FL_mobility_dol)  as Mobility_num,
			IF((FL_daily_dol) is NULL, '$0' ,CONCAT('$',FL_daily_dol))  as Daily, 
			IF((FL_daily_dol) is NULL, '0' ,FL_daily_dol)  as Daily_num,
			IF((FL_environ_dol) is NULL, '$0' ,CONCAT('$',FL_environ_dol))  as Environ, 
			IF((FL_environ_dol) is NULL, '0' ,FL_environ_dol)  as Environ_num,
			IF((FL_vehicle_dol) is NULL, '$0' ,CONCAT('$',FL_vehicle_dol))  as Vehicle, 
			IF((FL_vehicle_dol) is NULL, '0' ,FL_vehicle_dol)  as Vehicle_num,
			IF((FL_computer_dol) is NULL, '$0' ,CONCAT('$',FL_computer_dol))  as Computer, 
			IF((FL_computer_dol) is NULL, '0' ,FL_computer_dol)  as Computer_num,
			IF((FL_rec_dol) is NULL, '$0' ,CONCAT('$',FL_rec_dol))  as Rec, 
			IF((FL_rec_dol) is NULL, '0' ,FL_rec_dol)  as Rec_num,
			IF((FL_othertype_dol) is NULL, '$0' ,CONCAT('$',FL_othertype_dol))  as Othertype, 
			IF((FL_othertype_dol) is NULL, '0' ,FL_othertype_dol)  as Othertype_num
			from ". $this->database_table_prefix ."fl data $join , ". $this->database_table_prefix ."states s
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
function: generate_aquisition_at_type
*/
function generate_aquisition_at_type($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("sf");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["SF_typetotal"], $headings["SF_vision"], $headings["SF_hearing"], $headings["SF_speech"],
			 $headings["SF_learning"], $headings["SF_mobility"], $headings["SF_daily"], $headings["SF_environ"], $headings["SF_vehicle"],
			 $headings["SF_computer"], $headings["SF_rec"], $headings["SF_othertype"]);
		//$dd["headings"] = array("Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["SF_typetotal"], $headings["SF_vision"], $headings["SF_hearing"], $headings["SF_speech"],
			 $headings["SF_learning"], $headings["SF_mobility"], $headings["SF_daily"], $headings["SF_environ"], $headings["SF_vehicle"],
			 $headings["SF_computer"], $headings["SF_rec"], $headings["SF_othertype"]);
		//$dd["headings"] = array("","Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );

	} else {
		$dd["headings"] = array("", $headings["SF_typetotal"], $headings["SF_vision"], $headings["SF_hearing"], $headings["SF_speech"],
			 $headings["SF_learning"], $headings["SF_mobility"], $headings["SF_daily"], $headings["SF_environ"], $headings["SF_vehicle"],
			 $headings["SF_computer"], $headings["SF_rec"], $headings["SF_othertype"]);
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
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."sf`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."sf`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			FORMAT(SF_typetotal,0) as typetotal, 
			SF_typetotal as typetotal_num, 
			IF((((SF_vision)/SF_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((SF_Vision)/SF_typetotal)*100),1),'%'))  as Vision, 
			IF((((SF_vision)/SF_typetotal)*100) is NULL, '0' ,ROUND((((SF_Vision)/SF_typetotal)*100),1))  as Vision_num, 
			IF((((SF_hearing)/SF_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((SF_hearing)/SF_typetotal)*100),1),'%'))  as Hearing, 
			IF((((SF_hearing)/SF_typetotal)*100) is NULL, '0' , ROUND((((SF_hearing)/SF_typetotal)*100),1))  as Hearing_num, 
			IF((((SF_speech)/SF_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((SF_speech)/SF_typetotal)*100),1),'%'))  as Speech, 
			IF((((SF_speech)/SF_typetotal)*100) is NULL, '0' ,ROUND((((SF_speech)/SF_typetotal)*100),1))  as Speech_num, 
			IF((((SF_learning)/SF_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((SF_learning)/SF_typetotal)*100),1),'%'))  as Learning, 
			IF((((SF_learning)/SF_typetotal)*100) is NULL, '0' ,ROUND((((SF_learning)/SF_typetotal)*100),1))  as Learning_num, 
			IF((((SF_mobility)/SF_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((SF_mobility)/SF_typetotal)*100),1),'%'))  as Mobility, 
			IF((((SF_mobility)/SF_typetotal)*100) is NULL, '0' ,ROUND((((SF_mobility)/SF_typetotal)*100),1))  as Mobility_num, 
			IF((((SF_daily)/SF_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((SF_daily)/SF_typetotal)*100),1),'%'))  as Daily, 
			IF((((SF_daily)/SF_typetotal)*100) is NULL, '0' ,ROUND((((SF_daily)/SF_typetotal)*100),1))  as Daily_num, 
			IF((((SF_environ)/SF_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((SF_environ)/SF_typetotal)*100),1),'%'))  as Environ, 
			IF((((SF_environ)/SF_typetotal)*100) is NULL, '0' ,ROUND((((SF_environ)/SF_typetotal)*100),1))  as Environ_num, 
			IF((((SF_vehicle)/SF_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((SF_vehicle)/SF_typetotal)*100),1),'%'))  as Vehicle, 
			IF((((SF_vehicle)/SF_typetotal)*100) is NULL, '0' ,ROUND((((SF_vehicle)/SF_typetotal)*100),1))  as Vehicle_num, 
			IF((((SF_computer)/SF_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((SF_computer)/SF_typetotal)*100),1),'%'))  as Computer, 
			IF((((SF_computer)/SF_typetotal)*100) is NULL, '0' ,ROUND((((SF_computer)/SF_typetotal)*100),1))  as Computer_num, 
			IF((((SF_rec)/SF_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((SF_rec)/SF_typetotal)*100),1),'%'))  as Rec, 
			IF((((SF_rec)/SF_typetotal)*100) is NULL, '0.' ,ROUND((((SF_rec)/SF_typetotal)*100),1))  as Rec_num, 
			IF((((SF_othertype)/SF_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((SF_othertype)/SF_typetotal)*100),1),'%'))  as Othertype,
			IF((((SF_othertype)/SF_typetotal)*100) is NULL, '0' ,ROUND((((SF_othertype)/SF_typetotal)*100),1))  as Othertype_num 
			from ". $this->database_table_prefix ."sf data $join , ". $this->database_table_prefix ."states s
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
function: generate_aquisition_at_type_dol
*/
function generate_aquisition_at_type_dol($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("sf");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["SF_typetotal_dol"], $headings["SF_vision_dol"], $headings["SF_hearing_dol"], $headings["SF_speech_dol"],
			 $headings["SF_learning_dol"], $headings["SF_mobility_dol"], $headings["SF_daily_dol"], $headings["SF_environ_dol"], $headings["SF_vehicle_dol"],
			 $headings["SF_computer_dol"], $headings["SF_rec_dol"], $headings["SF_othertype_dol"]);
		
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["SF_typetotal_dol"], $headings["SF_vision_dol"], $headings["SF_hearing_dol"], $headings["SF_speech_dol"],
			 $headings["SF_learning_dol"], $headings["SF_mobility_dol"], $headings["SF_daily_dol"], $headings["SF_environ_dol"], $headings["SF_vehicle_dol"],
			 $headings["SF_computer_dol"], $headings["SF_rec_dol"], $headings["SF_othertype_dol"]);
		

	} else {
		$dd["headings"] = array("", $headings["SF_typetotal_dol"], $headings["SF_vision_dol"], $headings["SF_hearing_dol"], $headings["SF_speech_dol"],
			 $headings["SF_learning_dol"], $headings["SF_mobility_dol"], $headings["SF_daily_dol"], $headings["SF_environ_dol"], $headings["SF_vehicle_dol"],
			 $headings["SF_computer_dol"], $headings["SF_rec_dol"], $headings["SF_othertype_dol"]);
		
	}
	$dd["pscript_headings"] = "Vision;Hearing;Speech;Learning;Mobility;Daily living;Environmental;Vehicle;Computers;Recreation;Other";
	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and data.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program" || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."sf`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."sf`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			CONCAT('$',FORMAT(SF_typetotal_dol,0)) as typetotal, 
			SF_typetotal_dol as typetotal_num, 
			IF((SF_vision_dol) is NULL, '$0' ,CONCAT('$',SF_Vision_dol))  as Vision, 
			IF((SF_vision_dol) is NULL, '0' ,SF_Vision_dol)  as Vision_num, 
			IF((SF_hearing_dol) is NULL, '$0' ,CONCAT('$',SF_hearing_dol))  as Hearing, 
			IF((SF_hearing_dol) is NULL, '0' ,SF_hearing_dol)  as Hearing_num, 
			IF((SF_speech_dol) is NULL, '$0' ,CONCAT('$',SF_speech_dol))  as Speech, 
			IF((SF_speech_dol) is NULL, '0' ,SF_speech_dol)  as Speech_num, 
			IF((SF_learning_dol) is NULL, '$0' ,CONCAT('$',SF_learning_dol))  as Learning, 
			IF((SF_learning_dol) is NULL, '0' ,SF_learning_dol)  as Learning_num, 
			IF((SF_mobility_dol) is NULL, '$0' ,CONCAT('$',SF_mobility_dol))  as Mobility, 
			IF((SF_mobility_dol) is NULL, '0' ,SF_mobility_dol)  as Mobility_num,
			IF((SF_daily_dol) is NULL, '$0' ,CONCAT('$',SF_daily_dol))  as Daily, 
			IF((SF_daily_dol) is NULL, '0' ,SF_daily_dol)  as Daily_num,
			IF((SF_environ_dol) is NULL, '$0' ,CONCAT('$',SF_environ_dol))  as Environ, 
			IF((SF_environ_dol) is NULL, '0' ,SF_environ_dol)  as Environ_num,
			IF((SF_vehicle_dol) is NULL, '$0' ,CONCAT('$',SF_vehicle_dol))  as Vehicle, 
			IF((SF_vehicle_dol) is NULL, '0' ,SF_vehicle_dol)  as Vehicle_num,
			IF((SF_computer_dol) is NULL, '$0' ,CONCAT('$',SF_computer_dol))  as Computer, 
			IF((SF_computer_dol) is NULL, '0' ,SF_computer_dol)  as Computer_num,
			IF((SF_rec_dol) is NULL, '$0' ,CONCAT('$',SF_rec_dol))  as Rec, 
			IF((SF_rec_dol) is NULL, '0' ,SF_rec_dol)  as Rec_num,
			IF((SF_othertype_dol) is NULL, '$0' ,CONCAT('$',SF_othertype_dol))  as Othertype, 
			IF((SF_othertype_dol) is NULL, '0' ,SF_othertype_dol)  as Othertype_num
			from ". $this->database_table_prefix ."sf data $join , ". $this->database_table_prefix ."states s
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
function: generate_deviceopenended_at_type
*/
function generate_allowconsumers_at_type($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("rc");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["RC_typetotal"], $headings["RC_vision"], $headings["RC_hearing"], $headings["RC_speech"],
			 $headings["RC_learning"], $headings["RC_mobility"], $headings["RC_daily"], $headings["RC_environ"], $headings["RC_vehicle"],
			 $headings["RC_computer"], $headings["RC_rec"], $headings["RC_othertype"]);
		//$dd["headings"] = array("Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["RC_typetotal"], $headings["RC_vision"], $headings["RC_hearing"], $headings["RC_speech"],
			 $headings["RC_learning"], $headings["RC_mobility"], $headings["RC_daily"], $headings["RC_environ"], $headings["RC_vehicle"],
			 $headings["RC_computer"], $headings["RC_rec"], $headings["RC_othertype"]);
		//$dd["headings"] = array("","Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );

	} else {
		$dd["headings"] = array("", $headings["RC_typetotal"], $headings["RC_vision"], $headings["RC_hearing"], $headings["RC_speech"],
			 $headings["RC_learning"], $headings["RC_mobility"], $headings["RC_daily"], $headings["RC_environ"], $headings["RC_vehicle"],
			 $headings["RC_computer"], $headings["RC_rec"], $headings["RC_othertype"]);
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
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."rc`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."rc`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			FORMAT(RC_typetotal,0) as typetotal, 
			RC_typetotal as typetotal_num, 
			IF((((RC_vision)/RC_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RC_Vision)/RC_typetotal)*100),1),'%'))  as Vision, 
			IF((((RC_vision)/RC_typetotal)*100) is NULL, '0' ,ROUND((((RC_Vision)/RC_typetotal)*100),1))  as Vision_num, 
			IF((((RC_hearing)/RC_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RC_hearing)/RC_typetotal)*100),1),'%'))  as Hearing, 
			IF((((RC_hearing)/RC_typetotal)*100) is NULL, '0' , ROUND((((RC_hearing)/RC_typetotal)*100),1))  as Hearing_num, 
			IF((((RC_speech)/RC_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RC_speech)/RC_typetotal)*100),1),'%'))  as Speech, 
			IF((((RC_speech)/RC_typetotal)*100) is NULL, '0' ,ROUND((((RC_speech)/RC_typetotal)*100),1))  as Speech_num, 
			IF((((RC_learning)/RC_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RC_learning)/RC_typetotal)*100),1),'%'))  as Learning, 
			IF((((RC_learning)/RC_typetotal)*100) is NULL, '0' ,ROUND((((RC_learning)/RC_typetotal)*100),1))  as Learning_num, 
			IF((((RC_mobility)/RC_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RC_mobility)/RC_typetotal)*100),1),'%'))  as Mobility, 
			IF((((RC_mobility)/RC_typetotal)*100) is NULL, '0' ,ROUND((((RC_mobility)/RC_typetotal)*100),1))  as Mobility_num, 
			IF((((RC_daily)/RC_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RC_daily)/RC_typetotal)*100),1),'%'))  as Daily, 
			IF((((RC_daily)/RC_typetotal)*100) is NULL, '0' ,ROUND((((RC_daily)/RC_typetotal)*100),1))  as Daily_num, 
			IF((((RC_environ)/RC_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RC_environ)/RC_typetotal)*100),1),'%'))  as Environ, 
			IF((((RC_environ)/RC_typetotal)*100) is NULL, '0' ,ROUND((((RC_environ)/RC_typetotal)*100),1))  as Environ_num, 
			IF((((RC_vehicle)/RC_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RC_vehicle)/RC_typetotal)*100),1),'%'))  as Vehicle, 
			IF((((RC_vehicle)/RC_typetotal)*100) is NULL, '0' ,ROUND((((RC_vehicle)/RC_typetotal)*100),1))  as Vehicle_num, 
			IF((((RC_computer)/RC_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RC_computer)/RC_typetotal)*100),1),'%'))  as Computer, 
			IF((((RC_computer)/RC_typetotal)*100) is NULL, '0' ,ROUND((((RC_computer)/RC_typetotal)*100),1))  as Computer_num, 
			IF((((RC_rec)/RC_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RC_rec)/RC_typetotal)*100),1),'%'))  as Rec, 
			IF((((RC_rec)/RC_typetotal)*100) is NULL, '0.' ,ROUND((((RC_rec)/RC_typetotal)*100),1))  as Rec_num, 
			IF((((RC_othertype)/RC_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RC_othertype)/RC_typetotal)*100),1),'%'))  as Othertype,
			IF((((RC_othertype)/RC_typetotal)*100) is NULL, '0' ,ROUND((((RC_othertype)/RC_typetotal)*100),1))  as Othertype_num 
			from ". $this->database_table_prefix ."rc data $join , ". $this->database_table_prefix ."states s
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
function: generate_deviceopenended_at_type_dol
*/
function generate_allowconsumers_at_type_dol($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("rc");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["RC_typetotal_dol"], $headings["RC_vision_dol"], $headings["RC_hearing_dol"], $headings["RC_speech_dol"],
			 $headings["RC_learning_dol"], $headings["RC_mobility_dol"], $headings["RC_daily_dol"], $headings["RC_environ_dol"], $headings["RC_vehicle_dol"],
			 $headings["RC_computer_dol"], $headings["RC_rec_dol"], $headings["RC_othertype_dol"]);
		
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["RC_typetotal_dol"], $headings["RC_vision_dol"], $headings["RC_hearing_dol"], $headings["RC_speech_dol"],
			 $headings["RC_learning_dol"], $headings["RC_mobility_dol"], $headings["RC_daily_dol"], $headings["RC_environ_dol"], $headings["RC_vehicle_dol"],
			 $headings["RC_computer_dol"], $headings["RC_rec_dol"], $headings["RC_othertype_dol"]);
		

	} else {
		$dd["headings"] = array("", $headings["RC_typetotal_dol"], $headings["RC_vision_dol"], $headings["RC_hearing_dol"], $headings["RC_speech_dol"],
			 $headings["RC_learning_dol"], $headings["RC_mobility_dol"], $headings["RC_daily_dol"], $headings["RC_environ_dol"], $headings["RC_vehicle_dol"],
			 $headings["RC_computer_dol"], $headings["RC_rec_dol"], $headings["RC_othertype_dol"]);
		
	}
	$dd["pscript_headings"] = "Vision;Hearing;Speech;Learning;Mobility;Daily living;Environmental;Vehicle;Computers;Recreation;Other";
	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and data.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program" || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."rc`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."rc`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			CONCAT('$',FORMAT(RC_typetotal_dol,0)) as typetotal, 
			RC_typetotal_dol as typetotal_num, 
			IF((RC_vision_dol) is NULL, '$0' ,CONCAT('$',RC_Vision_dol))  as Vision, 
			IF((RC_vision_dol) is NULL, '0' ,RC_Vision_dol)  as Vision_num, 
			IF((RC_hearing_dol) is NULL, '$0' ,CONCAT('$',RC_hearing_dol))  as Hearing, 
			IF((RC_hearing_dol) is NULL, '0' ,RC_hearing_dol)  as Hearing_num, 
			IF((RC_speech_dol) is NULL, '$0' ,CONCAT('$',RC_speech_dol))  as Speech, 
			IF((RC_speech_dol) is NULL, '0' ,RC_speech_dol)  as Speech_num, 
			IF((RC_learning_dol) is NULL, '$0' ,CONCAT('$',RC_learning_dol))  as Learning, 
			IF((RC_learning_dol) is NULL, '0' ,RC_learning_dol)  as Learning_num, 
			IF((RC_mobility_dol) is NULL, '$0' ,CONCAT('$',RC_mobility_dol))  as Mobility, 
			IF((RC_mobility_dol) is NULL, '0' ,RC_mobility_dol)  as Mobility_num,
			IF((RC_daily_dol) is NULL, '$0' ,CONCAT('$',RC_daily_dol))  as Daily, 
			IF((RC_daily_dol) is NULL, '0' ,RC_daily_dol)  as Daily_num,
			IF((RC_environ_dol) is NULL, '$0' ,CONCAT('$',RC_environ_dol))  as Environ, 
			IF((RC_environ_dol) is NULL, '0' ,RC_environ_dol)  as Environ_num,
			IF((RC_vehicle_dol) is NULL, '$0' ,CONCAT('$',RC_vehicle_dol))  as Vehicle, 
			IF((RC_vehicle_dol) is NULL, '0' ,RC_vehicle_dol)  as Vehicle_num,
			IF((RC_computer_dol) is NULL, '$0' ,CONCAT('$',RC_computer_dol))  as Computer, 
			IF((RC_computer_dol) is NULL, '0' ,RC_computer_dol)  as Computer_num,
			IF((RC_rec_dol) is NULL, '$0' ,CONCAT('$',RC_rec_dol))  as Rec, 
			IF((RC_rec_dol) is NULL, '0' ,RC_rec_dol)  as Rec_num,
			IF((RC_othertype_dol) is NULL, '$0' ,CONCAT('$',RC_othertype_dol))  as Othertype, 
			IF((RC_othertype_dol) is NULL, '0' ,RC_othertype_dol)  as Othertype_num
			from ". $this->database_table_prefix ."rc data $join , ". $this->database_table_prefix ."states s
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
function: generate_sat
*/
function generate_sat($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("fa_sat");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["FA_sattot"], $headings["FA_highsat"], $headings["FA_sat"], $headings["FA_somesat"],
			 $headings["FA_notsat"]);
		
		//$dd["headings"] = array("Year","Total Individuals<br/>who answered<br/>Satisfation Survey","Highly satisfied","Satisfied","Satisfied somewhat","Not at all satisfied" );
	} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["FA_sattot"], $headings["FA_highsat"], $headings["FA_sat"], $headings["FA_somesat"],
			 $headings["FA_notsat"]);
		
		//$dd["headings"] = array("","Year","Total Individuals<br/>who answered<br/>Satisfation Survey","Highly satisfied","Satisfied","Satisfied somewhat","Not at all satisfied" );

	} else {
		$dd["headings"] = array("", $headings["FA_sattot"], $headings["FA_highsat"], $headings["FA_sat"], $headings["FA_somesat"],
			 $headings["FA_notsat"]);
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
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."fa_sat`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."fa_sat`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, FORMAT(FA_sattot,0) as Sattot, 
			IF(((FA_highsat/FA_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FA_highsat)/FA_sattot)*100),1),'%'))  as Highsat, 
			IF(((FA_highsat/FA_sattot)*100) is NULL, '0' ,ROUND((((FA_highsat)/FA_sattot)*100),1))  as Highsat_num, 
			IF((((FA_sat)/FA_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FA_sat)/FA_sattot)*100),1),'%'))  as Sat, 
			IF((((FA_sat)/FA_sattot)*100) is NULL, '0' ,ROUND((((FA_sat)/FA_sattot)*100),1))  as Sat_num, 
			IF((((FA_somesat)/FA_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FA_somesat)/FA_sattot)*100),1),'%'))  as Somesat, 
			IF((((FA_somesat)/FA_sattot)*100) is NULL, '0' ,ROUND((((FA_somesat)/FA_sattot)*100),1))  as Somesat_num, 
			IF((((FA_notsat)/FA_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FA_notsat)/FA_sattot)*100),1),'%'))  as Notsat,
			IF((((FA_notsat)/FA_sattot)*100) is NULL, '0' ,ROUND((((FA_notsat)/FA_sattot)*100),1))  as Notsat_num 
			from ". $this->database_table_prefix ."fa_sat data $join , ". $this->database_table_prefix ."states s
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
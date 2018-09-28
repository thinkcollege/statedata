<?php    
/*
class: devicereutilizationprogram
purpose: support devicereutilizationprogram
*/
class devicereutilizationprogram extends basedata{


/*
function: generate_deviceexchange_exchange_at_type
*/
function generate_deviceexchange_exchange_at_type($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("de");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["DE_typetotal"], $headings["DE_vision"], $headings["DE_hearing"], $headings["DE_speech"],
			 $headings["DE_learning"], $headings["DE_mobility"], $headings["DE_daily"], $headings["DE_environ"], $headings["DE_vehicle"],
			 $headings["DE_computer"], $headings["DE_rec"], $headings["DE_othertype"]);
		//$dd["headings"] = array("Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["DE_typetotal"], $headings["DE_vision"], $headings["DE_hearing"], $headings["DE_speech"],
			 $headings["DE_learning"], $headings["DE_mobility"], $headings["DE_daily"], $headings["DE_environ"], $headings["DE_vehicle"],
			 $headings["DE_computer"], $headings["DE_rec"], $headings["DE_othertype"]);
		//$dd["headings"] = array("","Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );

	} else {
		$dd["headings"] = array("", $headings["DE_typetotal"], $headings["DE_vision"], $headings["DE_hearing"], $headings["DE_speech"],
			 $headings["DE_learning"], $headings["DE_mobility"], $headings["DE_daily"], $headings["DE_environ"], $headings["DE_vehicle"],
			 $headings["DE_computer"], $headings["DE_rec"], $headings["DE_othertype"]);
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
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."de`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."de`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			FORMAT(DE_typetotal,0) as typetotal, 
			DE_typetotal as typetotal_num, 
			IF((((DE_vision)/DE_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DE_Vision)/DE_typetotal)*100),1),'%'))  as Vision, 
			IF((((DE_vision)/DE_typetotal)*100) is NULL, '0' ,ROUND((((DE_Vision)/DE_typetotal)*100),1))  as Vision_num, 
			IF((((DE_hearing)/DE_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DE_hearing)/DE_typetotal)*100),1),'%'))  as Hearing, 
			IF((((DE_hearing)/DE_typetotal)*100) is NULL, '0' , ROUND((((DE_hearing)/DE_typetotal)*100),1))  as Hearing_num, 
			IF((((DE_speech)/DE_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DE_speech)/DE_typetotal)*100),1),'%'))  as Speech, 
			IF((((DE_speech)/DE_typetotal)*100) is NULL, '0' ,ROUND((((DE_speech)/DE_typetotal)*100),1))  as Speech_num, 
			IF((((DE_learning)/DE_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DE_learning)/DE_typetotal)*100),1),'%'))  as Learning, 
			IF((((DE_learning)/DE_typetotal)*100) is NULL, '0' ,ROUND((((DE_learning)/DE_typetotal)*100),1))  as Learning_num, 
			IF((((DE_mobility)/DE_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DE_mobility)/DE_typetotal)*100),1),'%'))  as Mobility, 
			IF((((DE_mobility)/DE_typetotal)*100) is NULL, '0' ,ROUND((((DE_mobility)/DE_typetotal)*100),1))  as Mobility_num, 
			IF((((DE_daily)/DE_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DE_daily)/DE_typetotal)*100),1),'%'))  as Daily, 
			IF((((DE_daily)/DE_typetotal)*100) is NULL, '0' ,ROUND((((DE_daily)/DE_typetotal)*100),1))  as Daily_num, 
			IF((((DE_environ)/DE_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DE_environ)/DE_typetotal)*100),1),'%'))  as Environ, 
			IF((((DE_environ)/DE_typetotal)*100) is NULL, '0' ,ROUND((((DE_environ)/DE_typetotal)*100),1))  as Environ_num, 
			IF((((DE_vehicle)/DE_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DE_vehicle)/DE_typetotal)*100),1),'%'))  as Vehicle, 
			IF((((DE_vehicle)/DE_typetotal)*100) is NULL, '0' ,ROUND((((DE_vehicle)/DE_typetotal)*100),1))  as Vehicle_num, 
			IF((((DE_computer)/DE_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DE_computer)/DE_typetotal)*100),1),'%'))  as Computer, 
			IF((((DE_computer)/DE_typetotal)*100) is NULL, '0' ,ROUND((((DE_computer)/DE_typetotal)*100),1))  as Computer_num, 
			IF((((DE_rec)/DE_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DE_rec)/DE_typetotal)*100),1),'%'))  as Rec, 
			IF((((DE_rec)/DE_typetotal)*100) is NULL, '0.' ,ROUND((((DE_rec)/DE_typetotal)*100),1))  as Rec_num, 
			IF((((DE_othertype)/DE_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DE_othertype)/DE_typetotal)*100),1),'%'))  as Othertype,
			IF((((DE_othertype)/DE_typetotal)*100) is NULL, '0' ,ROUND((((DE_othertype)/DE_typetotal)*100),1))  as Othertype_num 
			from ". $this->database_table_prefix ."de data $join , ". $this->database_table_prefix ."states s
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
function: generate_deviceexchange_exchange_at_type_dol
*/
function generate_deviceexchange_exchange_at_type_dol($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("de");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["DE_typetotal_dol"], $headings["DE_vision_dol"], $headings["DE_hearing_dol"], $headings["DE_speech_dol"],
			 $headings["DE_learning_dol"], $headings["DE_mobility_dol"], $headings["DE_daily_dol"], $headings["DE_environ_dol"], $headings["DE_vehicle_dol"],
			 $headings["DE_computer_dol"], $headings["DE_rec_dol"], $headings["DE_othertype_dol"]);
		//$dd["headings"] = array("Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["DE_typetotal_dol"], $headings["DE_vision_dol"], $headings["DE_hearing_dol"], $headings["DE_speech_dol"],
			 $headings["DE_learning_dol"], $headings["DE_mobility_dol"], $headings["DE_daily_dol"], $headings["DE_environ_dol"], $headings["DE_vehicle_dol"],
			 $headings["DE_computer_dol"], $headings["DE_rec_dol"], $headings["DE_othertype_dol"]);
		//$dd["headings"] = array("","Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );

	} else {
		$dd["headings"] = array("", $headings["DE_typetotal_dol"], $headings["DE_vision_dol"], $headings["DE_hearing_dol"], $headings["DE_speech_dol"],
			 $headings["DE_learning_dol"], $headings["DE_mobility_dol"], $headings["DE_daily_dol"], $headings["DE_environ_dol"], $headings["DE_vehicle_dol"],
			 $headings["DE_computer_dol"], $headings["DE_rec_dol"], $headings["DE_othertype_dol"]);
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
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."de`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."de`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			CONCAT('$',FORMAT(DE_typetotal_dol,0)) as typetotal, 
			DE_typetotal_dol as typetotal_num, 
			IF((DE_vision_dol) is NULL, '$0' ,CONCAT('$',DE_Vision_dol))  as Vision, 
			IF((DE_vision_dol) is NULL, '0' ,DE_Vision_dol)  as Vision_num, 
			IF((DE_hearing_dol) is NULL, '$0' ,CONCAT('$',DE_hearing_dol))  as Hearing, 
			IF((DE_hearing_dol) is NULL, '0' ,DE_hearing_dol)  as Hearing_num, 
			IF((DE_speech_dol) is NULL, '$0' ,CONCAT('$',DE_speech_dol))  as Speech, 
			IF((DE_speech_dol) is NULL, '0' ,DE_speech_dol)  as Speech_num, 
			IF((DE_learning_dol) is NULL, '$0' ,CONCAT('$',DE_learning_dol))  as Learning, 
			IF((DE_learning_dol) is NULL, '0' ,DE_learning_dol)  as Learning_num, 
			IF((DE_mobility_dol) is NULL, '$0' ,CONCAT('$',DE_mobility_dol))  as Mobility, 
			IF((DE_mobility_dol) is NULL, '0' ,DE_mobility_dol)  as Mobility_num,
			IF((DE_daily_dol) is NULL, '$0' ,CONCAT('$',DE_daily_dol))  as Daily, 
			IF((DE_daily_dol) is NULL, '0' ,DE_daily_dol)  as Daily_num,
			IF((DE_environ_dol) is NULL, '$0' ,CONCAT('$',DE_environ_dol))  as Environ, 
			IF((DE_environ_dol) is NULL, '0' ,DE_environ_dol)  as Environ_num,
			IF((DE_vehicle_dol) is NULL, '$0' ,CONCAT('$',DE_vehicle_dol))  as Vehicle, 
			IF((DE_vehicle_dol) is NULL, '0' ,DE_vehicle_dol)  as Vehicle_num,
			IF((DE_computer_dol) is NULL, '$0' ,CONCAT('$',DE_computer_dol))  as Computer, 
			IF((DE_computer_dol) is NULL, '0' ,DE_computer_dol)  as Computer_num,
			IF((DE_rec_dol) is NULL, '$0' ,CONCAT('$',DE_rec_dol))  as Rec, 
			IF((DE_rec_dol) is NULL, '0' ,DE_rec_dol)  as Rec_num,
			IF((DE_othertype_dol) is NULL, '$0' ,CONCAT('$',DE_othertype_dol))  as Othertype, 
			IF((DE_othertype_dol) is NULL, '0' ,DE_othertype_dol)  as Othertype_num
			from ". $this->database_table_prefix ."de data $join , ". $this->database_table_prefix ."states s
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
function: generate_deviceexchange_exchange_at_type
*/
function generate_devicerrr_rrr_at_type($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("rrr");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["RRR_typetotal"], $headings["RRR_vision"], $headings["RRR_hearing"], $headings["RRR_speech"],
			 $headings["RRR_learning"], $headings["RRR_mobility"], $headings["RRR_daily"], $headings["RRR_environ"], $headings["RRR_vehicle"],
			 $headings["RRR_computer"], $headings["RRR_rec"], $headings["RRR_othertype"]);
		//$dd["headings"] = array("Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["RRR_typetotal"], $headings["RRR_vision"], $headings["RRR_hearing"], $headings["RRR_speech"],
			 $headings["RRR_learning"], $headings["RRR_mobility"], $headings["RRR_daily"], $headings["RRR_environ"], $headings["RRR_vehicle"],
			 $headings["RRR_computer"], $headings["RRR_rec"], $headings["RRR_othertype"]);
		//$dd["headings"] = array("","Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );

	} else {
		$dd["headings"] = array("", $headings["RRR_typetotal"], $headings["RRR_vision"], $headings["RRR_hearing"], $headings["RRR_speech"],
			 $headings["RRR_learning"], $headings["RRR_mobility"], $headings["RRR_daily"], $headings["RRR_environ"], $headings["RRR_vehicle"],
			 $headings["RRR_computer"], $headings["RRR_rec"], $headings["RRR_othertype"]);
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
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."rrr`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."rrr`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			FORMAT(RRR_typetotal,0) as typetotal, 
			RRR_typetotal as typetotal_num, 
			IF((((RRR_vision)/RRR_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RRR_Vision)/RRR_typetotal)*100),1),'%'))  as Vision, 
			IF((((RRR_vision)/RRR_typetotal)*100) is NULL, '0' ,ROUND((((RRR_Vision)/RRR_typetotal)*100),1))  as Vision_num, 
			IF((((RRR_hearing)/RRR_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RRR_hearing)/RRR_typetotal)*100),1),'%'))  as Hearing, 
			IF((((RRR_hearing)/RRR_typetotal)*100) is NULL, '0' , ROUND((((RRR_hearing)/RRR_typetotal)*100),1))  as Hearing_num, 
			IF((((RRR_speech)/RRR_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RRR_speech)/RRR_typetotal)*100),1),'%'))  as Speech, 
			IF((((RRR_speech)/RRR_typetotal)*100) is NULL, '0' ,ROUND((((RRR_speech)/RRR_typetotal)*100),1))  as Speech_num, 
			IF((((RRR_learning)/RRR_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RRR_learning)/RRR_typetotal)*100),1),'%'))  as Learning, 
			IF((((RRR_learning)/RRR_typetotal)*100) is NULL, '0' ,ROUND((((RRR_learning)/RRR_typetotal)*100),1))  as Learning_num, 
			IF((((RRR_mobility)/RRR_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RRR_mobility)/RRR_typetotal)*100),1),'%'))  as Mobility, 
			IF((((RRR_mobility)/RRR_typetotal)*100) is NULL, '0' ,ROUND((((RRR_mobility)/RRR_typetotal)*100),1))  as Mobility_num, 
			IF((((RRR_daily)/RRR_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RRR_daily)/RRR_typetotal)*100),1),'%'))  as Daily, 
			IF((((RRR_daily)/RRR_typetotal)*100) is NULL, '0' ,ROUND((((RRR_daily)/RRR_typetotal)*100),1))  as Daily_num, 
			IF((((RRR_environ)/RRR_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RRR_environ)/RRR_typetotal)*100),1),'%'))  as Environ, 
			IF((((RRR_environ)/RRR_typetotal)*100) is NULL, '0' ,ROUND((((RRR_environ)/RRR_typetotal)*100),1))  as Environ_num, 
			IF((((RRR_vehicle)/RRR_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RRR_vehicle)/RRR_typetotal)*100),1),'%'))  as Vehicle, 
			IF((((RRR_vehicle)/RRR_typetotal)*100) is NULL, '0' ,ROUND((((RRR_vehicle)/RRR_typetotal)*100),1))  as Vehicle_num, 
			IF((((RRR_computer)/RRR_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RRR_computer)/RRR_typetotal)*100),1),'%'))  as Computer, 
			IF((((RRR_computer)/RRR_typetotal)*100) is NULL, '0' ,ROUND((((RRR_computer)/RRR_typetotal)*100),1))  as Computer_num, 
			IF((((RRR_rec)/RRR_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RRR_rec)/RRR_typetotal)*100),1),'%'))  as Rec, 
			IF((((RRR_rec)/RRR_typetotal)*100) is NULL, '0.' ,ROUND((((RRR_rec)/RRR_typetotal)*100),1))  as Rec_num, 
			IF((((RRR_othertype)/RRR_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((RRR_othertype)/RRR_typetotal)*100),1),'%'))  as Othertype,
			IF((((RRR_othertype)/RRR_typetotal)*100) is NULL, '0' ,ROUND((((RRR_othertype)/RRR_typetotal)*100),1))  as Othertype_num 
			from ". $this->database_table_prefix ."rrr data $join , ". $this->database_table_prefix ."states s
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
function: generate_deviceexchange_exchange_at_type_dol
*/
function generate_devicerrr_rrr_at_type_dol($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("rrr");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["RRR_typetotal_dol"], $headings["RRR_vision_dol"], $headings["RRR_hearing_dol"], $headings["RRR_speech_dol"],
			 $headings["RRR_learning_dol"], $headings["RRR_mobility_dol"], $headings["RRR_daily_dol"], $headings["RRR_environ_dol"], $headings["RRR_vehicle_dol"],
			 $headings["RRR_computer_dol"], $headings["RRR_rec_dol"], $headings["RRR_othertype_dol"]);
		
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["RRR_typetotal_dol"], $headings["RRR_vision_dol"], $headings["RRR_hearing_dol"], $headings["RRR_speech_dol"],
			 $headings["RRR_learning_dol"], $headings["RRR_mobility_dol"], $headings["RRR_daily_dol"], $headings["RRR_environ_dol"], $headings["RRR_vehicle_dol"],
			 $headings["RRR_computer_dol"], $headings["RRR_rec_dol"], $headings["RRR_othertype_dol"]);
		

	} else {
		$dd["headings"] = array("", $headings["RRR_typetotal_dol"], $headings["RRR_vision_dol"], $headings["RRR_hearing_dol"], $headings["RRR_speech_dol"],
			 $headings["RRR_learning_dol"], $headings["RRR_mobility_dol"], $headings["RRR_daily_dol"], $headings["RRR_environ_dol"], $headings["RRR_vehicle_dol"],
			 $headings["RRR_computer_dol"], $headings["RRR_rec_dol"], $headings["RRR_othertype_dol"]);
		
	}
	$dd["pscript_headings"] = "Vision;Hearing;Speech;Learning;Mobility;Daily living;Environmental;Vehicle;Computers;Recreation;Other";
	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and data.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program" || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."rrr`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."rrr`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			CONCAT('$',FORMAT(RRR_typetotal_dol,0)) as typetotal, 
			RRR_typetotal_dol as typetotal_num, 
			IF((RRR_vision_dol) is NULL, '$0' ,CONCAT('$',RRR_Vision_dol))  as Vision, 
			IF((RRR_vision_dol) is NULL, '0' ,RRR_Vision_dol)  as Vision_num, 
			IF((RRR_hearing_dol) is NULL, '$0' ,CONCAT('$',RRR_hearing_dol))  as Hearing, 
			IF((RRR_hearing_dol) is NULL, '0' ,RRR_hearing_dol)  as Hearing_num, 
			IF((RRR_speech_dol) is NULL, '$0' ,CONCAT('$',RRR_speech_dol))  as Speech, 
			IF((RRR_speech_dol) is NULL, '0' ,RRR_speech_dol)  as Speech_num, 
			IF((RRR_learning_dol) is NULL, '$0' ,CONCAT('$',RRR_learning_dol))  as Learning, 
			IF((RRR_learning_dol) is NULL, '0' ,RRR_learning_dol)  as Learning_num, 
			IF((RRR_mobility_dol) is NULL, '$0' ,CONCAT('$',RRR_mobility_dol))  as Mobility, 
			IF((RRR_mobility_dol) is NULL, '0' ,RRR_mobility_dol)  as Mobility_num,
			IF((RRR_daily_dol) is NULL, '$0' ,CONCAT('$',RRR_daily_dol))  as Daily, 
			IF((RRR_daily_dol) is NULL, '0' ,RRR_daily_dol)  as Daily_num,
			IF((RRR_environ_dol) is NULL, '$0' ,CONCAT('$',RRR_environ_dol))  as Environ, 
			IF((RRR_environ_dol) is NULL, '0' ,RRR_environ_dol)  as Environ_num,
			IF((RRR_vehicle_dol) is NULL, '$0' ,CONCAT('$',RRR_vehicle_dol))  as Vehicle, 
			IF((RRR_vehicle_dol) is NULL, '0' ,RRR_vehicle_dol)  as Vehicle_num,
			IF((RRR_computer_dol) is NULL, '$0' ,CONCAT('$',RRR_computer_dol))  as Computer, 
			IF((RRR_computer_dol) is NULL, '0' ,RRR_computer_dol)  as Computer_num,
			IF((RRR_rec_dol) is NULL, '$0' ,CONCAT('$',RRR_rec_dol))  as Rec, 
			IF((RRR_rec_dol) is NULL, '0' ,RRR_rec_dol)  as Rec_num,
			IF((RRR_othertype_dol) is NULL, '$0' ,CONCAT('$',RRR_othertype_dol))  as Othertype, 
			IF((RRR_othertype_dol) is NULL, '0' ,RRR_othertype_dol)  as Othertype_num
			from ". $this->database_table_prefix ."rrr data $join , ". $this->database_table_prefix ."states s
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
function generate_deviceopenended_at_type($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("ol");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["OL_typetotal"], $headings["OL_vision"], $headings["OL_hearing"], $headings["OL_speech"],
			 $headings["OL_learning"], $headings["OL_mobility"], $headings["OL_daily"], $headings["OL_environ"], $headings["OL_vehicle"],
			 $headings["OL_computer"], $headings["OL_rec"], $headings["OL_othertype"]);
		//$dd["headings"] = array("Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["OL_typetotal"], $headings["OL_vision"], $headings["OL_hearing"], $headings["OL_speech"],
			 $headings["OL_learning"], $headings["OL_mobility"], $headings["OL_daily"], $headings["OL_environ"], $headings["OL_vehicle"],
			 $headings["OL_computer"], $headings["OL_rec"], $headings["OL_othertype"]);
		//$dd["headings"] = array("","Year","Total # of Devices<br/> Loaned","Vision","Hearing","Speech communication","Learning, cognition,<br/> and developmental","Mobility, seating,<br/> and positioning","Daily living", "Environmental adaptations","Vehicle modification<br/> and transportation", "Computers and related","Recreation, sports, and leisure","Other" );

	} else {
		$dd["headings"] = array("", $headings["OL_typetotal"], $headings["OL_vision"], $headings["OL_hearing"], $headings["OL_speech"],
			 $headings["OL_learning"], $headings["OL_mobility"], $headings["OL_daily"], $headings["OL_environ"], $headings["OL_vehicle"],
			 $headings["OL_computer"], $headings["OL_rec"], $headings["OL_othertype"]);
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
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."ol`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."ol`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			FORMAT(OL_typetotal,0) as typetotal, 
			OL_typetotal as typetotal_num, 
			IF((((OL_vision)/OL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((OL_Vision)/OL_typetotal)*100),1),'%'))  as Vision, 
			IF((((OL_vision)/OL_typetotal)*100) is NULL, '0' ,ROUND((((OL_Vision)/OL_typetotal)*100),1))  as Vision_num, 
			IF((((OL_hearing)/OL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((OL_hearing)/OL_typetotal)*100),1),'%'))  as Hearing, 
			IF((((OL_hearing)/OL_typetotal)*100) is NULL, '0' , ROUND((((OL_hearing)/OL_typetotal)*100),1))  as Hearing_num, 
			IF((((OL_speech)/OL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((OL_speech)/OL_typetotal)*100),1),'%'))  as Speech, 
			IF((((OL_speech)/OL_typetotal)*100) is NULL, '0' ,ROUND((((OL_speech)/OL_typetotal)*100),1))  as Speech_num, 
			IF((((OL_learning)/OL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((OL_learning)/OL_typetotal)*100),1),'%'))  as Learning, 
			IF((((OL_learning)/OL_typetotal)*100) is NULL, '0' ,ROUND((((OL_learning)/OL_typetotal)*100),1))  as Learning_num, 
			IF((((OL_mobility)/OL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((OL_mobility)/OL_typetotal)*100),1),'%'))  as Mobility, 
			IF((((OL_mobility)/OL_typetotal)*100) is NULL, '0' ,ROUND((((OL_mobility)/OL_typetotal)*100),1))  as Mobility_num, 
			IF((((OL_daily)/OL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((OL_daily)/OL_typetotal)*100),1),'%'))  as Daily, 
			IF((((OL_daily)/OL_typetotal)*100) is NULL, '0' ,ROUND((((OL_daily)/OL_typetotal)*100),1))  as Daily_num, 
			IF((((OL_environ)/OL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((OL_environ)/OL_typetotal)*100),1),'%'))  as Environ, 
			IF((((OL_environ)/OL_typetotal)*100) is NULL, '0' ,ROUND((((OL_environ)/OL_typetotal)*100),1))  as Environ_num, 
			IF((((OL_vehicle)/OL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((OL_vehicle)/OL_typetotal)*100),1),'%'))  as Vehicle, 
			IF((((OL_vehicle)/OL_typetotal)*100) is NULL, '0' ,ROUND((((OL_vehicle)/OL_typetotal)*100),1))  as Vehicle_num, 
			IF((((OL_computer)/OL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((OL_computer)/OL_typetotal)*100),1),'%'))  as Computer, 
			IF((((OL_computer)/OL_typetotal)*100) is NULL, '0' ,ROUND((((OL_computer)/OL_typetotal)*100),1))  as Computer_num, 
			IF((((OL_rec)/OL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((OL_rec)/OL_typetotal)*100),1),'%'))  as Rec, 
			IF((((OL_rec)/OL_typetotal)*100) is NULL, '0.' ,ROUND((((OL_rec)/OL_typetotal)*100),1))  as Rec_num, 
			IF((((OL_othertype)/OL_typetotal)*100) is NULL, '0.00%' ,CONCAT(ROUND((((OL_othertype)/OL_typetotal)*100),1),'%'))  as Othertype,
			IF((((OL_othertype)/OL_typetotal)*100) is NULL, '0' ,ROUND((((OL_othertype)/OL_typetotal)*100),1))  as Othertype_num 
			from ". $this->database_table_prefix ."ol data $join , ". $this->database_table_prefix ."states s
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
function generate_deviceopenended_at_type_dol($states , $year = "", $reporttype = "program") { 
	$database = Database::getDatabase();
	$dd = array();
	$functions	= new functions;
	$headings = $functions->get_column_comments("ol");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["OL_typetotal_dol"], $headings["OL_vision_dol"], $headings["OL_hearing_dol"], $headings["OL_speech_dol"],
			 $headings["OL_learning_dol"], $headings["OL_mobility_dol"], $headings["OL_daily_dol"], $headings["OL_environ_dol"], $headings["OL_vehicle_dol"],
			 $headings["OL_computer_dol"], $headings["OL_rec_dol"], $headings["OL_othertype_dol"]);
		
	}else	if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["OL_typetotal_dol"], $headings["OL_vision_dol"], $headings["OL_hearing_dol"], $headings["OL_speech_dol"],
			 $headings["OL_learning_dol"], $headings["OL_mobility_dol"], $headings["OL_daily_dol"], $headings["OL_environ_dol"], $headings["OL_vehicle_dol"],
			 $headings["OL_computer_dol"], $headings["OL_rec_dol"], $headings["OL_othertype_dol"]);
		

	} else {
		$dd["headings"] = array("", $headings["OL_typetotal_dol"], $headings["OL_vision_dol"], $headings["OL_hearing_dol"], $headings["OL_speech_dol"],
			 $headings["OL_learning_dol"], $headings["OL_mobility_dol"], $headings["OL_daily_dol"], $headings["OL_environ_dol"], $headings["OL_vehicle_dol"],
			 $headings["OL_computer_dol"], $headings["OL_rec_dol"], $headings["OL_othertype_dol"]);
		
	}
	$dd["pscript_headings"] = "Vision;Hearing;Speech;Learning;Mobility;Daily living;Environmental;Vehicle;Computers;Recreation;Other";
	$dd["data"] = array();
	$whereYear = "";
	if($year != "") {
		$whereYear = " and data.Year in ( $year )";
	}
	$join = "";
    if ($reporttype == "program" || $reporttype == "oneyear") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."ol`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."ol`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, 
			CONCAT('$',FORMAT(OL_typetotal_dol,0)) as typetotal, 
			OL_typetotal_dol as typetotal_num, 
			IF((OL_vision_dol) is NULL, '$0' ,CONCAT('$',OL_Vision_dol))  as Vision, 
			IF((OL_vision_dol) is NULL, '0' ,OL_Vision_dol)  as Vision_num, 
			IF((OL_hearing_dol) is NULL, '$0' ,CONCAT('$',OL_hearing_dol))  as Hearing, 
			IF((OL_hearing_dol) is NULL, '0' ,OL_hearing_dol)  as Hearing_num, 
			IF((OL_speech_dol) is NULL, '$0' ,CONCAT('$',OL_speech_dol))  as Speech, 
			IF((OL_speech_dol) is NULL, '0' ,OL_speech_dol)  as Speech_num, 
			IF((OL_learning_dol) is NULL, '$0' ,CONCAT('$',OL_learning_dol))  as Learning, 
			IF((OL_learning_dol) is NULL, '0' ,OL_learning_dol)  as Learning_num, 
			IF((OL_mobility_dol) is NULL, '$0' ,CONCAT('$',OL_mobility_dol))  as Mobility, 
			IF((OL_mobility_dol) is NULL, '0' ,OL_mobility_dol)  as Mobility_num,
			IF((OL_daily_dol) is NULL, '$0' ,CONCAT('$',OL_daily_dol))  as Daily, 
			IF((OL_daily_dol) is NULL, '0' ,OL_daily_dol)  as Daily_num,
			IF((OL_environ_dol) is NULL, '$0' ,CONCAT('$',OL_environ_dol))  as Environ, 
			IF((OL_environ_dol) is NULL, '0' ,OL_environ_dol)  as Environ_num,
			IF((OL_vehicle_dol) is NULL, '$0' ,CONCAT('$',OL_vehicle_dol))  as Vehicle, 
			IF((OL_vehicle_dol) is NULL, '0' ,OL_vehicle_dol)  as Vehicle_num,
			IF((OL_computer_dol) is NULL, '$0' ,CONCAT('$',OL_computer_dol))  as Computer, 
			IF((OL_computer_dol) is NULL, '0' ,OL_computer_dol)  as Computer_num,
			IF((OL_rec_dol) is NULL, '$0' ,CONCAT('$',OL_rec_dol))  as Rec, 
			IF((OL_rec_dol) is NULL, '0' ,OL_rec_dol)  as Rec_num,
			IF((OL_othertype_dol) is NULL, '$0' ,CONCAT('$',OL_othertype_dol))  as Othertype, 
			IF((OL_othertype_dol) is NULL, '0' ,OL_othertype_dol)  as Othertype_num
			from ". $this->database_table_prefix ."ol data $join , ". $this->database_table_prefix ."states s
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
	$headings = $functions->get_column_comments("dr_sat");

	if ($reporttype == "single"){
		$dd["headings"] = array($headings["Year"], $headings["DR_sattot"], $headings["DR_highsat"], $headings["DR_sat"], $headings["DR_somesat"],
			 $headings["DR_notsat"]);
		
		//$dd["headings"] = array("Year","Total Individuals<br/>who answered<br/>Satisfation Survey","Highly satisfied","Satisfied","Satisfied somewhat","Not at all satisfied" );
	} else if (($year != "" && $reporttype != "oneyear") || $reporttype == "trend"){
		$dd["headings"] = array("", $headings["Year"], $headings["DR_sattot"], $headings["DR_highsat"], $headings["DR_sat"], $headings["DR_somesat"],
			 $headings["DR_notsat"]);
		
		//$dd["headings"] = array("","Year","Total Individuals<br/>who answered<br/>Satisfation Survey","Highly satisfied","Satisfied","Satisfied somewhat","Not at all satisfied" );

	} else {
		$dd["headings"] = array("", $headings["DR_sattot"], $headings["DR_highsat"], $headings["DR_sat"], $headings["DR_somesat"],
			 $headings["DR_notsat"]);
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
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."dr_sat`  order by Year desc Limit 0,1 ) years on (data.Year = years.Year)";
	} else if ($reporttype == "trend") {
		$join = "JOIN (select distinct Year from `". $this->database_table_prefix ."dr_sat`  order by Year desc Limit 0,3 ) years on (data.Year = years.Year)";
	}  
	//JOIN (select distinct Year from `x_dd` order by Year desc Limit 0,2 )
	$query = "select State, s.name as StateName, data.Year, FORMAT(DR_sattot,0) as Sattot, 
			IF(((DR_highsat/DR_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DR_highsat)/DR_sattot)*100),1),'%'))  as Highsat, 
			IF(((DR_highsat/DR_sattot)*100) is NULL, '0' ,ROUND((((DR_highsat)/DR_sattot)*100),1))  as Highsat_num, 
			IF((((DR_sat)/DR_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DR_sat)/DR_sattot)*100),1),'%'))  as Sat, 
			IF((((DR_sat)/DR_sattot)*100) is NULL, '0' ,ROUND((((DR_sat)/DR_sattot)*100),1))  as Sat_num, 
			IF((((DR_somesat)/DR_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DR_somesat)/DR_sattot)*100),1),'%'))  as Somesat, 
			IF((((DR_somesat)/DR_sattot)*100) is NULL, '0' ,ROUND((((DR_somesat)/DR_sattot)*100),1))  as Somesat_num, 
			IF((((DR_notsat)/DR_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DR_notsat)/DR_sattot)*100),1),'%'))  as Notsat,
			IF((((DR_notsat)/DR_sattot)*100) is NULL, '0' ,ROUND((((DR_notsat)/DR_sattot)*100),1))  as Notsat_num 
			from ". $this->database_table_prefix ."dr_sat data $join , ". $this->database_table_prefix ."states s
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
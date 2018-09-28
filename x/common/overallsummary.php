<?php    
/*
class: overallsummary
purpose: support overallsummary
*/
class overallsummary extends basedata{

/*
function: generate_dd
*/
function generate_dd($year) { 
	$database = Database::getDatabase();
	
	$functions	= new functions;
	$headings = $functions->get_column_comments("dd");
	
	$dd = array();
	$dd["headings"] = array("",$headings["DD_typetotal"], $headings["DD_participanttotal"], $headings["DD_sattot"]);
	
	//$dd["headings"] = array("","Number of Devices<br/> demonstrations", "Number of Individuals by type<br/> who participated in device demonstrations","Percent Satisfied or<br/> Highly Satisfied with<br/> device demonstrations");
	$dd["data"] = array();
	$results = $database->query("select State, FORMAT(DD_typetotal,0) as typetotal, FORMAT(DD_participanttotal,0) as participanttotal, s.name,
			IF((((DD_highsat + DD_sat)/DD_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DD_highsat + DD_sat)/DD_sattot)*100),1),'%'))  as Satisfied 
			from ". $this->database_table_prefix ."dd data, ". $this->database_table_prefix ."states s
			where  Year='$year' and s.abbreviation = data.State");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$state = $database->fetch_result($results,$result,'State');
		$stateName = $database->fetch_result($results,$result,'name');
		$typeTotal = $database->fetch_result($results,$result,'typetotal');
		$participantTotal = $database->fetch_result($results,$result,'participanttotal');
		$satisified = $database->fetch_result($results,$result,'Satisfied');
		$dd["data"][] = array($stateName,$typeTotal,$participantTotal,$satisified);
	}
	$database->close();
	return($dd); 
}

/*
function: generate_dd
*/
function generate_dl($year) { 
	$database = Database::getDatabase();
	
	$functions	= new functions;
	$headings = $functions->get_column_comments("dl");
	
	$dd = array();
	$dd["headings"] = array("",$headings["DL_total"], $headings["DL_typetotal"],  $headings["DL_sattot"]);
			 
	$dd["data"] = array();
	$results = $database->query("select State, FORMAT(DL_total,0) as total, 
					FORMAT(DL_typetotal,0) as typetotal, 
			s.name,
			IF((((DL_highsat + DL_sat)/DL_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DL_highsat + DL_sat)/DL_sattot)*100),1),'%'))  as Satisfied 
			from ". $this->database_table_prefix ."dl data, ". $this->database_table_prefix ."states s
			where  Year='$year' and s.abbreviation = data.State");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$state = $database->fetch_result($results,$result,'State');
		$stateName = $database->fetch_result($results,$result,'name');
		$total = $database->fetch_result($results,$result,'total');
		$typetotal = $database->fetch_result($results,$result,'typetotal');
		$satisified = $database->fetch_result($results,$result,'Satisfied');
		$dd["data"][] = array($stateName,$total,$typetotal,$satisified);
	}
	$database->close();
	return($dd); 
}

/*
function: generate_rrr
*/
function generate_rrr($year) { 
	$database = Database::getDatabase();
	
	$functions	= new functions;
	$headings = $functions->get_column_comments("de");
	$headings2 = $functions->get_column_comments("rrr");
	$headings3 = $functions->get_column_comments("ol");
	$headings4 = $functions->get_column_comments("dr_sat");
	
	$dd = array();
	$dd["headings"] = array("",$headings["DE_typetotal"], $headings["DE_typetotal_dol"], $headings2["RRR_typetotal"], 
			$headings2["RRR_typetotal_dol"],$headings3["OL_typetotal"], $headings3["OL_typetotal_dol"], $headings4["DR_sattot"]);
			 
	$dd["data"] = array();
	
	$stateQuery = "Select name as StateName, abbreviation from ". $this->database_table_prefix ."states ";
	$stateResults = $database->query($stateQuery);
	$stateArray = $database->mysql_fetch_rowsassoc($stateResults);
	
	$results = $database->query("select  FORMAT(DE_typetotal,0) as typetotal, 
					FORMAT(DE_typetotal_dol,0) as typetotal_dol,
			data.State as abbreviation
			from ". $this->database_table_prefix ."de data
			where  Year='$year' ");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$abbreviation = $database->fetch_result($results,$result,'abbreviation');
		$de_typetotal = $database->fetch_result($results,$result,'typetotal');
		$de_typetotal_dol = $database->fetch_result($results,$result,'typetotal_dol');
		
		for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
			if ($stateArray[$j]["abbreviation"] == $abbreviation){
				$stateArray[$j]["de_typetotal"] = $de_typetotal;
				$stateArray[$j]["de_typetotal_dol"] = $de_typetotal_dol;
				break;
			}
		}
	}
	
	$results = $database->query("select  FORMAT(RRR_typetotal,0) as typetotal, 
					FORMAT(RRR_typetotal_dol,0) as typetotal_dol,
			data.State as abbreviation
			from ". $this->database_table_prefix ."rrr data
			where  Year='$year' ");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$abbreviation = $database->fetch_result($results,$result,'abbreviation');
		$rrr_typetotal = $database->fetch_result($results,$result,'typetotal');
		$rrr_typetotal_dol = $database->fetch_result($results,$result,'typetotal_dol');
		
		for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
			if ($stateArray[$j]["abbreviation"] == $abbreviation){
				$stateArray[$j]["rrr_typetotal"] = $rrr_typetotal;
				$stateArray[$j]["rrr_typetotal_dol"] = $rrr_typetotal_dol;
				break;
			}
		}
	}
	
	$results = $database->query("select  FORMAT(OL_typetotal,0) as typetotal, 
					FORMAT(OL_typetotal_dol,0) as typetotal_dol,
			data.State as abbreviation
			from ". $this->database_table_prefix ."ol data
			where  Year='$year' ");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$abbreviation = $database->fetch_result($results,$result,'abbreviation');
		$ol_typetotal = $database->fetch_result($results,$result,'typetotal');
		$ol_typetotal_dol = $database->fetch_result($results,$result,'typetotal_dol');
		
		for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
			if ($stateArray[$j]["abbreviation"] == $abbreviation){
				$stateArray[$j]["ol_typetotal"] = $ol_typetotal;
				$stateArray[$j]["ol_typetotal_dol"] = $ol_typetotal_dol;
				break;
			}
		}
	}
	
	$results = $database->query("select  
			IF((((DR_highsat + DR_sat)/DR_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((DR_highsat + DR_sat)/DR_sattot)*100),1),'%'))  as satisfied,
			data.State as abbreviation
			from ". $this->database_table_prefix ."dr_sat data
			where  Year='$year' ");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$abbreviation = $database->fetch_result($results,$result,'abbreviation');
		$satisfied = $database->fetch_result($results,$result,'satisfied');
		
		for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
			if ($stateArray[$j]["abbreviation"] == $abbreviation){
				$stateArray[$j]["satisfied"] = $satisfied;
				break;
			}
		}
	}
	
	for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
		if (count($stateArray[$j]) > 2 ){
			$stateArray[$j]["de_typetotal"] = (empty($stateArray[$j]["de_typetotal"])) ? 0 : $stateArray[$j]["de_typetotal"];
			$stateArray[$j]["de_typetotal_dol"] = (empty($stateArray[$j]["de_typetotal_dol"])) ? "$0" : $stateArray[$j]["de_typetotal_dol"];
			$stateArray[$j]["rrr_typetotal"] = (empty($stateArray[$j]["rrr_typetotal"])) ? 0 : $stateArray[$j]["rrr_typetotal"];
			$stateArray[$j]["rrr_typetotal_dol"] = (empty($stateArray[$j]["rrr_typetotal_dol"])) ? "$0" : $stateArray[$j]["rrr_typetotal_dol"];
			$stateArray[$j]["ol_typetotal"] = (empty($stateArray[$j]["ol_typetotal"])) ? 0 : $stateArray[$j]["ol_typetotal"];
			$stateArray[$j]["ol_typetotal_dol"] = (empty($stateArray[$j]["ol_typetotal_dol"])) ? "$0" : $stateArray[$j]["ol_typetotal_dol"];
			$stateArray[$j]["satisified"] = (empty($stateArray[$j]["satisified"])) ? "0%" : $stateArray[$j]["satisified"];
			
			$dd["data"][] = array($stateArray[$j]["StateName"],$stateArray[$j]["de_typetotal"],$stateArray[$j]["de_typetotal_dol"],
			$stateArray[$j]["rrr_typetotal"],$stateArray[$j]["rrr_typetotal_dol"],
			$stateArray[$j]["ol_typetotal"],$stateArray[$j]["ol_typetotal_dol"],
			$stateArray[$j]["satisified"]);
		}
	}
	
	$database->close();
	return($dd); 
}



/*
function: generate_fl
*/
function generate_fl($year) { 
	$database = Database::getDatabase();
	
	$functions	= new functions;
	$headings = $functions->get_column_comments("fl");
	$headings2 = $functions->get_column_comments("sf");
	$headings3 = $functions->get_column_comments("rc");
	$headings4 = $functions->get_column_comments("fa_sat");
	
	$dd = array();
	$dd["headings"] = array("",$headings["FL_typetotal"], $headings["FL_typetotal_dol"], $headings2["SF_typetotal"], 
			$headings2["SF_typetotal_dol"],$headings3["RC_typetotal"], $headings3["RC_typetotal_dol"], $headings4["FA_sattot"]);
			 
	$dd["data"] = array();
	
	$stateQuery = "Select name as StateName, abbreviation from ". $this->database_table_prefix ."states ";
	$stateResults = $database->query($stateQuery);
	$stateArray = $database->mysql_fetch_rowsassoc($stateResults);
	
	$results = $database->query("select  FORMAT(FL_typetotal,0) as typetotal, 
					FORMAT(FL_typetotal_dol,0) as typetotal_dol,
			data.State as abbreviation
			from ". $this->database_table_prefix ."fl data
			where  Year='$year' ");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$abbreviation = $database->fetch_result($results,$result,'abbreviation');
		$fl_typetotal = $database->fetch_result($results,$result,'typetotal');
		$fl_typetotal_dol = $database->fetch_result($results,$result,'typetotal_dol');
		
		for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
			if ($stateArray[$j]["abbreviation"] == $abbreviation){
				$stateArray[$j]["fl_typetotal"] = $fl_typetotal;
				$stateArray[$j]["fl_typetotal_dol"] = $fl_typetotal_dol;
				break;
			}
		}
	}
	
	$results = $database->query("select  FORMAT(SF_typetotal,0) as typetotal, 
					FORMAT(SF_typetotal_dol,0) as typetotal_dol,
			data.State as abbreviation
			from ". $this->database_table_prefix ."sf data
			where  Year='$year' ");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$abbreviation = $database->fetch_result($results,$result,'abbreviation');
		$sf_typetotal = $database->fetch_result($results,$result,'typetotal');
		$sf_typetotal_dol = $database->fetch_result($results,$result,'typetotal_dol');
		
		for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
			if ($stateArray[$j]["abbreviation"] == $abbreviation){
				$stateArray[$j]["sf_typetotal"] = $sf_typetotal;
				$stateArray[$j]["sf_typetotal_dol"] = $sf_typetotal_dol;
				break;
			}
		}
	}
	
	$results = $database->query("select  FORMAT(RC_typetotal,0) as typetotal, 
					FORMAT(RC_typetotal_dol,0) as typetotal_dol,
			data.State as abbreviation
			from ". $this->database_table_prefix ."rc data
			where  Year='$year' ");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$abbreviation = $database->fetch_result($results,$result,'abbreviation');
		$rc_typetotal = $database->fetch_result($results,$result,'typetotal');
		$rc_typetotal_dol = $database->fetch_result($results,$result,'typetotal_dol');
		
		for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
			if ($stateArray[$j]["abbreviation"] == $abbreviation){
				$stateArray[$j]["rc_typetotal"] = $rc_typetotal;
				$stateArray[$j]["rc_typetotal_dol"] = $rc_typetotal_dol;
				break;
			}
		}
	}
	
	$results = $database->query("select  
			IF((((FA_highsat + FA_sat)/fA_sattot)*100) is NULL, '0.00%' ,CONCAT(ROUND((((FA_highsat + FA_sat)/FA_sattot)*100),1),'%'))  as satisfied,
			data.State as abbreviation
			from ". $this->database_table_prefix ."fa_sat data
			where  Year='$year' ");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$abbreviation = $database->fetch_result($results,$result,'abbreviation');
		$satisfied = $database->fetch_result($results,$result,'satisfied');
		
		for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
			if ($stateArray[$j]["abbreviation"] == $abbreviation){
				$stateArray[$j]["satisfied"] = $satisfied;
				break;
			}
		}
	}
	
	for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
		if (count($stateArray[$j]) > 2 ){
			$stateArray[$j]["fl_typetotal"] = (empty($stateArray[$j]["fl_typetotal"])) ? 0 : $stateArray[$j]["fl_typetotal"];
			$stateArray[$j]["fl_typetotal_dol"] = (empty($stateArray[$j]["fl_typetotal_dol"])) ? "$0" : $stateArray[$j]["fl_typetotal_dol"];
			$stateArray[$j]["sf_typetotal"] = (empty($stateArray[$j]["sf_typetotal"])) ? 0 : $stateArray[$j]["sf_typetotal"];
			$stateArray[$j]["sf_typetotal_dol"] = (empty($stateArray[$j]["sf_typetotal_dol"])) ? "$0" : $stateArray[$j]["sf_typetotal_dol"];
			$stateArray[$j]["rc_typetotal"] = (empty($stateArray[$j]["rc_typetotal"])) ? 0 : $stateArray[$j]["rc_typetotal"];
			$stateArray[$j]["rc_typetotal_dol"] = (empty($stateArray[$j]["rc_typetotal"])) ? "$0" : $stateArray[$j]["rc_typetotal"];
			$stateArray[$j]["satisified"] = (empty($stateArray[$j]["satisified"])) ? "0%" : $stateArray[$j]["satisified"];
			
			$dd["data"][] = array($stateArray[$j]["StateName"],$stateArray[$j]["fl_typetotal"],$stateArray[$j]["fl_typetotal_dol"],
			$stateArray[$j]["sf_typetotal"],$stateArray[$j]["sf_typetotal_dol"],
			$stateArray[$j]["rc_typetotal"],$stateArray[$j]["rc_typetotal_dol"],
			$stateArray[$j]["satisified"]);
		}
	}
	
	$database->close();
	return($dd); 
}


/*
function: generate_tp
*/
function generate_tp($year) { 
	$database = Database::getDatabase();
	
	$functions	= new functions;
	$headings = $functions->get_column_comments("tp");
	$headings2 = $functions->get_column_comments("ia");
	
	$dd = array();
	$dd["headings"] = array("",$headings["TT_topictotal"], $headings2["IS_participanttotal"]);
			 
	$dd["data"] = array();
	
	$stateQuery = "Select name as StateName, abbreviation from ". $this->database_table_prefix ."states ";
	$stateResults = $database->query($stateQuery);
	$stateArray = $database->mysql_fetch_rowsassoc($stateResults);
	
	$results = $database->query("select  FORMAT(TT_topictotal,0) as topictotal,
			data.State as abbreviation
			from ". $this->database_table_prefix ."tp data
			where  Year='$year' ");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$abbreviation = $database->fetch_result($results,$result,'abbreviation');
		$tt_topictotal = $database->fetch_result($results,$result,'topictotal');
		
		
		for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
			if ($stateArray[$j]["abbreviation"] == $abbreviation){
				$stateArray[$j]["tt_topictotal"] = $tt_topictotal;
				break;
			}
		}
	}
	
	$results = $database->query("select  FORMAT(IS_participanttotal,0) as participanttotal, 
			data.State as abbreviation
			from ". $this->database_table_prefix ."ia data
			where  Year='$year' ");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$abbreviation = $database->fetch_result($results,$result,'abbreviation');
		$is_participanttotal = $database->fetch_result($results,$result,'participanttotal');
		
		
		for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
			if ($stateArray[$j]["abbreviation"] == $abbreviation){
				$stateArray[$j]["is_participanttotal"] = $is_participanttotal;
				break;
			}
		}
	}
	
	
	for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
		if (count($stateArray[$j]) > 2 ){
			$stateArray[$j]["tt_topictotal"] = (empty($stateArray[$j]["tt_topictotal"])) ? 0 : $stateArray[$j]["tt_topictotal"];
			$stateArray[$j]["is_participanttotal"] = (empty($stateArray[$j]["is_participanttotal"])) ? 0 : $stateArray[$j]["is_participanttotal"];
			
			$dd["data"][] = array($stateArray[$j]["StateName"],$stateArray[$j]["tt_topictotal"],$stateArray[$j]["is_participanttotal"]);
		}
	}
	
	$database->close();
	return($dd); 
}


/*
function: generate_lf
*/
function generate_lf($year) { 
	$database = Database::getDatabase();
	
	$functions	= new functions;
	$headings = $functions->get_column_comments("ga");
	$headings2 = $functions->get_column_comments("lf");
	
	$dd = array();
	$dd["headings"] = array("",$headings["GA_total"], $headings2["LF_total"]);
			 
	$dd["data"] = array();
	
	$stateQuery = "Select name as StateName, abbreviation from ". $this->database_table_prefix ."states ";
	$stateResults = $database->query($stateQuery);
	$stateArray = $database->mysql_fetch_rowsassoc($stateResults);
	
	$results = $database->query("select  FORMAT(GA_total,0) as total,
			data.State as abbreviation
			from ". $this->database_table_prefix ."ga data
			where  Year='$year' ");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$abbreviation = $database->fetch_result($results,$result,'abbreviation');
		$ga_total = $database->fetch_result($results,$result,'total');
		
		
		for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
			if ($stateArray[$j]["abbreviation"] == $abbreviation){
				$stateArray[$j]["ga_total"] = $ga_total;
				break;
			}
		}
	}
	
	$results = $database->query("select  FORMAT(LF_total,0) as total, 
			data.State as abbreviation
			from ". $this->database_table_prefix ."lf data
			where  Year='$year' ");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$abbreviation = $database->fetch_result($results,$result,'abbreviation');
		$lf_total = $database->fetch_result($results,$result,'total');
		
		
		for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
			if ($stateArray[$j]["abbreviation"] == $abbreviation){
				$stateArray[$j]["lf_total"] = $lf_total;
				break;
			}
		}
	}
	
	
	for ($j =0 ; $j < $database->num_rows($stateResults);$j++){
		if (count($stateArray[$j]) > 2 ){
			$stateArray[$j]["ga_total"] = (empty($stateArray[$j]["ga_total"])) ? 0 : $stateArray[$j]["ga_total"];
			$stateArray[$j]["lf_total"] = (empty($stateArray[$j]["lf_total"])) ? 0 : $stateArray[$j]["lf_total"];
			
			$dd["data"][] = array($stateArray[$j]["StateName"],$stateArray[$j]["ga_total"],$stateArray[$j]["lf_total"]);
		}
	}
	
	$database->close();
	return($dd); 
}
}
?>
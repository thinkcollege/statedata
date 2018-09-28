<?php    
/*
class: functions
purpose: useful functions
*/
  
class oldFunctions {

/*
function: add_pagerights
*/
function add_pagerights() { 
	$database = Database::getDatabase();
	
	$results = $database->query("select itemid from items where tablename='pages'");
	for ($result=0;$result< $database->num_rows($results);$result++){
		$itemid = $database->fetch_result($results,$result,'itemid');
		$sql = "insert into rights ( userid, canadmin, canread, canwrite, itemid ) values (1,'t','t','t'," . $itemid . ")";
		$results2 = $database->query($sql);
		
		$sql = "insert into rights ( userid, canadmin, canread, canwrite, itemid ) values (2,'t','t','t'," . $itemid . ")";
		$results2 = $database->query($sql);
	}
	$database->close();
	return(1); 
}

/**
 *	 function: safehtml
 *	 purpose: strip out non-safe tags
 */
	function getFullUrl($urlencode = false) {
		$url = 'http' . (!empty($_SERVER["HTTPS"]) ? 's' : '') . '://' . $_SERVER["HTTP_HOST"]
			 . (($_SERVER["SERVER_PORT"] != 80 && empty($_SERVER['HTTPS']))
			  	|| ($_SERVER['SERVER_PORT'] != 443 && !empty($_SERVER['HTTPS']))
			  		? ':' . $_SERVER["SERVER_PORT"] : '')
			 . $_SERVER["SCRIPT_NAME"]
			 . ($_SERVER["QUERY_STRING"] != "" ? '?' . (!$urlencode ? htmlentities($_SERVER["QUERY_STRING"], ENT_COMPAT, 'UTF-8') : $_SERVER["QUERY_STRING"]) : '');
		return $urlencode ? urlencode($url) : $url;
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
function: getStates
purpose: returns a dropdown of states
*/
function getStates($element_name, $showAll = 1) { 
	$database = Database::getDatabase();
	
	$results = $database->query("SELECT abbreviation, name FROM states ORDER BY name");
	$html = "<select id=$element_name  name=$element_name onkeydown=\"return on_keydown_form(document.form1,event,'login');\">";
	$html .= "<option value=0>Choose state</option>";
	if ($showAll == 1) {
		//$html = $html . "<option value=ALL>ALL</option>";
		#$html .= "<option value=ALL>All States</option>";
	}
	for ($result=0;$result< $database->num_rows($results);$result++){
		$html .= "<option value='". $database->fetch_result($results,$result,'abbreviation') ."'>" . $database->fetch_result($results,$result,'name') . "</option>\n";
	}
	return $html . "</select>\n";
}

/*
function: getStatesFiltered
purpose: returns a dropdown of states
*/
function getStatesFiltered($element_name, $dataset, $showAll = 1) { 
   $join = $dataset != "ACS" && $dataset != 'ACS09'  && $dataset != 'VR' ? "LEFT JOIN {$dataset} d ON d.state = s.abbreviation " : '';
   $query = "select distinct name, abbreviation from {d3_states} s $join order by s.abbreviation = 'US' DESC, s.name";
   $results = db_query($query)->fetchAll(PDO::FETCH_ASSOC);
   

	
      

db_close();
//	return $html;
return $results;
}

/*
function: get_agency_tables
purpose: return select field with option values set to the names of the agency tables
*/
function get_agency_tables(){
 
	$results = db_query("SHOW TABLE STATUS LIKE '%agency%' ")->fetchAll(PDO::FETCH_ASSOC);
	$html	= "<select id=\"agency\" name=\"agency\">"
//	 		. "<option value='ACS'>Population Data from the American Community Survey (2000 to 2007)</option>\n"
			. "<option value='ACS09'>Population Data from the American Community Survey (Post 2007)</option>\n"
			. "<option value='VR'>State Vocational Rehabilitation (VR) Agency Data</option>\n";

	
	// $my_array[0]["Comment"] = 'Population Data from the American Community Survey (2000 to 2007)';
//	$my_array[0]["Name"] = 'ACS';
	$my_array[0]["Comment"] = 'Population Data from the American Community Survey (Post 2007)';
	$my_array[0]["Name"] = 'ACS09';
	$my_array[1]["Comment"] = 'State Vocational Rehabilitation (VR) Agency Data';
	$my_array[1]["Name"] = 'VR';
   $index = 2;
	foreach ($results as $dataset)
	{
   
		$my_array[$index]["Comment"] = $dataset["Comment"];
		$my_array[$index]["Name"] = $dataset["Name"];
		$index++;
	}
	
	sort($my_array);
	
	for ($result=0;$result< count($my_array);$result++){

		$table_name = $my_array[$result]['Name'];
		if (substr($table_name, 7, 13) == "agency") {
			$html .= "<option value='". $table_name ."'>" . $my_array[$result]['Comment'] . "</option>\n";
		}
	}
	
	/*
	for ($result=0;$result< $database->num_rows($results);$result++){

		$table_name = $database->fetch_result($results,$result,'Name');
		if (substr($table_name, 0, 6) == "agency") {
			$html .= "<option value='". $table_name ."'>" . $database->fetch_result($results,$result,'Comment') . "</option>\n";
		}
	}
	*/
	$html .= "</select>\n";
	db_close();
//	return $html;
return $my_array;

}
/*
function: get_acs_tables
purpose: return result
*/
function get_acs_tables($agency){
   


	$results = db_query("SHOW TABLE STATUS LIKE '{d3_acs_" . ($agency == 'ACS' ? 'pre05%}\'' : 'post08%}\''))->fetchAll(PDO::FETCH_ASSOC);
//	print "<!-- query:SHOW TABLE STATUS LIKE 'acs_" . ($agency == 'ACS' ? 'pre05%\'' : 'post08%\'') . " agency:$agency -->";

	
	
	db_close();
	return $results;
}

/*
function: get_vr_tables
purpose: return result
*/
function get_vr_tables($agency){
   
	$results = db_query("SHOW TABLE STATUS LIKE '{d3_vr_rsa%}'")->fetchAll(PDO::FETCH_ASSOC);;

	
	
	db_close();
	return $results;
	
}

/*
function: get_agency_tables
purpose: return result
*/
function get_agency_table_desc($table){
	$database = Database::getDatabase();
	$results = $database->query("SHOW TABLE STATUS");

	$desc = "";
	
	for ($result=0;$result< $database->num_rows($results);$result++){

		$table_name = $database->fetch_result($results,$result,'Name');
		if ($table_name == $table) {
			$desc = $database->fetch_result($results,$result,'Comment');
		}
	}
	$database->close();
	return $desc;

}

/*
function: get_individual_tables
purpose: return result
*/
function get_individual_tables(){
	$database = Database::getDatabase();
	$results = $database->query("SHOW TABLE STATUS");
	$html = "<select id=dataset name=dataset onkeydown=\"return on_keydown_form(document.form1,event,'login');\">";
	
	for ($result=0;$result< $database->num_rows($results);$result++){
		$table_name = $database->fetch_result($results,$result,'Name');
		if (substr($table_name, 0, 3) == "ind") {
			$html .= "<option value='". $table_name ."'>" . $database->fetch_result($results,$result,'Comment') . "</option>\n";
		}
	}
	$html .= "</select>\n";
	$database->close();
	return $html;

}

	/*
	function: translateState
	purpose: returns the state name if the abbreviation is passed in 
			 and the abbreviation if the state is passed in 
	*/
	function translateState($st) {
		if ($st == "ALL") {
			return 'All';
		}
		if (strlen($st) == 2) {
			$col	= '`name`';
			$where	= '`abbreviation`';
		} else {
			$col	= '`abbreviation`';
			$where	= '`name`';
		}
		
		$rs =  db_query("SELECT $col FROM `{d3_states}` WHERE $where = :state1", array(':state1' => "$st"))->fetchAll(PDO::FETCH_ASSOC);
		// print "<!-- query:SELECT $col FROM `states` WHERE $where = '$st' -->";
      
      $countrows = db_query("SELECT $col FROM `{d3_states}` WHERE $where = :state1", array(':state1' => "$st"))->rowCount();
		if ($countrows == 1) {
			return $rs[0]['name'];
		}
		return 'N/A';
	}

/*
function: getAgency
purpose: returns agency name 
*/
function getAgency($agency_table) {
/*	if ($agency_table == "ACS") {
		return "Population Data from the American Community Survey (2000 to 2007)";
	} else */ if ($agency_table == "ACS09") {
		return "Population Data from the American Community Survey (Post 2007)";
	} else if ($agency_table == "VR") {
		return "State Vocational Rehabilitation (VR) Agency Data";
	}  

   
	$results = db_query("SHOW TABLE STATUS" )->fetchAll(PDO::FETCH_ASSOC);
   $countrows = db_query("SHOW TABLE STATUS" )->rowCount();
	for ($result=0;$result< $countrows ;$result++){
		$table_name = $results[$result]['Name'];
		if ($table_name == $agency_table) {
			$agency = $results[$result]['Comment'];
		}
	}
	
		db_close();
	return $agency;
}

/*
function: get_individual_characteristics
purpose: returns columns in a table as a select dropdown
*/
function get_individual_characteristics($table) {
	$db		= Database::getDatabase();
	$fields = $db->query("SHOW columns from $table");
	$html	= "";
	while ($field = $db->fetch_assoc($fields)) {
		$field = $field['Field'];
		if (!in_array(strtolower($field), array("state", "year", "id")) && strpos($field, "var") !== 0) {
			$html  .= "<p><label for=\"$field\">$field:</label> <select id=\"$field\" name=\"$field\">"
					. "<option value=\"-1\">All</option>";
			$label	= "";
			$opts	= $db->query("SELECT value, label from value_names where column_name = '$field' and table_name = '$table'");
			while ($opt = $db->fetch_assoc($opts)) {
				if ($label != $opt['label']) {
					$label = $opt['label'];
					$html .= "<option value=\"{$opt['value']}\">{$opt['label']}</option>";
				}
			}
			$html .= "</select></p>\n";
		}
	}
	return $html; 
}

	/*
	function: get_table_columns
	purpose: returns columns in a table as a select dropdown
	*/
	function get_table_columns($table, $element_name) {
		$database = Database::getDatabase();

		$html = "<select name='$element_name'>";
		$html .= "<option value=0>none</option>";
		$fields = $database->query("Show columns from $table");
		for ($result = 0; $result < $database->num_rows($fields); $result++){
			$field = $database->fetch_result($fields, $result,"Field");
			if ($field != "REGION" && $field != "STATE NAME" && $field != "STATE"
			&& $field !=  "State_pop_1000s" && $field !=  "state_pop_100k"
			&& $field !=  "STATE POP 1000s" && $field !=  "STATE POP 100K"
			&& $field != "YEAR" && $field != "id" && (substr($table_name, 0, 3) != "ind") ) {
				$html .= "<option value='" . $field ."'>". $field ."</option>";
			}
		}

		return $html . "</select>\n";
	}

/*
function: get_vr_table_columns_as_checkboxes
purpose: returns columns in a table as a checkbox list
*/
function get_vr_table_columns_as_checkboxes($table, $total_vars) {
	$results = db_query("SHOW TABLE STATUS LIKE '{d3_vr_rsa%}'")->fetchAll(PDO::FETCH_ASSOC);

	$vr_table  = $results[0]['Name'];
	$fields = db_query("SELECT  * FROM `{d3_labels}` where `table_name` = '$vr_table' order by `sort_order`, `short_name`")->fetchAll(PDO::FETCH_ASSOC);
	$countrows = db_query("SELECT  * FROM `{d3_labels}` where `table_name` = '$vr_table' order by `sort_order`, `short_name`")->rowCount();
	$vr_buttons = array();
	
	for ($result = 0;$result < $countrows; $result++){
		$field['Field'] = $fields["$result"]["column_name"];
		$field["desc"] = $fields["$result"]["description"];
		$field["short_name"] = $fields["$result"]["short_name"];
		$field["label"] = $fields["$result"]["label"];
		
	$vr_buttons[] = $field;
	}
	

	
	db_close();
	return $vr_buttons; 
}

/*
function: get_acs_table_columns_as_checkboxes
purpose: returns columns in a table as a checkbox list
*/
function get_acs_table_columns_as_checkboxes($table, $total_vars) {
	
	
	$results = db_query("SHOW TABLE STATUS LIKE '{d3_acs_" . ($table == 'ACS' ? 'pre05%}\'' : 'post08%}\''))->fetchAll(PDO::FETCH_ASSOC);

	$acs_table = $results[0]['Name'];
	$fields = db_query("SELECT  * FROM `{d3_labels}` where `table_name` = '$acs_table' order by `sort_order`, `short_name`")->fetchAll(PDO::FETCH_ASSOC);
	$countrows = db_query("SELECT  * FROM `{d3_labels}` where `table_name` = '$acs_table' order by `sort_order`, `short_name`")->rowCount();
	$acs_buttons = array();
	for ($result = 0;$result < $countrows; $result++){
		$field['Field'] = $fields["$result"]["column_name"];
		$field["desc"] = $fields["$result"]["description"];
		$field["short_name"] = $fields["$result"]["short_name"];
		$field["label"] = $fields["$result"]["label"];
		$acs_buttons[] = $field;
	
	}
	

	
	db_close();
	return $acs_buttons; 
}

	/*
	function: get_table_columns_as_checkboxes
	purpose: returns columns in a table as a checkbox list
	*/
	function get_table_columns_as_checkboxes($table, $total_vars) {
		$database = Database::getDatabase();

		$html = "";
		$fields = $database->query("Show columns from $table");
		for ($result = 0; $result < $database->num_rows($fields); $result++) {
			$field = $database->fetch_result($fields,$result,"Field");
			if ($field != "REGION" && $field != "STATE NAME" && $field != "STATE"
			&& $field !=  "State_pop_1000s" && $field !=  "state_pop_100k"
			&& $field !=  "STATE POP 1000s" && $field !=  "STATE POP 100K"
			&& $field != "YEAR" && $field != "id" && (substr($table_name, 0, 3) != "ind") ) {
				//get the description as well
				$desc = $this->get_column_description($table, $field);
				$short_name =  $this->get_legend_name($table, $field);
				//now write the checkbox
				$html .= "<p><input id=\"c$result\" type=\"checkbox\" name=\"var\" value=\"$field\"> <label for=\"c$result\"><strong>$short_name</strong></label></p> <blockquote>$desc</blockquote>";
			}
		}
		return $html;
	}

/**
 *	 function: get_table_columns_as_radio
 *	 purpose: returns columns in a table as a checkbox list
 */
	function get_table_columns_as_radio($table, $total_vars) {
		if (substr($table, 0, 3) == "ind") {
			return '';
		}
      $buttons = array();
		$fields = db_query("Show columns from $table")->fetchAll(PDO::FETCH_ASSOC);
      $rowcount = db_query("Show columns from $table")->rowCount();
		for ($result = 0; $result < $rowcount; $result++) { 
			$field = $fields["$result"]["Field"];
        
			if ($field != "REGION" && $field != "STATE NAME" && $field != "STATE"
			&& $field !=  "State_pop_1000s" && $field !=  "state_pop_100k"
			&& $field !=  "STATE POP 1000s" && $field !=  "STATE POP 100K"
			&& $field != "YEAR" && $field != "id") {
				//get the description as well
				$desc = $this->get_column_description($table, $field);
				$short_name =  $this->get_legend_name($table, $field);
				$className = "agencyvars";
				if ($table == "{d3_agency_mrdd}" && (
					$field == "`Total served`" ||
					$field == "`Integrated employment`" ||
					$field == "`Integrated employment percentage rate`" ||
					$field == "`Integrated employment rate`" 
					)
					) {
					$className.=", showformrdd";
				}
            $button['Field'] = $field;
            $button['className'] = $className;
            $button['short_name'] = $short_name;
            $button['desc'] = $desc;
             if ($table != "{d3_agency_mrdd}" && ($field != 'CBNW_US_Count' && $field != 'FBNW_US_Count' && $field != 'FBW_US_Count' && $field != 'FBWandNW_US_Count')) {
            $buttons[] = $button; }
			}
		}
	//	print_r($buttons);
		return $buttons;
	}
	
/*
function: get_table_year
purpose: returns columns in a table as a checkbox list
*/
function get_table_year($table) {
	$database = Database::getDatabase();
	
	$html = "<select id='year' name='year'>";
	$fields = $database->query("select distinct year from $table order by year");
	for ($result=0;$result< $database->num_rows($fields);$result++){
		$field = $database->fetch_result($fields,$result,"year");
		$html .= "<option value='" . $field ."'>". $field ."</option>";
	}
	$html .= "</select>";

	
	$database->close();
	return($html); 
}

/*
function: get_table_columns_array
purpose: returns columns in a table as a select dropdown
*/
function get_table_columns_array($table) {
	$db = Database::getDatabase();
	$aryField = array();
	$fields = $db->query("SHOW columns from $table");
	while ($field = $db->fetch_assoc($fields)) {
		$aryField[] = strtolower($field["Field"]);
	}
	return $aryField;
}

/*
function: get_characteristics
purpose: save passed in values in an array based on the table name
*/
function get_characteristics($table) {
	static $return = array();
	if (count($return) > 0) {
		return $return;
	}
	$db		= Database::getDatabase();
	$fields = $db->query("SHOW columns from $table");
	while ($field = $db->fetch_assoc($fields)) {
		$field = str_replace(" ", "_", $field["Field"]);
		if (!in_array(strtolower($field), array("state", "year", "id")) && strpos($field, "var") !== 0 && isset($_REQUEST[$field])) {
			$return[$field] = $_REQUEST[$field];
		}
	}
	return $return;
}

/*
function: build_characteristics_querystring
purpose: save passed in values in an array based on the table name
*/
function build_characteristics_querystring($table) {
	$sep	= '';
	$str	= '';
	$fields = $this->get_characteristics($table);
	foreach ($fields as $field => $val) {
		$str .= $sep . urlencode($field) . "=" . urlencode($val);
		$sep = "&";
	}
	return $str;
}
/*
function: get_short_name
purpose: returns the short name for this field or the field name if no short name found
*/
function get_short_name($table_name, $column_name) {
	$database = Database::getDatabase();
	
	$short_name = "";

	$query = "select l.short_name, l.label from labels l where table_name='$table_name' and column_name= '$column_name'";
	$results = $database->query($query);
	if ($database->num_rows($results)!=1) {
		$label = $column_name;
	} else {

		$label = $database->fetch_result($results,0,1);

	}
	$database->close();
//	echo  $label ; 
	return ($label);
}

/*
function: get_legend_name
purpose: returns the legend name for this field or the field name if no short name found
*/
function get_legend_name($table_name, $column_name) {


	$short_name = "";

	$results = db_query("select l.short_name from {d3_labels} l where table_name='$table_name' and column_name= '$column_name'")->fetchField();
$countrows = db_query("select l.short_name from {d3_labels} l where table_name='$table_name' and column_name= '$column_name'")->rowCount();

	if ($countrows !=1) {
		$short_name = $column_name;
	} else {
		$short_name = $results;
	}
	db_close();
	return ($short_name);
}

/*
function: get_column_description
purpose: returns the column description
*/
function get_column_description($table_name, $column_name) {
	
	$description = "";

	$results = db_query("select description from {d3_labels} where table_name='$table_name' and column_name= '$column_name'")->fetchField();
   $countrows = db_query("select description from {d3_labels} where table_name='$table_name' and column_name= '$column_name'")->rowCount();
	
	/* if ($countrows !=1) {
		$description = "";
	} else { */
		$description = $results;
		// }
	db_close();
	return ($description);
}

/*
function: get_individual_table_outcomes
purpose: returns columns in a table as a select dropdown
*/
function get_individual_table_outcomes($table_name, $element_name) {
	$database = Database::getDatabase();
	$html = "<select id='$element_name' name='$element_name' onkeydown=\"return on_keydown_form(document.form1,event,'login');\">";
	//$html = $html . "<option value=0>none</option>";
	$fields = $database->query("Show columns from $table_name ");
	for ($result=0;$result< $database->num_rows($fields);$result++){
		$field = $database->fetch_result($fields,$result,"Field");
		$short_name =  $this->get_legend_name($table_name, $field);
		if ( substr ( $field, 0, 4) == "var_"  ) {
		
			$html .= "<option value='" . $field ."'>". $short_name ."</option>";
		}
	}
	
	$html .= "</select>\n";
	
	$database->close();
	return($html); 
}

/*
function: get_label_name
purpose: returns the value translated into its label name
*/
function get_label_name ($table_name, $column_name, $value) {
	$database = Database::getDatabase();
	$label = "";
	$hlabel = $database->query("Select label from value_names where table_name='$table_name' and column_name='$column_name' and value='$value'");
	if ($database->num_rows($hlabel)==1){
		$label = $database->fetch_result($hlabel,0,'label');
	} else {
		$label = $value;
	}
	$database->close();
	return($label); 
}

/*
function: get_characteristics_form
purpose: returns the characteristic fields for the individual data table
*/
function get_characteristics_form($table_name) {
	$database = Database::getDatabase();
	$html = "";
	//$html = "<select name='$element_name'>";
	$option0 = "<option value=0>do not include</option>";
	$column_name = "empty";
	$form_element = "";
	$fields = $database->query("select column_name, value, label from value_names where table_name = '$table_name' order by label, value");
	for ($result=0;$result< $database->num_rows($fields);$result++){
		$label = $database->fetch_result($fields,$result,"label");
		$value = $database->fetch_result($fields,$result,"value");
		$column_name = $database->fetch_result($fields,$result,"column_name");
		if ( $column_name_old == $column_name) {
			//if still on same label, just add an option
			$form_element .= "<option value='$value'>$label</option>";
		} else {
			//else we are on a new form element
			if ($form_element != "" ) {
				$form_element .= "</select></td></tr>";
				$html .= $form_element;
			}
			$form_element = "";
			$form_element = "<tr><td>$column_name</td><td>&nbsp;&nbsp;</td><td><select name='$column_name'>" . $option0;
			$form_element .= "<option value='$value'>$label</option>";
		}
		$column_name_old = $column_name;
	}
	$database->close();
	return ($html);
}

/*
function: get_outcome_type
purpose: returns the type of outcome that should be calculated
*/
function get_outcome_type($table_name, $column_name) {
	$database = Database::getDatabase();

	$outcome_type = "";

	$query = "select outcome_type from outcomes where table_name='$table_name' and column_name= '$column_name'";
	$results = $database->query($query);
	if ($database->num_rows($results)!=1) {
		$outcome_type = 'average';
	} else {
		$outcome_type = $database->fetch_result($results,0,0);
	}
	$database->close();
	return ($outcome_type);
}

	function createFile($url, $fout) {
		set_time_limit(0);
		$http = new http_class;
		/* Connection timeout */
		$http->timeout = 0;

		/* Data transfer timeout */
		$http->data_timeout = 0;

		/* Output debugging information about the progress of the connection */
		$http->debug = 0;

		/* Format dubug output to display with HTML pages */
		$http->html_debug = 1;

		/**
		 *  Need to emulate a certain browser user agent?
		 *  Set the user agent this way:
		 */
		$http->user_agent="Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";

		/**
		 *  If you want to the class to follow the URL of redirect responses
		 *  set this variable to 1.
		 */
		$http->follow_redirect = 1;

		/**
		 *  How many consecutive redirected requests the class should follow.
		 */
		$http->redirection_limit = 5;

		/**
		 * If your DNS always resolves non-existing domains to a default IP
		 * address to force the redirection to a given page, specify the
		 * default IP address in this variable to make the class handle it
		 * as when domain resolution fails.
		 */
		$http->exclude_address = "";

		/*
		 *  If basic authentication is required, specify the user name and
		 *  password in these variables.
		 */

		$user = $password = $realm = "";       /* Authentication realm or domain */
		$workstation = ""; /* Workstation for NTLM authentication */
		$authentication = (strlen($user) ? UrlEncode($user).":".UrlEncode($password)."@" : "");

		//$url=$regs[1];

		/*
		 *  Generate a list of arguments for opening a connection and make an
		 *  HTTP request from a given URL.
		 */
		$error = $http->GetRequestArguments($url, $arguments);

		if(strlen($realm))
		$arguments["AuthRealm"] = $realm;

		if(strlen($workstation))
		$arguments["AuthWorkstation"] = $workstation;

		$http->authentication_mechanism = ""; // force a given authentication mechanism;



		/* Set additional request headers */
		$arguments["Headers"]["Pragma"]="nocache";

		//flush();
		$error = $http->Open($arguments);

		if($error == ""){
			$error = $http->SendRequest($arguments);

			if($error=="") {
				$headers = array();
				$error = $http->ReadReplyHeaders($headers);
				if($error == "") {
					$myreply = "";
				for(;;) {
						$error = $http->ReadReplyBody($body, 1000);
						if ($error != "" || strlen($body) == 0) {
							break;
						}
						//echo HtmlSpecialChars($body);
						//$myreply = $myreply . $body;
						fwrite($fout, $body, 1000);
					}
					//flush();
				}
			}
			$http->Close();
		}
		if(strlen($error))
		echo "<CENTER><H2>Error: ",$error,"</H2><CENTER>\n";

	}

	/*purpose: to determin if an index esists in an array and has a value
	 */
	function has_value($param, $ary) {
		return (is_array($ary) && array_key_exists($param, $ary) && strlen($ary[$param]) > 0);
	}
	
	static public function set_selected($value1, $value2) {
		$ret = "";
		if ($value1 . "" == $value2 . "" ) {
			$ret = " selected ";
		}
		return $ret;
	}
}
?>
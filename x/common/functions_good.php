<?php    
/*
class: functions
purpose: useful functions
*/
class functions extends mre_base{

/*
function: add_pagerights
*/
function add_pagerights() { 
	$database=new database;
	$database->connect();
	

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
	$database=new database;
	$database->connect();
	

	$results = $database->query("Select abbreviation, name from states order by name");
	$html = "<select id=$element_name  name=$element_name onkeydown=\"return on_keydown_form(document.form1,event,'login');\">";
	$html .= "<option value=0>Choose state</option>";
	if ($showAll == 1) {
		//$html = $html . "<option value=ALL>ALL</option>";
	}
	for ($result=0;$result< $database->num_rows($results);$result++){
		$html .= "<option value='". $database->fetch_result($results,$result,'abbreviation') ."'>" . $database->fetch_result($results,$result,'name') . "</option>\n";
	}
	$html .= "</select>\n";
	$database->close();
	return($html); 
}

/*
function: getStatesFiltered
purpose: returns a dropdown of states
*/
function getStatesFiltered($element_name, $dataset, $showAll = 1) { 
	$database=new database;
	$database->connect();
	
	$results = $database->query("Select distinct s.abbreviation, s.name from states s,".$dataset." d where d.state = abbreviation order by s.name");
	$html = "<select id=$element_name name=$element_name onkeydown=\"return on_keydown_form(document.form1,event,'login');\">";
	$html .= "<option value=0>Choose state</option>";
	if ($showAll == 1) {
		//$html = $html . "<option value=ALL>ALL</option>";
	}
	for ($result=0;$result< $database->num_rows($results);$result++){
		$html .= "<option value='". $database->fetch_result($results,$result,'abbreviation') ."'>" . $database->fetch_result($results,$result,'name') . "</option>\n";
	}
	$html .= "</select>\n";
	$database->close();
	return($html); 
}

/*
function: get_agency_tables
purpose: return result
*/
function get_agency_tables(){

	$database=new database;
	$database->connect();
	$results = $database->query("SHOW TABLE STATUS");

	$html = "<select id=agency name=agency onkeydown=\"return on_keydown_form(document.form1,event,'login');\">";
	
	for ($result=0;$result< $database->num_rows($results);$result++){

		$table_name = $database->fetch_result($results,$result,'Name');
		if (substr($table_name, 0, 6) == "agency") {
			$html .= "<option value='". $table_name ."'>" . $database->fetch_result($results,$result,'Comment') . "</option>\n";
		}
	}
	$html .= "</select>\n";
	$database->close();
	return $html;

}

/*
function: get_agency_tables
purpose: return result
*/
function get_agency_table_desc($table){

	$database=new database;
	$database->connect();
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

	$database=new database;
	$database->connect();
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
	$database=new database;
	$database->connect();

	$results = $database->query("Select abbreviation from states where name='$st'" );
	if ($database->num_rows($results)!=1) {
		$results = $database->query("Select name from states where abbreviation='$st'");
	}
	$new_state = $database->fetch_result($results,0,0);
	$database->close();
	return($new_state); 
}

/*
function: getAgency
purpose: returns agency name 
*/
function getAgency($agency_table) {
	$database=new database;
	$database->connect();

	$results = $database->query("SHOW TABLE STATUS" );
	for ($result=0;$result< $database->num_rows($results);$result++){
		$table_name = $database->fetch_result($results,$result,'Name');
		if ($table_name == $agency_table) {
			$agency = $database->fetch_result($results,$result,'Comment');
		}
	}
	$database->close();
	return($agency); 
}

/*
function: get_individual_characteristics
purpose: returns columns in a table as a select dropdown
*/
function get_individual_characteristics($table) {
	$database=new database;
	$database->connect();
	
	$fields = $database->query("Show columns from $table");
	
	//loop throguh results, choose the relevant ones, 
	// then query value_names to get the possible values based on the name of the field.
	
	$html = "";
	for ($result=0;$result< $database->num_rows($fields);$result++){
		$field = $database->fetch_result($fields,$result,"Field");
		if (strtolower ($field) != "state" && strtolower($field) != "year" && $field != "id" && (substr($field, 0, 3) != "var") ) {
			$query = "Select value, label from value_names where column_name = '$field' and table_name ='$table'";
			$options = $database->query($query);
			
			$html .= "<tr><td align=right><label for='$field'>$field:</label></td><td><select id='$field' name='$field' onkeydown=\"return on_keydown_form(document.form1,event,'login');\">";
			$html .= "<option value=-1>All</option>";
			$label = "dummy";
			for ($option=0;$option< $database->num_rows($options);$option++){
				$value = $database->fetch_result($options, $option,"value");
				
				if ( $label != $database->fetch_result($options, $option,"label") ) {
					$label = $database->fetch_result($options, $option,"label");
					$html .= "<option value='" . $value ."'>". $label ."</option>";
				}
				$label = $database->fetch_result($options, $option,"label");
			}
			$html .= "</select></td></tr>\n";
		}
	}


	
	$database->close();
	return($html); 
}



/*
function: get_table_columns
purpose: returns columns in a table as a select dropdown
*/
function get_table_columns($table, $element_name) {
	$database=new database;
	$database->connect();
	$html = "<select name='$element_name'>";
	$html .= "<option value=0>none</option>";
	$fields = $database->query("Show columns from $table");
	for ($result=0;$result< $database->num_rows($fields);$result++){
		$field = $database->fetch_result($fields,$result,"Field");
		if ($field != "REGION" && $field != "STATE NAME" && $field != "STATE" 
				&& $field !=  "State_pop_1000s" && $field !=  "state_pop_100k"
				&& $field !=  "STATE POP 1000s" && $field !=  "STATE POP 100K"
				&& $field != "YEAR" && $field != "id" && (substr($table_name, 0, 3) != "ind") ) {
			$html .= "<option value='" . $field ."'>". $field ."</option>";
		}
	}
	
	$html .= "</select>\n";
	
	$database->close();
	return($html); 
}

/*
function: get_table_columns_as_checkboxes
purpose: returns columns in a table as a checkbox list
*/
function get_table_columns_as_checkboxes($table, $total_vars) {
	$database=new database;
	$database->connect();
	
	$html = "";
	$fields = $database->query("Show columns from $table");
	for ($result=0;$result< $database->num_rows($fields);$result++){
		$field = $database->fetch_result($fields,$result,"Field");
		if ($field != "REGION" && $field != "STATE NAME" && $field != "STATE" 
				&& $field !=  "State_pop_1000s" && $field !=  "state_pop_100k"
				&& $field !=  "STATE POP 1000s" && $field !=  "STATE POP 100K"
				&& $field != "YEAR" && $field != "id" && (substr($table_name, 0, 3) != "ind") ) {
			//get the description as well
			$desc = $this->get_column_description($table, $field);
			$short_name =  $this->get_legend_name($table, $field);
			//now write the checkbox	
			$html .= "<P><input id=$result onkeydown=\"return on_keydown_form(document.form1,event,'login');\" onClick=\"chech_vars(this, 'form1','vars', $total_vars);\" type=checkbox name=vars value='" . $field ."'><label for=$result><b>". $short_name  ."</b></label><blockquote>$desc</blockquote>";
		}
	}
	

	
	$database->close();
	return($html); 
}

/*
function: get_table_columns_as_radio
purpose: returns columns in a table as a checkbox list
*/
function get_table_columns_as_radio($table, $total_vars) {
	$database=new database;
	$database->connect();
	
	$html = "";
	$fields = $database->query("Show columns from $table");
	for ($result=0;$result< $database->num_rows($fields);$result++){
		$field = $database->fetch_result($fields,$result,"Field");
		if ($field != "REGION" && $field != "STATE NAME" && $field != "STATE" 
				&& $field !=  "State_pop_1000s" && $field !=  "state_pop_100k"
				&& $field !=  "STATE POP 1000s" && $field !=  "STATE POP 100K"
				&& $field != "YEAR" && $field != "id" && (substr($table_name, 0, 3) != "ind") ) {
			//get the description as well
			$desc = $this->get_column_description($table, $field);
			$short_name =  $this->get_legend_name($table, $field);
			//now write the checkbox	
			$html .= "<P><input id=$result onkeydown=\"return on_keydown_form(document.form1,event,'login');\" onClick=\"document.form1.variable1.value='" . $field ."';\" type=radio name=vars value='" . $field ."'><label for='$result'><b>". $short_name  ."</label></b><blockquote>$desc</blockquote>";
		}
	}
	

	
	$database->close();
	return($html); 
}

/*
function: get_table_year
purpose: returns columns in a table as a checkbox list
*/
function get_table_year($table) {
	$database=new database;
	$database->connect();
	
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
	$database=new database;
	$database->connect();
	$aryField = array();
	$fields = $database->query("Show columns from $table");
	for ($result=0;$result< $database->num_rows($fields);$result++){
		$aryField[$result] = $database->fetch_result($fields,$result,"Field");
	}
	
	$database->close();
	return($aryField); 
}

/*
function: get_characteristics
purpose: save passed in values in an array based on the table name
*/
function get_characteristics($table) {
	global $_REQUEST;
	$database=new database;
	$database->connect();
	$fields = $database->query("Show columns from $table");
	for ($result=0;$result< $database->num_rows($fields);$result++){
		$field = $database->fetch_result($fields,$result,"Field");
		if (strtolower ($field) != "state" && strtolower($field) != "year" && $field != "id" && (substr($field, 0, 3) != "var") ) {
			$http_field = str_replace(" ","_",$field);
			$return[$field] = $_REQUEST[$http_field];
		}
	}
	$database->close();
	return $return;
}

/*
function: build_characteristics_querystring
purpose: save passed in values in an array based on the table name
*/
function build_characteristics_querystring($table) {
	global $_REQUEST;
	$database=new database;
	$database->connect();
	$fields = $database->query("Show columns from $table");
	$qstring = "1=1";
	for ($result=0;$result< $database->num_rows($fields);$result++){
		$field = $database->fetch_result($fields,$result,"Field");
		if (strtolower ($field) != "state" && strtolower($field) != "year" && $field != "id" && (substr($field, 0, 3) != "var") ) {
			$http_field = str_replace(" ","_",$field);
			$qstring .= "&" . $http_field . "=" .$_REQUEST[$http_field];
		}
	}
	$database->close();
	return $qstring;
}
/*
function: get_short_name
purpose: returns the short name for this field or the field name if no short name found
*/
function get_short_name($table_name, $column_name) {
	$database=new database;
	$database->connect();

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
	$database=new database;
	$database->connect();

	$short_name = "";

	$query = "select l.short_name from labels l where table_name='$table_name' and column_name= '$column_name'";
	$results = $database->query($query);
	if ($database->num_rows($results)!=1) {
		$short_name = $column_name;
	} else {
		$short_name = $database->fetch_result($results,0,0);
	}
	$database->close();
	return ($short_name);
}

/*
function: get_short_name
purpose: returns the short name for this field or the field name if no short name found
*/
function get_column_description($table_name, $column_name) {
	$database=new database;
	$database->connect();

	$description = "";

	$query = "select description from labels where table_name='$table_name' and column_name= '$column_name'";
	$results = $database->query($query);
	if ($database->num_rows($results)!=1) {
		$description = "";
	} else {
		$description = $database->fetch_result($results,0,0);
	}
	$database->close();
	return ($description);
}

/*
function: get_individual_table_outcomes
purpose: returns columns in a table as a select dropdown
*/
function get_individual_table_outcomes($table_name, $element_name) {
	$database=new database;
	$database->connect();
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
	$database=new database;
	$database->connect();
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
	$database=new database;
	$database->connect();
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
	$database=new database;
	$database->connect();

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
	$http=new http_class;

	/* Connection timeout */
	$http->timeout=0;

	/* Data transfer timeout */
	$http->data_timeout=0;

	/* Output debugging information about the progress of the connection */
	$http->debug=0;

	/* Format dubug output to display with HTML pages */
	$http->html_debug=1;


	/*
	 *  Need to emulate a certain browser user agent?
	 *  Set the user agent this way:
	 */
	$http->user_agent="Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";

	/*
	 *  If you want to the class to follow the URL of redirect responses
	 *  set this variable to 1.
	 */
	$http->follow_redirect=1;

	/*
	 *  How many consecutive redirected requests the class should follow.
	 */
	$http->redirection_limit=5;

	/*
	 *  If your DNS always resolves non-existing domains to a default IP
	 *  address to force the redirection to a given page, specify the
	 *  default IP address in this variable to make the class handle it
	 *  as when domain resolution fails.
	 */
	$http->exclude_address="";

	/*
	 *  If basic authentication is required, specify the user name and
	 *  password in these variables.
	 */

	$user="";
	$password="";
	$realm="";       /* Authentication realm or domain      */
	$workstation=""; /* Workstation for NTLM authentication */
	$authentication=(strlen($user) ? UrlEncode($user).":".UrlEncode($password)."@" : "");

	//$url=$regs[1];

	/*
	 *  Generate a list of arguments for opening a connection and make an
	 *  HTTP request from a given URL.
	 */
	$error=$http->GetRequestArguments($url,$arguments);

	if(strlen($realm))
		$arguments["AuthRealm"]=$realm;

	if(strlen($workstation))
		$arguments["AuthWorkstation"]=$workstation;

	$http->authentication_mechanism=""; // force a given authentication mechanism;

	

	/* Set additional request headers */
	$arguments["Headers"]["Pragma"]="nocache";

	//flush();
	$error=$http->Open($arguments);

	if($error=="")
	{
		$error=$http->SendRequest($arguments);

		if($error=="")
		{

			$headers=array();
			$error=$http->ReadReplyHeaders($headers);
			if($error=="")
			{
			$myreply = "";
				for(;;)
				{
					$error=$http->ReadReplyBody($body,1000);
					if($error!=""
					|| strlen($body)==0)
						break;
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
}
?>
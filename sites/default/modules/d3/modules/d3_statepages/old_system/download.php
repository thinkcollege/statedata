class downloads {
protected $_site;
var $downloadsAry = array();
/*
function: get_agency_tables
purpose: return result
*/
public function __construct($site = 'statedata' ) {
		$this->_site = $site;
	

	$database = Database::getDatabase();
	$results = $database->query("Select downloadid, tablename, displayname, downloadFile, descriptionFile,lookup_table, lookup_field , isadmin from downloads where site ='" . $this->_site ."'");
$this->downloadsAry = $database->mysql_fetch_rowsassoc($results);
	mysql_free_result($results);
	/*
	for ($result=0;$result< $database->num_rows($results);$result++){

		$downloadid = $database->fetch_result($results,$result,'downloadid');
		$tablename = $database->fetch_result($results,$result,'tablename');
		$displayname = $database->fetch_result($results,$result,'displayname');
		$downloadFile = $database->fetch_result($results,$result,'downloadFile');
		$descriptionFile = $database->fetch_result($results,$result,'descriptionFile');
		
		$this->downloadsAry[$result]=array("downloadid"=>$downloadid,
				"tablename"=>$tablename,
				"displayname"=>$displayname,
				"downloadFile"=>$downloadFile,
				"descriptionFile"=>$descriptionFile);
	}	
	$database->close();
	*/
	}
function get_Download($id) {
	$record = null;
	foreach($this->downloadsAry as $row) {
		if ($row["downloadid"] == $id) {
			$record = $row;
			break;
		}
	}
	return $record;
}
	/*
	$database = Database::getDatabase();
	$results = $database->query("Select downloadid, tablename, displayname, downloadFile, descriptionFile  from downloads where downloadid=" . $id);
	$record = array();
	for ($result=0;$result< $database->num_rows($results);$result++){

		$record["tablename"] = $database->fetch_result($results,$result,'tablename');
		$record["displayname"] = $database->fetch_result($results,$result,'displayname');
		$record["downloadFile"] = $database->fetch_result($results,$result,'downloadFile');
		$record["descriptionFile"] = $database->fetch_result($results,$result,'descriptionFile');
	}	
	$database->close();
	return $record;
	*/
	function get_write_headers($id = '', $filename='') {
		if ($id != '') {
			foreach($this->downloadsAry as $row) {
				if ($row["downloadid"] == $id) {
					$this->write_headers($row["downloadFile"]);
					break;
				}
			}
		} else {
			if ($filename == '') {
				$filename = "download.csv";
			}
			$this->write_headers($filename);
		}
	}

function write_headers($filename) {
	header("Pragma: cache");
	header("Content-Type: text/comma-separated-values");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	ob_end_flush();
}
function write_records($record = '', $query = '', $tablename ='', $showheaders = true) {
	$database = Database::getDatabase();

	if ($query == '') {
		$query = "Select * from `" . $record["tablename"] . "` ";
		$tablename = $record["tablename"];
	}

	$results = $database->query($query);
	if ($showheaders == true && $database->num_rows($results) > 0 ) {
		//if we have results, print out the column headings
		$fields = $database->list_fields($tablename);
		for ($i = 0; $i < $database->num_rows($fields) ; $i++) {
			//echo $fields[$i];
			echo $database->fetch_result($fields,$i , 0);
			if ( ($i +1) != $database->num_rows($fields)) {
				echo ",";
			}
		}
		if ($record != '' && !has_value("lookupfield", $record)) {
			echo ",look up name";
		}
		echo "\n";
	}
	for ($result = 0; $result < $database->num_rows($results); $result = $result + 1) {
	//	loop through each record
		for ($field = 0; $field < $database->num_fields($results); $field++) {
			//right out each field with a comma
			echo "\"" . $database->fetch_result($results, $result, $field) ."\"";
			if ( ($field + 1) != $database->num_fields($results)) {
				echo ",";
			}
		}
		//if ( ($result +1) != $database->num_rows($results)) {
		echo "\n";
		//}
	}
}

}
?>
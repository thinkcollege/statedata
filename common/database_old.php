<?php   
/*
class: database
purpose: database abstraction functions
*/
class database extends mre_base{

/*
function: connect
purpose: connects to database
*/
function connect(){
	if ($this->database_type=="postgresql"){
		$connstring="";
		if ($this->database_host<>""){$connstring.=" host=$this->database_host";}
		if ($this->database_port<>""){$connstring.=" port=$this->database_port";}
		if ($this->database_dbname<>""){$connstring.=" dbname=$this->database_dbname";}
		if ($this->database_username<>""){$connstring.=" user=$this->database_username";}
		if ($this->database_password<>""){$connstring.=" password=$this->database_password";}
		return $this->database_conn=pg_connect($connstring);
	}
	if ($this->database_type=="mysql"){
		$connstring="";
		$this->database_conn=mysql_connect($this->database_host.":".$this->database_port,$this->database_username,$this->database_password);
		mysql_select_db($this->database_dbname);
		return $this->database_conn;
	}
}

/*
function: query
purpose: query with sql
*/
function query($sql){
	if ($this->database_type=="postgresql"){
		return pg_query($this->database_conn,$sql);
	}
	if ($this->database_type=="mysql"){
		$result = mysql_query($sql) or die(  mysql_error());
		return $result ;
	}
}

/*
function: insert_id
purpose: returns the id for the last inserted row
*/
function insert_id(){
	if ($this->database_type=="postgresql"){
		return -1;
	}
	if ($this->database_type=="mysql"){
		return mysql_insert_id();
	}
}

/*
function: fetch_result
purpose: return result
*/
function fetch_result($result,$row,$column){
	if ($this->database_type=="postgresql"){
		return pg_fetch_result($result,$row,$column);
	}
	if ($this->database_type=="mysql"){
		return mysql_result($result,$row,$column);
	}
}

/*
function: fetch_result_array
purpose: return result
*/
function fetch_result_array($results){

	return mysql_fetch_array ($results);
}

/*
function: mysql_fetch_rowsarr
purpose: return all the rows as a 2D array. 
example use: 
$results = $database->query($query);
$arr = $database->mysql_fetch_rowsarr($results);
$password = $arr[2]['password'];

*/
function mysql_fetch_rowsarr($result) {
		$got = array();
		if(mysql_num_rows($result) == 0) {
			return $got;
		}
		mysql_data_seek($result, 0);
		while ($row = mysql_fetch_array($result)) {
			$got[] = $row;
		}
		return $got;
	}

	function mysql_fetch_rowsassoc($result) {
		$got = array();
		if(mysql_num_rows($result) == 0) {
			return $got;
		}
		mysql_data_seek($result, 0);
		while ($row = mysql_fetch_assoc($result)) {
			$got[] = $row;
		}
		return $got;
	}


/*
function: num_rows
purpose: return number of rows
*/
function num_rows($result){
	if ($this->database_type=="postgresql"){
		return pg_num_rows($result);
	}
	if ($this->database_type=="mysql"){
		return mysql_num_rows($result);
	}
}

/*
function: num_fields
purpose: return number of fields
*/
function num_fields($result){
	if ($this->database_type=="postgresql"){
		return pg_num_fields($result);
	}
	if ($this->database_type=="mysql"){
		return mysql_num_fields($result);
	}
}

/*
function: get_insert_id
purpose: return number of fields
*/
function get_insert_id(){
	if ($this->database_type=="postgresql"){
		return 0;
	}
	if ($this->database_type=="mysql"){
		return mysql_insert_id();
	}
}

/*
function: list_fields
purpose: return names of fields
*/
function list_fields($table){
	if ($this->database_type=="postgresql"){
		return pg_num_fields($result);
	}
	if ($this->database_type=="mysql"){
	$fields = mysql_list_fields($this->database_dbname, $table, $this->connect());
	$columns = mysql_num_fields($fields);
	
	for ($i = 0; $i < $columns; $i++) {
	    echo mysql_field_name($fields, $i) . "\n";
	}
		return mysql_list_fields($this->database_dbname, $table, $this->database_conn);
	}
}

/*
function: close
purpose: close connection
*/
function close(){
	if ($this->database_type=="postgresql"){
		return pg_close($this->database_conn);
	}
	if ($this->database_type=="mysql"){
		//ici has probelm with this line
		//return mysql_close($this->database_conn);
	}
}
	function fetch_assoc($result) {
		if ($this->database_type == 'postregsql') {
			$a = pg_fetch_assoc($result);
			#pg_free_result($result);
		} else if ($this->database_type == 'mysql') {
			$a = mysql_fetch_assoc($result);
			#mysql_free_result($result);
		}
		return $a;
	}
	
	function escape($str) {
		if ($this->database_type == 'postgresql' && is_binary($str)) {
			return pg_escape_bytes($str);
		} else if ($this->database_type == 'postgresql') {
			return pq_escape_string($str);
		} else if ($this->database_type == 'mysql') {
			return mysql_real_escape_string($str);
		}
	}
	
/*
function: search
purpose: search database
*/
function search($findtext,$table,$column){
	$return["success"]="false";
	if ($findtext<>"" and $table<>"" and $column<>""){
		$arrSearch = explode(" ", $findtext);
		for ($i=0; $i<count($arrSearch); $i++) {
			$return["success"]="true";
			if ($arrSearch[$i]==" "){
				$return["success"]="false";
			} else {
				if (strToUpper($arrSearch[$i])=='AND' or strToUpper($arrSearch[$i])=='OR' or strToUpper($arrSearch[$i])=='NOT') {
					if (strToUpper($arrSearch[$i])=='NOT') {
						$i++;
						$query = $query." and $column not like '%".$arrSearch[$i]."%'";
					} else {
						$query = $query." ".$arrSearch[$i]." ";
					}
				} else {
					if ($i>0 and strToUpper($arrSearch[$i-1])<>"AND" and strToUpper($arrSearch[$i-1])<>"OR" and strToUpper($arrSearch[$i-1])<>"NOT"){
						$query = $query." or $column like '%".$arrSearch[$i]."%'";
					} else {
						$query = $query." $column like '%".$arrSearch[$i]."%'";						
					}
				}
			}
		}
		if ($return["success"]<>"false"){
			$database=new database;
			$database->connect();
			$query="select * from $table where ".$query.";";
			$return["result"]=$database->query($query);  
			$return["success"]="true";
		}
	}
	return $return;
}




}
?>
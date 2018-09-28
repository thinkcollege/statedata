<?php
/*
 class: database
 purpose: database abstraction functions
 */
class database extends mre_base{

	/**
	 * Constructor for the database object.
	 *
	 */
	private function __construct() {}

	/**
	 * Creates the database object and connects to the database.
	 *
	 * @return database
	 */
	static public function getDatabase() {
		static $conn = null;
		if ($conn == null) {
			$conn = new database;
			$conn->connect();
		}
		return $conn;
	}

	/**
	 * Connects to database
	 */
	private function connect() {
		$this->mre_base();
		if ($this->database_type == "postgresql") {
			$connstring = ($this->database_host <> "" ? $connstring .= " host=$this->database_host" : '')
						. ($this->database_port <> "" ? $connstring .= " port=$this->database_port" : '')
						. ($this->database_dbname <> "" ? $connstring .= " dbname=$this->database_dbname" : '')
						. ($this->database_username <> "" ? $connstring .= " user=$this->database_username" : '')
						. ($this->database_password <>"" ? $connstring .= " password=$this->database_password" : '');
			return $this->database_conn = pg_connect($connstring);
		}
		if ($this->database_type=="mysql"){
			$connstring="";
			$this->database_conn = mysql_connect($this->database_host.":".$this->database_port,$this->database_username,$this->database_password);
			mysql_select_db($this->database_dbname);
			return $this->database_conn;
		}
	}

	/**
	 * Query the database with the give SQL statement.
	 *
	 * @return resource
	 */
	function query($sql) {
		write_debug($sql, 'blue');
		if ($this->database_type == "postgresql"){
			return pg_query($this->database_conn,$sql);
		}
		if ($this->database_type == "mysql") {
			$result = mysql_query($sql);
			if ($result === false) {
				print '<pre>';
				debug_print_backtrace();
				print '</pre>';
				die(mysql_error() . '<br />' . $sql);
			}
			return $result ;
		}
	}

	/**
	 * Returns the id for the last inserted row.
	 *
	 * @return int
	 */
	function insert_id(){
		if ($this->database_type=="postgresql"){
			return -1;
		}
		if ($this->database_type=="mysql"){
			return mysql_insert_id();
		}
	}

	/**
	 * Returns a specific value from the result set specified by the row and column.
	 *
	 * @param resource	$result
	 * @param int 		$row
	 * @param int		$column
	 * @return mixed
	 */
	public function fetch_result($result, $row, $column) {
		if ($this->database_type=="postgresql") {
			return pg_fetch_result($result, $row, $column);
		}
		if ($this->database_type == "mysql"){
			return mysql_result($result, $row, $column);
		}
	}

	/**
	 * Return a single row as an array.
	 *
	 * @param resource $results
	 * @return array
	 */
	function fetch_result_array($results) {
		return mysql_fetch_array($results);
	}

	/**
	 * Return all the rows as a 2D array.
	 *
	 * @example $results = $database->query($query);
	 * $arr = $database->mysql_fetch_rowsarr($results);
	 * $password = $arr[2]['password'];
	 *
	 * @param resource $result
	 * @return array
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

	/**
	 * Return number of rows
	 *
	 * @param resource $result
	 * @return int
	 */
	function num_rows($result){
		if ($this->database_type=="postgresql"){
			return pg_num_rows($result);
		}
		if ($this->database_type=="mysql"){
			return mysql_num_rows($result);
		}
	}

	/**
	 * Return number of fields
	 *
	 *
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
	function get_insert_id() {
		if ($this->database_type == "postgresql"){
			return 0;
		}
		if ($this->database_type == "mysql"){
			return mysql_insert_id();
		}
	}

	/*
	 function: list_fields
	 purpose: return names of fields
	 */
	function list_fields($table) {
		if ($this->database_type == "postgresql"){
			return pg_num_fields($result);
		}
		if ($this->database_type == "mysql") {
			$this->connect();
			return $this->query('SHOW COLUMNS FROM ' . $table);
		}
	}

	/*
	 function: close
	 purpose: close connection
	 */
	public function close(){
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
			return pg_fetch_assoc($result);
		} else if ($this->database_type == 'mysql') {
			return $this->fetch_array($result, MYSQL_ASSOC);
		}
	}
	
	function fetch_array($rs, $type = MYSQL_BOTH) {
		if ($this->database_type == 'postregsql') {
			
		} else if ($this->database_type == 'mysql') {
			return mysql_fetch_array($rs, $type);
		}
	}
	
	function fetch_row($rs) {
		if ($this->database_type == 'postregsql') {
			
		} else if ($this->database_type == 'mysql') {
			return $this->fetch_array($rs, MYSQL_NUM);
		}
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
	function search($findtext, $table, $column){
		$return["success"]="false";
		if ($findtext<>"" and $table<>"" and $column<>""){
			$arrSearch = explode(" ", $findtext);
			for ($i=0; $i<count($arrSearch); $i++) {
				$return["success"]="true";
				if ($arrSearch[$i] == " "){
					$return["success"] = "false";
				} else {
					if (strToUpper($arrSearch[$i]) == 'AND' or strToUpper($arrSearch[$i]) == 'OR' or strToUpper($arrSearch[$i]) == 'NOT') {
						if (strToUpper($arrSearch[$i]) == 'NOT') {
							$i++;
							$query = $query." and $column not like '%".$arrSearch[$i]."%'";
						} else {
							$query = $query." ".$arrSearch[$i]." ";
						}
					} else {
						if ($i > 0 and strToUpper($arrSearch[$i-1])<>"AND" and strToUpper($arrSearch[$i-1])<>"OR" and strToUpper($arrSearch[$i-1])<>"NOT"){
							$query = $query." or $column like '%".$arrSearch[$i]."%'";
						} else {
							$query = $query." $column like '%".$arrSearch[$i]."%'";
						}
					}
				}
			}
			if ($return["success"]<>"false"){
				$query = "select * from $table where ".$query.";";
				$return["result"] = $this->query($query);
				$return["success"] = "true";
			}
		}
		return $return;
	}
} ?>
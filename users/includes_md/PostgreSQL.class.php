<?php
/*** *** *** *** *** ***
* @package Quadodo Login Script
* @file    PostgreSQL.class.php
* @start   September 23rd, 2007
* @author  Douglas Rennehan
* @license http://www.opensource.org/licenses/gpl-license.php
* @version 1.1.0
* @link    http://www.quadodo.com
*** *** *** *** *** ***
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*** *** *** *** *** ***
* Comments are always before the code they are commenting.
*** *** *** *** *** ***/
if (!defined('QUADODO_IN_SYSTEM')) {
exit;	
}

/**
 * Contains the necessary functions to run the database queries
 */
class PostgreSQL {

/**
 * @var object $qls - Will contain everything else
 */
var $qls;

	/**
	 * Constructs the class and initializes some variables
	 * @param    string  $server_name - Server name for the connection
	 * @param    string  $username    - Username for the connection
	 * @param    string  $password    - Password for the connection
	 * @param    string  $name        - Database name
	 * @param    boolean $persistent  - Use persistent connections
	 * @param    object  $qls         - Contains all other classes
	 * @optional integer $port        - Contains port or false for no port
	 * @return void but outputs error if found
	 */
	function PostgreSQL($server_name, $username, $password, $name, $persistent, &$qls, $port = false) {
	$this->qls = &$qls;
	$this->server_name = $server_name;
	$this->username = $username;
	$this->password = $password;
	$this->name = $name;
	$this->port = $port;
	$this->persistent = $persistent;
	$connection_string = ($this->port !== false) ? "host={$this->server_name} port={$this->port} dbname={$this->name} user={$this->username} password={$this->password}" : "host={$this->server_name} dbname={$this->name} user={$this->username} password={$this->password}";

	// If the connection is persistent, connect with a persistent connection :P
	$this->connection = ($this->persistent) ? @pg_pconnect($connection_string) : @pg_connect($connection_string);
		if (!$this->connection) {
		die(pg_last_error());
		}
	}

	/**
	 * Add 1 to total queries
	 * @return void
	 */
	function update_queries() {
	$this->total_queries = $this->total_queries + 1;
	}

	/**
	 * http://www.php.net/pg_affected_rows
	 */
	function affected_rows() {
	return pg_affected_rows($this->connection);
	}

	/**
	 * http://www.php.net/pg_fetch_row
	 */
	function fetch_row($result) {
	return pg_fetch_row($result);	
	}

	/**
	 * http://www.php.net/pg_fetch_assoc
	 */
	function fetch_assoc($result) {
	return pg_fetch_assoc($result);
	}

	/**
	 * http://www.php.net/pg_fetch_array
	 */
	function fetch_array($result) {
	return pg_fetch_array($result);
	}

	/**
	 * http://www.php.net/pg_free_result
	 */
	function free_result($result) {
	return pg_free_result($result);
	}

	/**
	 * Returns the current version of the SQL
	 * @return string
	 */
	function get_client_info() {
	$version = pg_version($this->connection);
	return $version['client'];
	}

	/**
	 * @TODO
	 *  This isn't used in the system yet, so I will fix this
	 *  as soon as I figure something out :)
	 * @return 0
	 */
	function insert_id() {
	return 0;
	}

	/**
	 * http://www.php.net/pg_num_fields
	 */
	function num_fields($result) {
	return pg_num_fields($result);
	}

	/**
	 * http://www.php.net/pg_num_rows
	 */
	function num_rows($result) {
	return pg_num_rows($result);
	}

	/**
	 * This function manages transactions
	 * @param string $status - Which transaction method
	 * @return true on success or if $status not set, false on failure
	 */
	function transaction($status = 'BEGIN') {
		switch (strtoupper($status)) {
			default:
			return true;
			break;
			case 'START':
			case 'START TRANSACTION':
			case 'BEGIN':
			return @pg_query($this->connection, 'START TRANSACTION');
			break;
			case 'COMMIT':
			return @pg_query($this->connection, 'COMMIT');
			break;
			case 'ROLLBACK':
			return @pg_query($this->connection, 'ROLLBACK');
			break;
		}
	}

	/**
	 * This function selects a query from the database.
	 * @param    mixed  $what     - An array of fields to select or a string for one field
	 * @param    string $from     - Which table to select from
	 * @optional array  $where    - Array containing the information for the WHERE clause
	 * @optional array  $order_by - Contains field to order by and direction
	 * @optional array  $limit    - Contains offset and number
	 * @return void
	 */
	function select($what, $from, $where = false, $order_by = false, $limit = false) {
	$new_what = '';
	$new_where = '';
	$new_order_by = '';
	$new_limit = '';

		// See if it is an array
		if (is_array($what)) {
			if (count($what) == 1 && $what[0] == '*') {
			$new_what = '*';
			}
			else {
				/**
				 * Loop through the $what variable and if it is not the
				 * last one, add a comma in the SQL.
				 */
				foreach ($what as $key => $value) {
					if ((count($what) - 1) == $key) {
					$new_what .= "`{$value}`";
					}
					else {
					$new_what .= "`{$value}`,";
					}
				}
			}
		}
		else {
			if ($what != '') {
				switch ($what) {
					default:
					$new_what = "`{$what}`";
					break;
					case '*':
					$new_what = '*';
					break;
				}
			}
			else {
			die(SQL_SELECT_QUERY_FAILED);
			}
		}

	// Build the query
	$query = "SELECT {$new_what} FROM `{$this->qls->config['sql_prefix']}{$from}`";

		if ($where !== false) {
			if (is_array($where)) {
				// Shouldn't be divisble by 2
				if ((count($where) % 2) == 0) {
				die(SQL_SELECT_QUERY_FAILED);
				}
				else {
				$x = 0;
					foreach ($where as $key => $value) {
					$x++;
						// Is it the last one?
						if (count($where) == $x) {
							// The last one must be an array
							if (is_array($value)) {
								if (is_numeric($value[1])) {
								$new_where .= "`{$key}`" . $value[0] . "{$value[1]}";
								}
								else {
								$new_where .= "`{$key}`" . $value[0] . "'{$value[1]}'";
								}
							}
							else {
							die(SQL_SELECT_QUERY_FAILED);
							}
						}
						else {
							/**
							 * If the number we are on is divsible by
							 * 2 and it's equal to one of those put
							 * the value in the variable.
							 */
							if (($x % 2) == 0 && ($value == "AND" || $value == "OR" || $value == "XOR") === true) {
							$new_where .= " {$value} ";
							}
							else {
								// Must be an array if not... stop
								if (is_array($value)) {
									if (is_numeric($value[1])) {
									$new_where .= "`{$key}`" . $value[0] . "{$value[1]}";
									}
									else {
									$new_where .= "`{$key}`" . $value[0] . "'{$value[1]}'";
									}
								}
								else {
								die(SQL_SELECT_QUERY_FAILED);
								}
							}
						}
					}
				}
			}
			else {
				// It's not an array and not nothing put it in
				if ($where != '') {
				$new_where = $where;
				}
				else {
				die(SQL_SELECT_QUERY_FAILED);
				}
			}
		}

		// Add to query if exists
		if ($new_where != '') {
		$query .= " WHERE {$new_where}";
		}

		if ($order_by !== false) {
			if (is_array($order_by)) {
				// Make sure the count is equal to 2
				if (count($order_by) == 2) {
					if ($order_by[1] == "ASC" || $order_by[1] == "DESC") {
					$new_order_by = "`{$order_by[0]}` {$order_by[1]}";
					}
					else {
					die(SQL_SELECT_QUERY_FAILED);
					}
				}
				else {
				die(SQL_SELECT_QUERY_FAILED);
				}
			}
			else {
			die(SQL_SELECT_QUERY_FAILED);
			}
		}

		// If it exists add to query
		if ($new_order_by != '') {
		$query .= " ORDER BY {$new_order_by}";
		}

		if ($limit !== false) {
			if (is_array($limit)) {
				// Make sure the count is equal to 2
				if (count($limit) == 2) {
				$new_limit = 'LIMIT ' . (int)$limit[1] . ' OFFSET ' . (int)$limit[0];
				}
				else {
				die(SQL_SELECT_QUERY_FAILED);
				}
			}
			else {
			die(SQL_SELECT_QUERY_FAILED);
			}
		}

		// If exists add to query
		if ($new_limit != '') {
		$query .= " {$new_limit}";
		}

	$this->update_queries();
	$this->last_query[] = $query;
	pg_query($this->connection, $query) or die(pg_last_error());
	}

	/**
	 * Deletes a row from the database
	 * @param string $from  - Table to delete from
	 * @param array  $where - Array containing WHERE information
	 * @return void
	 */
	function delete($from, $where) {
	$new_from = '';
	$new_where = '';
		// Can't be an array
		if (!is_array($from) && $from != '') {
		$new_from = "`{$this->qls->config['sql_prefix']}{$from}`";
		}
		else {
		die(SQL_DELETE_QUERY_FAILED);
		}

	// Build query
	$query = "DELETE FROM {$new_from}";

		// Must be an array
		if (is_array($where)) {
			foreach ($where as $key => $value) {
				if (is_array($value)) {
					if (is_numeric($value[1])) {
					$new_where = "`{$key}`{$value[0]}{$value[1]}";
					}
					else {
					$new_where = "`{$key}`{$value[0]}'{$value[1]}'";
					}
				}
				else {
				die(SQL_DELETE_QUERY_FAILED);
				}

			break;
			}
		}
		else {
		die(SQL_DELETE_QUERY_FAILED);
		}

	// Add to query
	$query .= " WHERE {$new_where}";

	$this->update_queries();
	$this->last_query[] = $query;
	pg_query($this->connection, $query) or die(pg_last_error());
	}

	/**
	 * Run an update query
	 * @param string $table - Table to delete from
	 * @param array  $set   - Array holding new information
	 * @param array  $where - Condition to delete
	 * @return void
	 */
	function update($table, $set, $where) {
	$new_table = '';
	$new_set = '';
	$new_where = '';
		// Can't be an array or empty
		if (!is_array($table) && $table != '') {
		$new_table = "`{$this->qls->config['sql_prefix']}{$table}`";
		}
		else {
		die(SQL_UPDATE_QUERY_FAILED);
		}

	// Build the query
	$query = "UPDATE {$new_table}";

		// Must be an array
		if (is_array($set)) {
		$x = 0;
			// $key will hold the column name and $value the new value
			foreach ($set as $key => $value) {
			$x++;
				// Last one?
				if (count($set) == $x) {
				$new_set .= "`{$key}`='{$value}'";
				}
				else {
				$new_set .= "`{$key}`='{$value}',";
				}
			}
		}
		else {
		die(SQL_UPDATE_QUERY_FAILED);
		}

	// Add to query
	$query .= " SET {$new_set}";

		if (is_array($where)) {
			// Shouldn't be divisble by 2
			if ((count($where) % 2) == 0) {
			die(SQL_UPDATE_QUERY_FAILED);
			}
			else {
			$x = 0;
				foreach ($where as $key => $value) {
				$x++;
					// Is it the last one?
					if (count($where) == $x) {
						// The last one must be an array
						if (is_array($value)) {
							if (is_numeric($value[1])) {
							$new_where .= "`{$key}`" . $value[0] . "{$value[1]}";
							}
							else {
							$new_where .= "`{$key}`" . $value[0] . "'{$value[1]}'";
							}
						}
						else {
						die(SQL_UPDATE_QUERY_FAILED);
						}
					}
					else {
						/**
						 * If the number we are on is divsible by
						 * 2 and it's equal to one of those put
						 * the value in the variable.
						 */
						if (($x % 2) == 0 && ($value == "AND" || $value == "OR" || $value == "XOR") === true) {
						$new_where .= " {$value} ";
						}
						else {
							if (is_array($value)) {
								if (is_numeric($value[1])) {
								$new_where .= "`{$key}`" . $value[0] . "{$value[1]}";
								}
								else {
								$new_where .= "`{$key}`" . $value[0] . "'{$value[1]}'";
								}
							}
							else {
							die(SQL_UPDATE_QUERY_FAILED);
							}
						}
					}
				}
			}
		}
		else {
			// It's not an array and not nothing put it in
			if ($where != '') {
			$new_where = $where;
			}
			else {
			die(SQL_UPDATE_QUERY_FAILED);
			}
		}

	// Add to query
	$query .= " WHERE {$new_where}";

	$this->update_queries();
	$this->last_query[] = $query;
	pg_query($this->connection, $query) or die(pg_last_error());
	}

	/**
	 * Inserts data into a specified table
	 * @param string $table   - Table to insert into
	 * @param array  $columns - Array of columns corresponding to the values
	 * @param array  $values  - Array of values corresponding to the columns
	 * @return void
	 */
	function insert($table, $columns, $values) {
	$new_table = '';
	$new_columns = '';
	$new_values = '';
	$column_count = count($columns);
	$value_count = count($values);

		// Did they define a table?
		if ($table != '') {
		$new_table = "`{$this->qls->config['sql_prefix']}{$table}`";
		}
		else {
		die(SQL_INSERT_QUERY_FAILED);
		}

	// Build query
	$query = "INSERT INTO {$new_table}";

		// The column count must equal the value count
		if ($column_count == $value_count) {
			// Must be an array
			if (is_array($columns)) {
			$x = 0;
				// Loop through the values
				foreach ($columns as $value) {
				$x++;
					if ($x == $column_count) {
					$new_columns .= "`{$value}`";
					}
					else {
					$new_columns .= "`{$value}`,";
					}
				}
			}
			else {
			die(SQL_INSERT_QUERY_FAILED);
			}

		// Add to query
		$query .= " ({$new_columns})";

			// Must be an array
			if (is_array($values)) {
			$x = 0;
				// Loop through the values
				foreach ($values as $value) {
				$x++;
					if ($x == $value_count) {
						if (is_numeric($value)) {
						$new_values .= "{$value}";
						}
						else {
						$new_values .= "'{$value}'";
						}
					}
					else {
						if (is_numeric($value)) {
						$new_values .= "{$value},";
						}
						else {
						$new_values .= "'{$value}',";
						}
					}
				}
			}
			else {
			die(SQL_INSERT_QUERY_FAILED);
			}

		// Add to query
		$query .= " VALUES({$new_values})";

		$this->update_queries();
		$this->last_query[] = $query;
		pg_query($this->connection, $query) or die(pg_last_error());
		}
		else {
		die(SQL_INSERT_QUERY_FAILED);
		}
	}

	/**
	 * Alters a table in the database
	 * @param    string  $table     - Which table to alter
	 * @param    string  $action    - Either 'add' or 'drop'
	 * @param    string  $column    - Column name to drop/add
	 * @optional string  $data_type - Contains a SQL statement for the field type
	 * @optional boolean $null      - If the $action is add, is it NULL?
	 * @return void
	 */
	function alter($table, $action, $column, $data_type = false, $null = false) {
	$new_table = '';
	$new_action = '';
	$new_column = '';
	$new_data_type = '';
	$new_null = '';

		// Check the table
		if ($table != '') {
		$new_table = "{$this->qls->config['sql_prefix']}{$table}";
		}
		else {
		die(SQL_ALTER_QUERY_FAILED);
		}

	// Build the query
	$query = "ALTER TABLE {$new_table}";

		// Go through possible $action values
		switch (strtolower($action)) {
			case 'drop':
			$new_action = 'DROP COLUMN';
			break;
			case 'add':
			$new_action = 'ADD';
			break;
			default:
			die(SQL_ALTER_QUERY_FAILED);
			break;
		}

	// Append to query
	$query .= " {$new_action}";

		// Check column
		if ($column != '') {
		$new_column = "`{$column}`";
		}
		else {
		die(SQL_ALTER_QUERY_FAILED);
		}

	// Append column name to query
	$query .= " {$new_column}";

		// Are we adding a column?
		if (strtolower($action) == 'add') {
			if ($data_type !== false) {
			// Make the data type's valid
			$data_type = strtolower($data_type);

				if ($null) {
				// Append column information to query
				$query .= " {$data_type} NULL";
				}
				else {
				$query .= " {$data_type} NOT NULL";
				}
			}
			else {
			die(SQL_ALTER_QUERY_FAILED);
			}
		}

	$this->update_queries();
	$this->last_query[] = $query;
	pg_query($this->connection, $query) or die(pg_last_error());
	}

	/**
	 * Runs a SQL query on the database
	 * @param string $query - SQL query to run on database
	 * @return result identifier on success
	 */
	function query($query) {
		if ($query != '') {
		$query = preg_replace("/LIMIT ([0-9]+),([ 0-9]+)/", "LIMIT \\2 OFFSET \\1", $query);
			// Run and check if true or false
		$this->update_queries();
		$this->last_query[] = $query;
		$result = pg_query($this->connection, $query) or die(pg_last_error());
		return $result;
		}
		else {
		// Find the error for no query
		$result = pg_query($this->connection, '') or die(pg_last_error());
		return $result;
		}
	}

	/**
	 * http://www.php.net/mysql_close
	 */
	function close() {
	return pg_close($this->connection);
	}
}
?>
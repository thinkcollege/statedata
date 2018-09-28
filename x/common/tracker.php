<?php    
/*
class: tracker
purpose: used to track quieries
*/
class tracker extends mre_base{
/*
function: add_download
purpose: to track the number of tiems a dataset is queried
*/
function add_download($name) { 

	$database = Database::getDatabase();

	$results = $database->query("insert into count_downloads (name) values('" . $name . "')");

	$id = $database->get_insert_id();
	return($id); 
}


/*
function: add_dataset
purpose: to track the number of tiems a dataset is queried
*/
function add_dataset($name) { 

	$database = Database::getDatabase();

	$results = $database->query("insert into count_datasets (name) values('" . $name . "')");

	$id = $database->get_insert_id();
	return($id); 
}

/*
function: add_state
purpose: to track the number of times a state is queried
*/
function add_state($name, $dataset_name) { 
	$database = Database::getDatabase();
	$query = "insert into count_states (name, dataset_name) values('" . $name . "', '" . $dataset_name . "')";
	$results = $database->query($query);
	//$db->close();
}

/*
function: add_variable
purpose: to track the number of times a variable is queried
*/
function add_variable($name, $dataset_name) { 
	$database = Database::getDatabase();
	$results = $database->query("insert into count_variables (name, dataset_name) values('" . $name . "', '" . $dataset_name . "')");
	//$db->close();
}


}
?>
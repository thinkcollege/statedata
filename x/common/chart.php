<?php   
/*
class: chart
purpose: helper functions to the CordaEmbedder 
*/
class chart extends CordaEmbedder{

/* holds the data for building the chart */
var $chartData	= array();	// 1-dimensional array

/*
function: build_pcScript
purpose: to build an array of the values in a form that we can use in the CordaEmedder
*/
function build_pcScript($sql, $cols){
	$database = Database::getDatabase();
	
	$results = $database->query($sql);
	
	for ($result=0;$result<$database->num_rows($results);$result++){
		$cols_counter = 0;
		//the first column in the query is always the year
		$this->chartData[0]= $this->chartData[0] . $database->fetch_result($results,$result,"YEAR");
		
		//for each column in the query, starting at the second one, since the year is in the first one
		for ($cols_counter = 1 ; $cols_counter < $cols + 1 ; $cols_counter++){
			//save the data
			
			$this->chartData[$cols_counter]= $this->chartData[$cols_counter] . $database->fetch_result($results,$result, $cols_counter);
			
			//if there is another record, add the ;
			if ($result + 1 < $database->num_rows($results)) {
				$this->chartData[$cols_counter]= $this->chartData[$cols_counter] . ";";
			}
		}
		
		//if there is another record, add the ;
		if ($result + 1 < $database->num_rows($results)) {
			$this->chartData[0] = $this->chartData[0] . ";";
		}
	}
	$database->close();
}

/*
function: getData
purpose: returns the chartData array
*/
function getData(){

	return $this->chartData;

}



}
?>
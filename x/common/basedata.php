<?php    
/*
class: basedata
purpose: support basedata
*/
class basedata extends mre_base{

function number_reporting($activity_id) {
	$database = Database::getDatabase();
	$functions	= new functions;
	$abbrv = $functions->get_activity_abbrv($activity_id);

	$results = $database->query("select distinct State from `". $this->database_table_prefix . $abbrv ,"` ");
	return ($database->num_rows($results) - 1); //remove the summary record from total
}

function html_format($data) { 
	$html = "<table class='dataGrid'><thead><tr>";
	
	foreach ($data["headings"] as $heading) {
		$html .= "<th>$heading</th>";
	}
	$html .= "</tr></thead><tbody>";
	
	foreach ($data["data"] as $row) {
		$html .= "<tr>";
		$colOne = true;
		foreach ($row as $col) {
			$html .= "<td";
			if ($colOne == false) {
				$html .= " class='data' ";
			}
			$html .= ">$col</td>";
			$colOne = false;
		}
		$html .= "</tr>";		
	}
	$html .= "</tbody></table>";
	
	return($html); 
}


}
?>
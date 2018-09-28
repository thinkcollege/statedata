<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('print_template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - State Trends');
$template->add_region('heading','State Trends');
$template->add_region('sidebar','<?php 
									$area="trends" ;
									$show_flash_link=0;
									$file_path = "../../";
									?>');
$template->add_region('content','
	<?php
		$functions=new functions;

		$state = $_REQUEST["state"];
		$table = $_REQUEST["agency"];
		$chartType = $_REQUEST["chartType"];
		$variable1 = $_REQUEST["variable1"];
		$variable2 = $_REQUEST["variable2"];
		$var_legend1 =  $functions->get_legend_name($table, $variable1 );
		$var_legend2 =  $functions->get_legend_name($table, $variable2 );
		

		$query = "Select YEAR";
		$nation_query = "Select YEAR";
		$cols = 0;
		$counter = 0 ;
		if ($variable1 != "0") {
			$cols++;

			$query = $query . ", `" . $variable1 . "`";
			$nation_query = $nation_query . ", avg(`" . $variable1 . "`)";
			$var_list = $var_legend1 ;
		}
		if ($variable2 != "0") {
			$cols++;
			$query = $query . ", `" . $variable2 . "`";
			$nation_query = $nation_query . ", avg(`" . $variable2 . "`)";
			
			if ($variable1 != "0") {
				$var_list = $var_list . "&#xa;and " . $var_legend2;
			}else {
				$var_list = $var_legend2;
			}
		}
		if ($cols == 2) {
			$axis_note = "The first variable listed is read on the left (y) axis, the second variable is on the right (yy) axis.";
		} else {
			$axis_note = "";
		}
		$nation_query = $nation_query ." from `". $table . "`  group by year order by year";
		$query = $query ." from `". $table . "` where state=\'" .$state. "\' order by year";
		//echo $query;
		
		
		$database = Database::getDatabase();
		$nation_results = $database->query($nation_query);
		$state_results = $database->query($query);
		
		$state_counter = 0;
		$chartStateData = array();	
		$chartNationData = array();	
		
		for ($result=0; $result<$database->num_rows($nation_results); $result++){
			$cols_counter = 0;
			//the first column in the query is always the year

			$current_year = $database->fetch_result($nation_results,$result,"YEAR");
			if ($state_counter < $database->num_rows($state_results)) {
				$current_state_year = $database->fetch_result($state_results, $state_counter,"YEAR");
			} else {
				$current_state_year = "";
			}

			$chartNationData[0]= $chartNationData[0] . $current_year;
			$chartStateData[0]= $chartStateData[0] . $current_year;
			
			//for each column in the query, starting at the second one, since the year is in the first one
			for ($cols_counter = 1 ; $cols_counter < $cols + 1 ; $cols_counter++){
				//save the data
							
				if ($database->fetch_result($nation_results,$result, $cols_counter) == 0) {
					
				} else {
					$chartNationData[$cols_counter]= $chartNationData[$cols_counter] . $database->fetch_result($nation_results,$result, $cols_counter);
				}
							
				if ($current_year != $current_state_year) {
					//$chartStateData[$cols_counter]= $chartStateData[$cols_counter] . "0";
					$chartStateData[$cols_counter]= $chartStateData[$cols_counter] ;
					//$chartNationData[$cols_counter]= $chartNationData[$cols_counter] . $database->fetch_result($nation_results,$result, $cols_counter);
				} else {
					if ($current_state_year) {
						if ($database->fetch_result($state_results,$state_counter, $cols_counter) == 0) {
							//$chartStateData[$cols_counter]= $chartStateData[$cols_counter] . $database->fetch_result($state_results,$state_counter, $cols_counter);
						}else {
							$chartStateData[$cols_counter]= $chartStateData[$cols_counter] . $database->fetch_result($state_results,$state_counter, $cols_counter);
						}
					} else {
						//$chartStateData[$cols_counter]= $chartStateData[$cols_counter] ."0";
						$chartStateData[$cols_counter]= $chartStateData[$cols_counter] ;
					}
				}

				//if there is another record, add the ;
				if ($result + 1 < $database->num_rows($nation_results)) {
					$chartNationData[$cols_counter]= $chartNationData[$cols_counter] . ";";
					$chartStateData[$cols_counter]= $chartStateData[$cols_counter] . ";";
				}
			}
			
			//if there is another record, add the ; for the year
			if ($result + 1 < $database->num_rows($nation_results)) {
				$chartNationData[0] = $chartNationData[0] . ";";
				$chartStateData[0] = $chartStateData[0] . ";";
			}
			
			if ($current_year == $current_state_year) {
				//if we saved one, go to the next record, if not, stay with this record.
				$state_counter++;
			}
		}
		
		$mychart =new chart;
		$pcScript = "graph.setcategories(".$chartNationData[0].")";
		$total_variables = 0;
		if ($variable1 != "0") {
			$pcScript = $pcScript ."graph.setseries(\'State:".$var_legend1 ."\';".$chartStateData[1].")";
			$pcScript = $pcScript ."graph.setseries(\'Nation:".$var_legend1 ."\';".$chartNationData[1].")";
			$total_variables = $total_variables + 1;
			$variable1_short_name = $functions->get_short_name($table,$variable1) ;
		}
		if ($variable2 != "0") {
			$pcScript = $pcScript ."graph.setseries(\'State:".$var_legend2 ."\';".$chartStateData[2].")";
			$pcScript = $pcScript ."graph.setseries(\'Nation:".$var_legend2 ."\';".$chartNationData[2].")";
			$total_variables = $total_variables + 1;
			$variable2_short_name = $functions->get_short_name($table,$variable2) ;
		}
		
		
		$title = "main.AddPCXML(<Textbox Name=\'title\' Top=\'0\' Left=\'0\' Width=\'750\' Height=\'24\'><Properties AutoWidth=\'False\' HJustification=\'Center\' LeftMargin=\'5\' RightMargin=\'5\' FillColor=\'#0bacbd\' Font=\'Size:14; Style:Bold Italic; Color:White;\'/>
				<Text>State Trends: ". $functions->getAgency($table) . "&#xa;State:" . $functions->translateState($state) ."&#xa;$var_list</Text>
				</Textbox>)";
		
		
	 	$pcScript =  $pcScript .$title;
		
		
		//add axis
		if ($total_variables == 1) {
			$axis1 = "main.AddPCXML(<Textbox Name=\'axis1\' Top=\'120\' Left=\'10\' Width=\'75\' Height=\'70\'>
			<Properties BorderType=\'None\' AutoWidth=\'True\' HJustification=\'Center\' LeftMargin=\'5\' RightMargin=\'5\' FillColor=\'#ffffff\' Font=\'Size:10; Style:Bold ; Color:black;\'/>
			<Text>$variable1_short_name</Text></Textbox>)";
			$pcScript = $pcScript . $axis1;
		} else {
			$axis1 = "main.AddPCXML(<Textbox Name=\'axis1\' Top=\'120\' Left=\'20\' Width=\'75\' Height=\'70\'>
			<Properties BorderType=\'None\' AutoWidth=\'True\' HJustification=\'Center\' LeftMargin=\'5\' RightMargin=\'5\' FillColor=\'#ffffff\' Font=\'Size:10; Style:Bold ; Color:black;\'/>
			<Text>$variable1_short_name</Text></Textbox>)";
			$pcScript = $pcScript . $axis1;
			
			$axis2 = "main.AddPCXML(<Textbox Name=\'axis2\' Top=\'120\' Left=\'625\' Width=\'75\' Height=\'70\'>
			<Properties BorderType=\'None\' AutoWidth=\'True\' HJustification=\'Center\' LeftMargin=\'5\' RightMargin=\'5\' FillColor=\'#ffffff\' Font=\'Size:10; Style:Bold ; Color:black;\'/>
			<Text>$variable2_short_name</Text></Textbox>)";
			$pcScript = $pcScript . $axis2;
		}
		
		//echo "<br>" . $pcScript ;
		//$pcScript = "graph.setcategories(1993; 1994; 1995)graph.setseries(value1;54;75;85)graph.setseries(value2;92;60;70)";

		//$mychart->externalServerAddress = "http://santiago:2001";
		//$mychart->internalCommPortAddress = "http://santiago:2002";

		$mychart->externalServerAddress = "http://72.3.249.15:2001";
		$mychart->internalCommPortAddress = "http://72.3.249.15:2002";
		if ($total_variables == 1) {
			$mychart->appearanceFile = "apfiles/trends_one_variable.pcxml";
			$mychart->width = 750;
		} else {
			$mychart->appearanceFile = "apfiles/trends.pcxml";
			$mychart->width = 750;
		}
		$mychart->userAgent = $HTTP_SERVER_VARS[\'HTTP_USER_AGENT\'];
		
		$mychart->height = 430;
		$mychart->returnDescriptiveLink = true;
		$mychart->language = "EN";
		$mychart->pcScript = $pcScript;
		//echo "<br>" . $pcScript ;
		$mychart->imageType = "JPG";
		echo $mychart->getEmbeddingHTML(); 
		echo "<br> $axis_note";
	?>
        <br>
');
include("header.php");
$template->make_template(); 
include("footer.php");
?>

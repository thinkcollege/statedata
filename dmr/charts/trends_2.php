<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$print = $_REQUEST["print"];
if ($print == 1) {
	$template->define_file('print_template.php');
} else {
	$print = 0;
	$template->define_file('dmr_template.php');
}
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - State Trends');
$template->add_region('heading','State Trends');
if ($print == 1) {
	$template->add_region('sidebar','<?php 
									$area="trends" ;
									$show_flash_link=0;
									$file_path = "../../";
									?>');
} else {
	$template->add_region('sidebar','<?php 
									$area="trends" ;
									$show_flash_link=1;
									$file_path = "../../";
									?>');
}

$template->add_region('content','
	<?php
		$print = $_REQUEST["print"];
		if ($print != 1) {
			$print = 0;
		}
		$functions=new functions;
		if ($print == 0) {
			$tracker=new tracker;
		}
		$state = $_REQUEST["state"];
		$table = $_REQUEST["agency"];
		if ($print == 0) {
			$dataset_id = $tracker->add_dataset($table);
		}
		$chartType = $_REQUEST["chartType"];
		$variable1 = $_REQUEST["variable1"];
		$variable2 = $_REQUEST["variable2"];
		$var_legend1 =  $functions->get_legend_name($table, $variable1 );
		$var_legend2 =  $functions->get_legend_name($table, $variable2 );
		if ($print == 0) {
			$tracker->add_state($state, $dataset_id);
		}
		$query = "Select YEAR";
		$nation_query = "Select YEAR";
		$cols = 0;
		$counter = 0 ;
		if ($variable1 != "0") {
			$cols++;

			$query = $query . ", `" . $variable1 . "`";
			$nation_query = $nation_query . ", avg(`" . $variable1 . "`)";
			$var_list = $var_legend1 ;
			if ($print == 0) {
				$tracker->add_variable($variable1, $dataset_id);
			}
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
			if ($print == 0) {
				$tracker->add_variable($variable2, $dataset_id);
			}
		}
		if ($cols == 2) {
			$axis_note = "The first variable listed is read on the left (y) axis, the second variable is on the right (yy) axis.";
		} else {
			$axis_note = "";
		}
		
		$colors = array();
		$colors[] = "9900CC"; //purple
		$colors[] = "FF9900"; //orange
		$colors[] = "993333"; //brown
		
		$nation_query = $nation_query ." from `". $table . "` where ";
		if ($variable1 != "0") {
			$nation_query = $nation_query . "`" . $variable1 . "` != -1 ";
		}
		if ($variable2 != "0") {
			if ($variable1 != "0") {
				$nation_query = $nation_query . " and ";
			}
			$nation_query = $nation_query . "`" . $variable2 . "` != -1 ";
		}
		
		$nation_query = $nation_query . " group by year order by year";
		$query = $query ." from `". $table . "` where state=\'" .$state. "\' order by year";
		//echo $nation_query  . "<br>";
		//echo $query . "<br>";
		
		
		$database = Database::getDatabase();
		$nation_results = $database->query($nation_query);
		$state_results = $database->query($query);
		
		$state_counter = 0;
		$chartStateData = array();	
		$chartNationData = array();	
		$year_counter = 0;
		$first_time = 1;
		for ($result=0; $result<$database->num_rows($nation_results); $result++){
			$cols_counter = 0;
			//the first column in the query is always the year

			$current_year = $database->fetch_result($nation_results,$result,"YEAR");
			if ($state_counter < $database->num_rows($state_results)) {
				$current_state_year = $database->fetch_result($state_results, $state_counter,"YEAR");
			} else {
				$current_state_year = "";
			}

			if ($first_time == 1) {
				$first_time = 0;
				$int_state_year = intval(0+$current_state_year );
				$int_current_year = intval(0+$current_year );
				//echo "<b>" . $int_state_year  . ", ";
				//echo  $int_current_year  . "</b>";
				while (($int_state_year  + $year_counter) < $int_current_year ) {
					//echo $year_counter;
					$year_counter++;
				}
				$year_counter = $year_counter -1;
				if ($year_counter  == -1) {
					$year_counter  =0;
				}
				$state_counter = $year_counter;
				$current_state_year = intval(0+$current_state_year ) + $year_counter;
			}

			$chartNationData[0]= $chartNationData[0] . $current_year;
			$chartStateData[0]= $chartStateData[0] . $current_year;
			
			//for each column in the query, starting at the second one, since the year is in the first one
			for ($cols_counter = 1 ; $cols_counter < $cols + 1 ; $cols_counter++){
				//save the data
							
				if ($database->fetch_result($nation_results,$result, $cols_counter) == 0) {
					
				} else {
					//marcos added to take care of -1 data
					if ($database->fetch_result($nation_results,$result, $cols_counter) != -1) {
						$chartNationData[$cols_counter]= $chartNationData[$cols_counter] . $database->fetch_result($nation_results,$result, $cols_counter);
					}
				}
				//echo $current_year ." " . $current_state_year . "<br>";
				if ($current_year != $current_state_year) {
					//$chartStateData[$cols_counter]= $chartStateData[$cols_counter] . "0";
					$chartStateData[$cols_counter]= $chartStateData[$cols_counter] ;
					//$chartNationData[$cols_counter]= $chartNationData[$cols_counter] . $database->fetch_result($nation_results,$result, $cols_counter);
				} else {
					if ($current_state_year) {
						if ($database->fetch_result($state_results,$state_counter, $cols_counter) == 0) {
							//$chartStateData[$cols_counter]= $chartStateData[$cols_counter] . $database->fetch_result($state_results,$state_counter, $cols_counter);
						}else {
						//marcos added to take care of -1 data
							if ($database->fetch_result($state_results,$state_counter, $cols_counter) != -1) {
								$chartStateData[$cols_counter]= $chartStateData[$cols_counter] . $database->fetch_result($state_results,$state_counter, $cols_counter);
							}
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
			$pcScript = $pcScript ."graph.setseries((CLR_".$colors[0].")\'State:".$var_legend1 ."\';".$chartStateData[1].")";
			$pcScript = $pcScript ."graph.setseries((CLR_009933)\'National mean:".$var_legend1 ."\';".$chartNationData[1].")";
			$total_variables = $total_variables + 1;
			$variable1_short_name = $functions->get_short_name($table,$variable1) ;
		}
		if ($variable2 != "0") {
			$pcScript = $pcScript ."graph.setseries((CLR_".$colors[1].")\'State:".$var_legend2 ."\';".$chartStateData[2].")";
			$pcScript = $pcScript ."graph.setseries((CLR_009933)\'National mean:".$var_legend2 ."\';".$chartNationData[2].")";
			$total_variables = $total_variables + 1;
			$variable2_short_name = $functions->get_short_name($table,$variable2) ;
			$pcScript = $pcScript ."graph.setSeriesStyle(1, 2, 1, false, none, dotted)";
			$pcScript = $pcScript ."graph.setSeriesStyle(2, 2, 1, false, none, dotted)";
		}

		
		$title = "main.AddPCXML(<Textbox Name=\'title\' Top=\'0\' Left=\'0\' Width=\'615\' Height=\'24\'><Properties AutoWidth=\'False\' HJustification=\'Center\' LeftMargin=\'5\' RightMargin=\'5\' FillColor=\'#BACBDB\' Font=\'Size:14; Style:Bold Italic; Color:#5C656A;\'/>
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
			$axis1 = "main.AddPCXML(<Textbox Name=\'axis1\' Top=\'120\' Left=\'5\' Width=\'30\' Height=\'70\'>
			<Properties BorderType=\'None\' AutoWidth=\'True\' HJustification=\'Center\' LeftMargin=\'5\' RightMargin=\'5\' FillColor=\'#ffffff\' Font=\'Size:10; Style:Bold ; Color:black;\'/>
			<Text>$variable1_short_name</Text></Textbox>)";
			$pcScript = $pcScript . $axis1;
			
			$axis2 = "main.AddPCXML(<Textbox Name=\'axis2\' Top=\'120\' Left=\'545\' Width=\'30\' Height=\'70\'>
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
		//$mychart->externalServerAddress = "http://72.3.249.15:2001";
		//$mychart->internalCommPortAddress = "http://72.3.249.15:2002";

		
		if ($total_variables == 1) {
			$mychart->appearanceFile = "apfiles/trends_one_variable.pcxml";
			$mychart->width = 616;
		} else {
			$mychart->appearanceFile = "apfiles/trends.pcxml";
			$mychart->width = 616;
		}
		$mychart->userAgent = $HTTP_SERVER_VARS[\'HTTP_USER_AGENT\'];
		
		$mychart->height = 430;
		$mychart->returnDescriptiveLink = true;
		$mychart->language = "EN";
		$mychart->pcScript = $pcScript;
		//echo "<br>" . $pcScript ;
		echo "<!--" . $pcScript . "-->";
		if ($print == 0) {
			$mychart->imageType = "FLASH";
		} else {
			$mychart->imageType = "JPG";
		}
		
		$state = $_REQUEST["state"];
		$table = $_REQUEST["agency"];
		if ($print == 0) {
			$dataset_id = $tracker->add_dataset($table);
		}
		
		$filename = $state ."_". $table ."_". $variable1 ."_". variable2;
		//maybe add back in later
		echo $mychart->getEmbeddingHTML(); 
		if ($print == 0) {
			echo "<br><a target=\'_new\'  href=\'trends_2.php?print=1&state=$state&agency=$table&chartType=$chartType&variable1=$variable1&variable2=$variable2\' >Printer-Friendly Format</a>";
		}
		echo "<br> $axis_note";
		echo "<br>Blank spaces that may appear on the chart or values of -1 indicate that data is not available for that year";
	?>
        <br>
');
include("header.php");
$template->make_template(); 
include("footer.php");
?>

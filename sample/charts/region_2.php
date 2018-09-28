<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$print = $_REQUEST["print"];
if ($print == 1) {
	$template->define_file('sample_print_template.php');
} else {
	$print = 0;
	$template->define_file('sample_template.php');
}
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Summary by REgion');
$template->add_region('heading','Summary by Region');
if ($print == 1) {
	$template->add_region('sidebar','<?php 
									$area="region" ;
									$show_flash_link=0;
									$file_path = "../../";
									?>');
} else {
	$template->add_region('sidebar','<?php 
									$area="region" ;
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
		$sample=new sample;
		$variable = $_REQUEST["variable"];


		$arVariableValues = $sample->getRegionVariableArray ($variable);
		$arColumnNames = $sample->getRegionColumnNamesArray ($variable);
		$axis = $sample->getRegionAxisLabel($variable);
		$legend = $sample->getRegionLegendName($variable);

		
		$colors = array();
		$colors[] = "9900CC"; //purple
		$colors[] = "FF9900"; //orange
		$colors[] = "993333"; //brown
		
		$database = Database::getDatabase();
		
		
		for($i=0; $i<count($arColumnNames); $i++) {
			$categories = $categories  . $arColumnNames[$i] . ";";
		}
		for($i=0; $i<count($arVariableValues); $i++) {
			$values = $values  . $arVariableValues[$i] . ";";
		}
		
		
		$mychart =new chart;
		$pcScript = "graph.setcategories(".$categories.")";
		$total_variables = 0;
		$pcScript = $pcScript ."graph.setseries((CLR_".$colors[0].")\'".$legend ."\';".$values.")";

		
		$title = "main.AddPCXML(<Textbox Name=\'title\' Top=\'0\' Left=\'0\' Width=\'615\' Height=\'24\'><Properties AutoWidth=\'False\' HJustification=\'Center\' LeftMargin=\'5\' RightMargin=\'5\' FillColor=\'#BACBDB\' Font=\'Size:14; Style:Bold Italic; Color:#5C656A;\'/>
				<Text>". $legend  ."</Text>
				</Textbox>)";
		
		
	 	$pcScript =  $pcScript .$title;
		
		
		//add axis
		$axis = "main.AddPCXML(<Textbox Name=\'axis1\' Top=\'120\' Left=\'10\' Width=\'75\' Height=\'70\'>
			<Properties BorderType=\'None\' AutoWidth=\'True\' HJustification=\'Center\' LeftMargin=\'5\' RightMargin=\'5\' FillColor=\'#ffffff\' Font=\'Size:10; Style:Bold ; Color:black;\'/>
			<Text>$axis</Text></Textbox>)";
		$pcScript = $pcScript . $axis;
		
		$categoryLabelFont = "graph.AddPCXML(<CategoryScale LimitLabelLength=\'False\' MaxLengthRotatedText=\'10\' StaggerLabels=\'False\' RotateLabels=\'-45\' LowOuterLine=\'Color:#7f7f7f;\'  HighOuterLine=\'Color:#7f7f7f;\'  MajorTick=\'Visible:False;\'  MinorTick=\'Size:Large;\'  MajorGrid=\'Color:#7f7f7f;\'  Font=\'Size:12; Style:Bold Italic; Color:#3366ff;\' MinorFont=\'Size:10;\'/>)";
		$pcScript = $pcScript . $categoryLabelFont;
		//echo "<br>" . $pcScript ."<br>";
		//$pcScript = "graph.setcategories(1993; 1994; 1995)graph.setseries(value1;54;75;85)graph.setseries(value2;92;60;70)";

		//$mychart->externalServerAddress = "http://santiago:2001";
		//$mychart->internalCommPortAddress = "http://santiago:2002";

		$mychart->externalServerAddress = "http://72.3.249.15:2001";
		$mychart->internalCommPortAddress = "http://72.3.249.15:2002";
		//$mychart->externalServerAddress = "http://72.3.249.15:2001";
		//$mychart->internalCommPortAddress = "http://72.3.249.15:2002";

		
		$mychart->appearanceFile = "apfiles/dmr_activity.pcxml";
		$mychart->width = 616;
		$mychart->height = 430;
		
		$mychart->userAgent = $HTTP_SERVER_VARS[\'HTTP_USER_AGENT\'];
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
		
		
		//maybe add back in later		
		echo $mychart->getEmbeddingHTML(); 
		if ($print == 0) {
			echo "<br><a target=\'_new\'  href=\'region_2.php?print=1&variable=$variable\' >Printer-Friendly Format</a>";
		}
		echo "<br> $axis_note";
		//echo "<br>Blank spaces that may appear on the chart or values of -1 indicate that data is not available for that year";
	?>
        <br>
');
include("header.php");
$template->make_template(); 
include("footer.php");
?>

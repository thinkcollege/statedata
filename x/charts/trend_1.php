<?php 

ini_set("include_path",".:../");
include("common/classes.php");
$mre_base=new mre_base;
$title =   $mre_base->mre_base_sitename . " - Trend Chart";
$area = "trend"; 
$show_flash_link = 0;
$functions = new functions;

$content = "<form id=\"trendForm\" method=\"get\" action=\"./trend_2.php\">";

$content .= "<p><label for='reporttype'>Select a summary report:</label>  <br/>
				<select id='reporttype' name='reporttype'>
					<option value='single'>Single Program Trend Chart</option>
					<!--<option value='multi'>Multi Program Trend Comparison</option>-->
					<option value='oneyear'>Multi Program One Year Comparison</option>
				</select><input type='hidden' name='year' id='year' /></p>";
$content .= "<p id='yearPlaceholderRadio' style='display:none'>Select a year for your report:  <br/>" . $functions->get_table_year('dd','radio') . " </p>";
$content .= "<p id='yearPlaceholderCheckbox' style='display:none'>Select the years for your report:  <br/>" . $functions->get_table_year('dd','checkbox') ." </p>";


$content .= $functions->get_activity_hierarchy();

$content .= "<p id='statePlaceholder' style='display:none'><label id='statesLabel' for='states'>Select a program for your report:</label>  <br/>
				<select id='states' multiple='multiple' size='10' name='states' ></select></p><input type='hidden' name='selectedstates' id='selectedstates' /></p>";

$content .= '<p><input type="submit" class="submit" value=" "></p>

</form>
<br>

<script type="text/javascript">  
$(function() { 
	init_trend();
	}
);
</script>
';							
									
$heading = 'Trend chart';
//write page
include("header.php");
echo $content;
include("footer.php");
?>
<?php 

ini_set("include_path",".:../");
include("common/classes.php");
$mre_base=new mre_base;
$title =   $mre_base->mre_base_sitename . " - Activity Summary Report";
$area = "activity"; 
$show_flash_link = 0;
$functions = new functions;

$content = "<form id=\"activityForm\" method=\"get\" action=\"./activity_summary_2.php\" >";

$content .= "<p><label for='reporttype'>Select a summary report:</label>  <br/>
				<select id='reporttype' name='reporttype'>
					<option value='program'>Program Report</option>
					<option value='trend'>Single Program Trend Report</option>
				</select></p>";

$content .= "<p><label for='activity'>Select Activity:</label> <br/>" . $functions->get_activities() . '</p>';

$content .= "<p id='statePlaceholder' style='display:none'><label id='statesLabel'  for='states'>Select up to 3 programs for your report:
				(To select more than one item, Ctrl-Click or Cmd-Click on Mac)</label>  <br/>
				<select id='states' multiple='multiple' size='10' name='states' ></select></p><input type='hidden' name='selectedstates' id='selectedstates' />";
				
$content .= '<p><input type="submit" class="submit" value=" " onsubmit></p>

</form>
<br>

<script type="text/javascript">  
$(function() { 
	init_activity_summary();
	get_states($("#activity").val());
	
	}
);
</script>
';							
									
$heading = 'Activity Summary report';
//write page
include("header.php");
echo $content;
include("footer.php");
?>
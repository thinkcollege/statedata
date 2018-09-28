<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('dmr_template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - State Trends');
$template->add_region('sidebar','<?php 
									$area="trends" ;
									$show_flash_link=0;
									$file_path = "../../";
									?>');
$template->add_region('heading','State Trends');
$template->add_region('content','
<P>
	<?php
		if ($_POST["state"] == "" && $_POST["agency"] == "") {
	        echo "<form name=\"form1\" method=\"POST\" action=\"trends_1.php\">";
		} else {
			echo "<form name=\"form1\" method=\"POST\" action=\"trends_2.php\">";
		}
         
		 
	  	$functions=new functions;
		if ($_POST["state"] == "") {
			echo "Select a state: " . $functions->getStates("state");
		} else {
			echo "<b>Current state: " . $functions->translateState($_POST["state"]) . "</b>";
			echo "<input type=hidden name=state value=". $_POST["state"] . ">";
		}
	
		echo "<P>";

	  	if ($_POST["agency"] == "") {
			echo "Select agency: " . $functions->get_agency_tables();
		} else {
			echo "<b>Current agency: " . $functions->getAgency($_POST["agency"]). "</b>";
			echo "<input type=hidden name=agency value=". $_POST["agency"] . ">";
		}
		if ($_POST["state"] == "" && $_POST["agency"] == "") {
		  	echo "<P><a href=\"\" onclick=\"validateState(document.form1); return false;\">";
			echo "<img src=\"../images/buttons/submit.jpg\" border=0></a>";
		} else {
			echo "<P>Select up to two variables.";
			
			//echo "<P>Variable 1: " . $functions->get_table_columns($_POST["agency"], "variable1");
			
			//echo "<P>Variable 2: " . $functions->get_table_columns($_POST["agency"], "variable2");
			
			echo "<P><a href=\"\" onclick=\"validatechart(document.form1); return false;\">";
			echo "<img src=\"../images/buttons/submit.jpg\" border=0></a>";
			
			echo $functions->get_table_columns_as_checkboxes($_POST["agency"],2);
			echo "<input type=hidden name=variable1 value=0><input type=hidden name=variable2 value=0>";
			/*echo "<P>Select chart type: 
						<select name=chartType>
								<option value=bar>Bar</option>
								<option value=line>Line</option>
						</select>";
			*/
			echo "<input type=hidden name=chartType value=bar>";
			echo "<P><a href=\"\" onclick=\"validatechart(document.form1); return false;\">";
			echo "<img src=\"../images/buttons/submit.jpg\" border=0></a>";
			
		}
	?>
		<script>
			function validateState(frm) {
				strState = getSelectValue("form1","state");
				if (strState == "0") {
					alert("You must select a state before going ot the next step.")
				} else
					frm.submit();
			}
			
			function validatechart(frm) {
				//strVariable1 = getSelectValue("form1","variable1");
				//strVariable2 = getSelectValue("form1","variable2");
				strVariable1 = frm.variable1.value;
				strVariable2 = frm.variable2.value;
				if ((strVariable1 == 0 && strVariable2 == 0) || (strVariable1 == "0" && strVariable2 == "0") || (strVariable1 == "" && strVariable2 == "")) {
					alert("Please select at least one variable to view.")
				} else {
					frm.submit()
				}
			}
			function on_keydown_form(formInfo,e,action)
			{
				var keyCode = document.layers ? e.which : e.keyCode;
				if (keyCode == 13)
				{
					<? if ($_POST["state"] == "" && $_POST["agency"] == "") { ?>
					  	validateState(document.form1)
					<? } else { ?>
						validatechart(document.form1)
					<? } ?>
					return false;
				}
			
				return true;
			}
		</script>
        </form>
        
        <br>
');
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>

<?php 
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - State Comparison');
$template->add_region('heading','State Comparison');
$template->add_region('sidebar','<?php 
									$area="comparison" ;
									$show_flash_link=0;
									?>');
$template->add_region('content','
<P>
	<?php
		if ($_POST["state"] == "" && $_POST["agency"] == "") {
	        echo "<form name=\"form1\" method=\"POST\" action=\"comparison_1.php\">";
		} else {
			echo "<form name=\"form1\" method=\"POST\" action=\"comparison_2.php\">";
		}
         

	  	$functions=new functions;

		if ( $_POST["state"] == "" ) {
			echo "Select states to compare: <br> " . $functions->getStates("state1");
			echo "<br> " . $functions->getStates("state2");
			echo "<br> " . $functions->getStates("state3");
		} else {
			echo "<b>Current states:</b><br>";
			if (!empty($_POST["state1"])) {
			 	echo $functions->translateState($_POST["state1"]) . "<br>";
			 	echo "<input type=hidden name=state1 value=" . $_POST["state1"] . ">";
			}
			if (!empty($_POST["state2"])) {
				echo $functions->translateState($_POST["state2"]) . "<br>";
				echo "<input type=hidden name=state2 value=" . $_POST["state2"] . ">";
			}
			if (!empty($_POST["state3"])) {
				 echo $functions->translateState($_POST["state3"]) . "<br>";
				 echo "<input type=hidden name=state3 value=" . $_POST["state3"] . ">";
			}
		}
	
		
		
		echo "<P>";

	  	if ($_POST["agency"] == "") {
			echo "Select agency: " . $functions->get_agency_tables();
		} else {
			
			echo "<b>Current agency:</b><br> " . $functions->getAgency($_POST["agency"]). "</b>";
			echo "<input type=hidden name=agency value=\'" . $_POST["agency"] . "\'>";
		}
		if ($_POST["state"] == "" && $_POST["agency"] == "") {
		  	echo "<P><a href=\"\" onclick=\"validateState(document.form1); return false;\">";
			echo "<img src=\"../images/buttons/submit.jpg\" border=0></a>";
			echo "<input type=hidden name=state value=\"0\">";
		} else {
			echo "<P>Select a variable.";
			echo "<P><a href=\"\" onclick=\"validatechart(document.form1); return false;\">";
			echo "<img src=\"../images/buttons/submit.jpg\" border=0></a>";
			
			//echo "<br>" . $functions->get_table_columns($_POST["agency"], "variable1");
			echo $functions->get_table_columns_as_checkboxes($_POST["agency"],1);
			echo "<input type=hidden name=variable1 value=0>";


			echo "<P><a href=\"\" onclick=\"validatechart(document.form1); return false;\">";
			echo "<img src=\"../images/buttons/submit.jpg\" border=0></a>";
		}
	?>
		<script>
			function validateState(frm) {
				strState1 = getSelectValue("form1","state1");
				strState2 = getSelectValue("form1","state2");
				strState3 = getSelectValue("form1","state3");
				if (strState1 != "0" || strState2 != "0" || strState3 != "0") {
					frm.state.value = "1";
					frm.submit()
				} else {
					alert("Please select a state.")
				}
			}
			
			function validatechart(frm) {
				//strVariable1 = getSelectValue("form1","variable1");
				strVariable1 = frm.variable1.value;
				
				if ((strVariable1 == 0 ) || (strVariable1 == "0" ) ) {
					alert("Please select a variable to view.")
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
					validateState(formInfo);
				<? } else { ?>
					validatechart (formInfo)
				<? }?>
					return false;
				}
			
				return true;
			}
		</script>
        </form>
        
        <br>
');
include("header.php");
$template->make_template(); 
include("footer.php");
?>

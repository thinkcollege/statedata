<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('sample_template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Summary by Activity');
$template->add_region('sidebar','<?php 
									$area="activity" ;
									$show_flash_link=0;
									$file_path = "../../";
									?>');
$template->add_region('heading','Summary by Activity');
$template->add_region('content','
<P>
	<?php
		if ($_POST["region"] == "" && $_POST["provider"] == "") {
	        echo "<form name=\"form1\" method=\"POST\" action=\"activity_1.php\">";
		} else {
			echo "<form name=\"form1\" method=\"POST\" action=\"activity_2.php\">";
		}
         
		$functions=new functions;
		$sample = new sample;
		
		if ($_POST["region"] == "" ) {
		  	echo "<P><a href=\"\" onclick=\"sample_validateActivity(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";
		} else {
			
			echo "<P><a href=\"\" onclick=\"sample_validatechart(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";
			
		}
		
		if ($_POST["region"] == "") {
			echo "<input type=hidden name=year value=04>";
			echo "<P>Select a region: " . $sample->getRegions("region",1);
		} else {
			echo "<P><b>Current region: " . $_POST["region"] . "</b>";
			echo "<input type=hidden name=year value=". $_POST["year"] . ">";
			echo "<input type=hidden name=region value=\'". $_POST["region"] . "\'>";
			echo "<P>Select provider: " . $sample->getProviders(\'provider\', $_POST["region"], 1);
			echo "<P>Select variable: " . $sample->getActivityVariables();
		}
	
		echo "<P>";


		if ($_POST["region"] == "" ) {
		  	echo "<P><a href=\"\" onclick=\"sample_validateActivity(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";
		} else {
			
			echo "<P><a href=\"\" onclick=\"sample_validatechart(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";
			
		}
	?>
		<script>
			function sample_validateActivity(frm) {
				strRegion = getSelectValue("form1","region");
				if (strRegion == "0") {
					alert("You must select a region before going ot the next step.")
				} else
					frm.submit();
			}
			
			function sample_validatechart(frm) {
				strProvider = getSelectValue("form1","provider");
				strVariable = getRadioValue("form1","variable");
				var msg = "";
				var bSubmit = true;
				if (strVariable == "") {
					msg = msg +  "\nNo variable selected"
					bSubmit = false
				}
				if (strProvider == 0 || strProvider == "0" || strProvider == "") {
					//if ((strProvider == 0 && strVariable == 0) || (strProvider == "0" && strVariable == "0") || (strProvider == "" && strVariable == "")) {
					//alert("Please select a provider and variable.")
					msg = msg + "\nNo provider selected"
					bSubmit = false
				} 
				if (bSubmit == true ) {
					frm.submit()
				} else {
					alert ("The following errors occured:" + msg)
				}
			}
			function on_keydown_form(formInfo,e,action)
			{
				var keyCode = document.layers ? e.which : e.keyCode;
				if (keyCode == 13)
				{
					<? if ($_POST["region"] == "" && $_POST["provider"] == "") { ?>
					  	sample_validateState(document.form1)
					<? } else { ?>
						sample_validatechart(document.form1)
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

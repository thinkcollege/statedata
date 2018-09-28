<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('dmr_template.php');
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
		if ($_POST["region"] == "" && $_POST["provider_id"] == "") {
	        echo "<form name=\"form1\" method=\"POST\" action=\"activity_1.php\">";
		} else {
			echo "<form name=\"form1\" method=\"POST\" action=\"activity_2.php\">";
		}
         
		$functions=new functions;
		$dmr = new dmr;
		
		if ($_POST["region"] == "" ) {
		  	echo "<P><a href=\"\" onclick=\"dmr_validateActivity(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";
		} else {
			
			echo "<P><a href=\"\" onclick=\"dmr_validatechart(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";
			
		}
		
		if ($_POST["region"] == "") {
			echo "<P><label for=\'year\'>Select a year:</label> <select id=\"year\" name=\"year\" onchange=\"dmr_checkYear()\"><option value=\"04\">2004</option><option value=\"05\">2005</option><option value=\"06\">2006</option><option value=\"07\">2007</option><option value=\"08\">2008</option><option value=\"09\">2009</option><option value=\"10\">2010</option></select>";
			echo "<P><label for=\'region\'>Select a region: </label>" . $dmr->getRegions("region",1);
		} else {
			if (substr_count($_POST["region"], "x_") > 0 ) {
				$region = substr($_POST["region"],2);
			} else {
				$region = $_POST["region"];
			}
				
			echo "<P><b>Selected region: " . $region . "</b>";
			echo "<P><b>Selected year: 20" . $_POST["year"] . "</b>";
			echo "<input type=hidden name=year value=". $_POST["year"] . ">";
			echo "<input type=hidden name=region value=\'". $_POST["region"] . "\'>";
			echo "<P><label for=\'provider_id\'>Select Provider: </label>" . $dmr->getProviders(\'provider_id\', $_POST["region"], 1);
			echo "<P>Select Variable: </label>" . $dmr->getActivityVariables();
		}
	
		echo "<P>";


		if ($_POST["region"] == "" ) {
		  	echo "<P><a href=\"\" onclick=\"dmr_validateActivity(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";
		} else {
			
			echo "<P><a href=\"\" onclick=\"dmr_validatechart(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";
			
		}
	?>
		<script>
			function dmr_checkYear() {
			//debugger;
				strYear = getSelectValue("form1","year");
				var sel = document.getElementById("region");
				if (strYear == "09"){
					for (var i =0; i < sel.options.length; ++i) {
						if (sel.options[i].value == "Metro Boston"){
							sel.remove(i);
						}
					}
				} else {
					var elOptNew = document.createElement("option");
					elOptNew.text = "Metro Boston";
					elOptNew.value = "Metro Boston";
					try {
						sel.add(elOptNew, null); // standards compliant; doesnt work in IE
					  }
					  catch(ex) {
						sel.add(elOptNew); // IE only
					  }
				}
			}
			function dmr_validateActivity(frm) {
				strRegion = getSelectValue("form1","region");
				if (strRegion == "0") {
					alert("You must select a region before going ot the next step.")
				} else
					frm.submit();
			}
			
			function dmr_validatechart(frm) {
				strProvider = getSelectValue("form1","provider_id");
				
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
					<? if ($_POST["region"] == "" && $_POST["provider_id"] == "") { ?>
					  	dmr_validateActivity(document.form1)
					<? } else { ?>
						dmr_validatechart(document.form1)
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

<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('dmr_template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Provider Report');
$template->add_region('sidebar','<?php 
									$area="provider" ;
									$show_flash_link=0;
									$file_path = "../../";
									?>');
$template->add_region('heading','Provider Report');
$template->add_region('content','
<P>
	<?php
		echo "<form name=\"form1\" method=\"POST\" action=\"provider_2.php\">";
         
		$functions=new functions;
		$dmr = new dmr;
		
		
		
		echo "<P><label for=\'year\'>Select a year:</label> <select id=\"year\" name=\"year\" onchange=\"dmr_checkYear()\"><option value=\"04\">2004</option><option value=\"05\">2005</option><option value=\"06\">2006</option><option value=\"07\">2007</option><option value=\"08\">2008</option><option value=\"09\">2009</option><option value=\"10\">2010</option></select></p>";
		echo "<P><label for=\'region\'>Select a region:</label> " . $dmr->getRegions("region",1);
		echo "<P><label for=\'report\'>Select Report:</label> ";
		echo "<select name=report id=report>\n";
		echo "<option value=\"number\">Number participating by Activity</option>\n";
		echo "<option value=\"hours\">Hours of Participation by Activity</option>\n";
		echo "<option value=\"wage\">Monthly Wages</option>\n";
		echo "</select>\n";
		

		echo "<P>";



			echo "<P><a href=\"\" onclick=\"dmr_validatechart(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";
			echo "<P>Please note that this report may take a little long to generate.</p>";

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
			function dmr_validatechart(frm) {

				strRegion = getSelectValue("form1","region");
				strReport = getSelectValue("form1","report");
				var msg = "";
				var bSubmit = true;
				if (strRegion == 0 || strRegion == "0" || strRegion == "") {
					//alert("Please select a provider and variable.")
					msg = msg + "\nNo Region selected"
					bSubmit = false
				} 
				if (strReport == "") {
					msg = msg +  "\nNo report selected"
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
					dmr_validatechart(document.form1)
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

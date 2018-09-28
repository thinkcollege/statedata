<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('sample_template.php');
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
		$sample = new sample;
		
		
		echo "<input type=hidden name=year value=04>";
		echo "<P>Select a region: " . $sample->getRegions("region",1);
		echo "<P>Select report: ";
		echo "<select name=report>\n";
		echo "<option value=\"number\">Number participating by activity</option>\n";
		echo "<option value=\"hours\">Hours of participation by activity</option>\n";
		echo "<option value=\"wage\">Monthly wages</option>\n";
		echo "</select>\n";
		echo "<P>";



			echo "<P><a href=\"\" onclick=\"sample_validatechart(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";

	?>
		<script>
			
			function sample_validatechart(frm) {

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
					sample_validatechart(document.form1)
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

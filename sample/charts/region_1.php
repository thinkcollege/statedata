<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('sample_template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Summary by Region');
$template->add_region('sidebar','<?php 
									$area="region" ;
									$show_flash_link=0;
									$file_path = "../../";
									?>');
$template->add_region('heading','Summary by Region');
$template->add_region('content','
<P>
	<?php
		echo "<form name=\"form1\" method=\"POST\" action=\"region_2.php\">";
         
		$functions=new functions;
		$sample = new sample;
		
		echo "<P><a href=\"\" onclick=\"sample_validatechart(document.form1); return false;\">";
		echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";
			
		echo "<input type=hidden name=year value=04>";
		echo "<P>Select Variable: " . $sample->getRegionVariables();

		echo "<P>";



			echo "<P><a href=\"\" onclick=\"sample_validatechart(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";

	?>
		<script>
			
			function sample_validatechart(frm) {
				strVariable = getRadioValue("form1","variable");
				var msg = "";
				var bSubmit = true;
				if (strVariable == "") {
					msg = msg +  "\nNo variable selected"
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

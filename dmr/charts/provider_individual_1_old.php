<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('dmr_template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Provider Report');
$template->add_region('sidebar','<?php 
									$area="providerindividual" ;
									$show_flash_link=0;
									$file_path = "../../";
									?>');
$template->add_region('heading','Provider Report');
$template->add_region('content','
<P>
	<?php
		echo "<form name=\"form1\" method=\"POST\" action=\"provider_individual_2.php\">";
         
		$functions=new functions;
		$dmr = new dmr;
		
		
		echo "<!--input type=hidden name=year value=04 -->";
		echo "<P>Select a year: <select name=\"year\">";
		echo "<option value=\"04\">2004</option>";
		echo "<option value=\"05\">2005</option>";
		echo "</select>";
		echo "<P>Select Provider: " . $dmr->getProviders("provider", "ALL", 0);
		//echo "<P>Select a region: " . $dmr->getRegions("region",0);
		
		echo "<P>";



			echo "<P><a href=\"\" onclick=\"dmr_validatechart(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";

	?>
		<script>
			
			function dmr_validatechart(frm) {

				//strRegion = getSelectValue("form1","region");
				strRegion = "ALL";
				strProvider = getSelectValue("form1","provider");
				strYear = getSelectValue("form1","year");
				var msg = "";
				var bSubmit = true;
				//if (strRegion == 0 || strRegion == "0" || strRegion == "") {
					//alert("Please select a provider and variable.")
				//	msg = msg + "\nNo Region selected"
				//	bSubmit = false
				//} 
				//if (strReport == "") {
				//	msg = msg +  "\nNo report selected"
				//	bSubmit = false
				//}
				if (bSubmit == true ) {
					//frm.submit()
					window.open("provider_individual_2.php?provider=" + strProvider + "&region=" + strRegion + "&year=" + strYear,"Results","width=900,height=600,toolbar=1,menubar=1,resizable=yes,status=0,scrollbars=1");
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

<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('dmr_template.php');
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
		if ($_POST["year"] == "" ) {
	        echo "<form name=\"form1\" method=\"POST\" action=\"region_1.php\">";
		} else {
			echo "<form name=\"form1\" method=\"POST\" action=\"region_2.php\">";
		}
         
		
         
		$functions=new functions;
		$dmr = new dmr;
		
		
		if ($_POST["year"] == "" ) {
		  	echo "<P><label for=\'year\'>Select a year: <select id=year name=year><option value=\"04\">2004</option><option value=\"05\">2005</option><option value=\"06\">2006</option><option value=\"07\">2007</option><option value=\"08\">2008</option><option value=\"09\">2009</option><option value=\"10\">2010</option></select>";
			echo "<P><a href=\"\" onclick=\"dmr_validatechart1(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";
		
		} else {
			echo "<P><a href=\"\" onclick=\"dmr_validatechart2(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";
	
			echo "<P><b>Selected year: 20" . $_POST["year"] . "</b>";
			echo "<input type=hidden name=year value=". $_POST["year"] . ">";
			
			echo "<P>Select Variable: " . $dmr->getRegionVariables($_POST["year"]);
			echo "<P><a href=\"\" onclick=\"dmr_validatechart2(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";
	
		}
		
		echo "<P>";




	?>
		<script>
			
			function dmr_validatechart1(frm) {
				frm.submit()
			}
			function dmr_validatechart2(frm) {
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
			
		</script>
        </form>
        
        <br>
');
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>

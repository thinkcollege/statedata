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
		if ( $_REQUEST["action"] == "showregion") {
			echo "<form name=\"form1\" method=\"POST\" action=\"provider_individual_2_new.php\">";
		} else {
			echo "<form name=\"form1\" method=\"POST\" action=\"provider_individual_1_new.php\">";
        }
		 
		$functions=new functions;
		$dmr = new dmr;
		
		if ( $_REQUEST["action"] != "showregion") {
			echo "<input type=hidden name=action value=showregion>";
		}
		
		if ( $_REQUEST["action"] != "showregion") {
			echo "<P>Select a year: <select name=\"year\">";
			echo "<option value=\"04\">2004</option>";
			echo "<option value=\"05\">2005</option>";
			echo "</select>";
		} else {

			echo "<P><B>Year: 20" . $_REQUEST["year"] . "</b>";

			echo "<input type=hidden name=year value=" . $_REQUEST["year"] . ">";
		}
		
		if ( $_REQUEST["action"] != "showregion") {
			echo "<P>Select Provider: " . $dmr->getProviders("provider", "ALL", 0);
		} else {
			echo "<P><b>Provider:". $_REQUEST["provider"] ."</b> ";
			echo "<input type=hidden name=provider value=\"" . $_REQUEST["provider"] ."\">";
		}
		
		if ( $_REQUEST["action"] == "showregion") {
			echo "<P>Select a region: " . $dmr->getRegions("sRegion",1,$_REQUEST["provider"]);
		}
		echo "<P>";



			echo "<P><a href=\"\" onclick=\"dmr_validatechart(document.form1); return false;\">";
			echo "<img src=\"" . $file_path . "images/buttons/submit.jpg\" border=0></a>";

	?>
		<script>
			
			function dmr_validatechart(frm) {

				
				var msg = "";
				var bSubmit = true;
				alert(1);
				<?php if ( $_REQUEST["action"] == "showregion") { ?>
				alert(2);
				strProvider = frm.provider.value;
				strYear = frm.year.value;
					strRegion = getSelectValue("form1","sRegion");
					if (bSubmit == true ) {
						//frm.submit()
						window.open("provider_individual_2_new.php?region=" + strRegion + "&provider=" + strProvider + "&region=" + strRegion + "&year=" + strYear,"Results","width=900,height=600,toolbar=1,menubar=1,resizable=yes,status=0,scrollbars=1");
					} else {
						alert ("The following errors occured:" + msg)
					}
				<?php } else { ?>
				alert(3);
				strProvider = getSelectValue("form1","provider");
				strYear = getSelectValue("form1","year");
					if (bSubmit == true ) {
						frm.submit()
					} else {
						alert ("The following errors occured:" + msg)
					}
				<?php } ?>
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

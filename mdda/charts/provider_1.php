<?php 
ini_set("include_path","../../");
include("common/classes_md.php");
$template=new template;
$template->debug();
$template->define_file('mdda_template.php');
$template->add_region('title', '<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Provider Summary Report');
$template->add_region('sidebar', '<?php $area="provider"; $show_flash_link = 0; ?>');
$template->add_region('heading', 'Provider Summary Report');


$html	= '<form method="post" action="charts/provider_2.php">'
 		. '<p><input type="submit" class="submit" value="Generate Report" /></p>'
		. mdda::getFilters('provider')
 		. '<p><label for="report">Select Report:</label> <select name="report" id="report">'
		. '<option value="number">Number participating by Activity</option><option value="hours">Hours of Participation by Activity</option>'
		. '<option value="wage">Wages (during rep. per.)</option>
      <option value="pto">Number receiving paid time off</option></select></p>'
     
	 	. '<p><input type="submit" class="submit" value="Generate Report" /></p></form>';

$template->add_region('content', $html);
include("header.php");
$template->make_template(); 
include("footer.php");
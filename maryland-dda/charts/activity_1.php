<?php 
ini_set("include_path","../../");
include("common/classes_md.php");
$template = new template;
$template->debug();
$template->define_file('dda_template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Summary by Activity');
$template->add_region('sidebar','<?php $area="activity"; $show_flash_link = 0; $file_path = "../../"; ?>');
$template->add_region('heading','Summary by Activity');

$html	= '<form method="post" action="charts/activity_2.php">'
		. '<p><input type="submit" class="submit" value="submit"></p>'
		. dda::getFilters('activity')
		. '<p><label for="">Select Variable:</label>' . dda::getActivityVariables()
 		. '<p><input type="submit" class="submit" value="submit"></p>'
		. '<script type="text/javascript">function validate(elm){return true;}</script></form>';
$template->add_region('content', $html);
include("header.php");
$template->make_template(); 
include("footer.php");
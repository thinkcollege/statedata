<?php 
ini_set("include_path","../../");
include("common/classes.php");
$template = new template;
$template->debug();
$template->define_file('dds_template.php');
$template->add_region('title', '<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Trend Report');
$template->add_region('sidebar', '<?php $area="trends"; $show_flash_link = 0; ?>');
$template->add_region('heading', 'Trend Report');

$html	= "<form method=\"post\" action=\"./charts/trends_2.php\" onsubmit=\"javascript:validate(this);\">"
		. "<p><input type=\"submit\" class=\"submit\" value=\"submit\" /></p>"
		. dda::getFilters('trends')
		. "<p><label for=\"var\">Select Variable:</label> " . dda::getRegionVariables(2008) . "</p>"
		. "<p><input type=\"submit\" class=\"submit\" value=\"submit\" /></p>"
		. '<script type="text/javascript"><!--'
		. "\n\tfunction validate(elm) {\n"
		. "\t\tvar vars = document.getElementsByTagName('input');\n"
		. "\t\tfor (var i = 0; i < vars.length; i++) {\n"
		. "\t\t\tif (vars[i].type == 'radio' && vars[i].checked === true) { return true; }\n\t\t\t}\n"
		. "\t\talert('Please select a variable!');\n\t\treturn false;\n\t}// -->\n</script>"
		. "</form><br />";

$template->add_region('content', $html);
include("header.php");
$template->make_template(); 
include("footer.php");
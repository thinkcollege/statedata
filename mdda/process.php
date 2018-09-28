<?php 
ini_set("include_path","../");
include("common/classes_md.php");
ini_set('display_errors', 1);
ini_set("auto_detect_line_endings", true);
error_reporting(E_ALL);
$template = new template;
$template->debug();
$template->define_file('mdda_template.php');
$template->add_region('title', '<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Thank you');
$template->add_region('sidebar', '<?php $area="Thank you"; $show_flash_link = 0; ?>');
$template->add_region('heading','Thank you');

$fields = array('name', 'email', 'phone', 'state', 'organization', 'comment');
$msg = '';
foreach ($fields as $field) {
	$msg .= isset($_REQUEST[$field]) ? "$field: {$_REQUEST[$field]}\n\n";
}
$msg .= "browser/platform: {$_SERVER['HTTP_USER_AGENT']}\n\n";
$to = "paul.foos@umb.edu";
$subject .= " ($name)";
mail($to, $subject, $message);
$content "<p><blockquote>Thank you for your feedback. Should follow-up be required, sombody from the Institute for Community Inclusion will be in contact with you. Please start a new query by making "
	. "a selection from the navigation menu, or <a href=\"./\">return to the home page</a><br /><br /></blockquote></p>";

$template->add_region('content', $content);
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
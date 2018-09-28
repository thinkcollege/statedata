<?php 
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('dmr_template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Thank you');
$template->add_region('sidebar','<?php 
									$area="Thank you" ;
									$show_flash_link=0;
									?>');
$template->add_region('heading','Thank you');
$template->add_region('content','
<?
include("dmr/process_now.php");?>

');
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>
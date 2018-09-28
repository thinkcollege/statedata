<?php 
ini_set("include_path","../");
include("common/classes.php");
ini_set("include_path","../");
set_include_path(get_include_path().':/Library/Webserver/lib/'.':lib/:/home/ici/lib/');
function __autoload($class_name) {
   require_once $class_name . '.php';
}
$text = '<h2>Newsworthy Findings from StateData.info and Related Data Sets</h2>';
$db_obj = new icidb('localhost','ici','iciici99','ici');
$datanotes = $db_obj->get_results("SELECT * FROM `article` WHERE `article_pub_num` LIKE  'DN%'ORDER BY `article_pub_num` DESC");
foreach( $datanotes as $datanote )
{
	$text .= '<div class="boxed">
	<h3><a href="datanote.php?article_id='.$datanote->article_id.'">'.$datanote->article_title.'</a></h3>
	<p>'.$datanote->article_blurb.'</p></div>';
}
$template=new template;
$template->debug();
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Data Notes');
$template->add_region('sidebar','<?php 
									$area="datanotes" ;
									$show_flash_link=0;
									?>');
$template->add_region('heading','StateData.info - Data Notes');
$template->add_region('content',$text.'<hr>
<h3><a href="http://www.communityinclusion.org/topic.php?topic_id=5">Read other publications from the Institute for Community Inclusion.</a></h3>


');
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>

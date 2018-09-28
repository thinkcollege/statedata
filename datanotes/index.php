<?php 
ini_set("include_path","../");
include("common/classes.php");
ini_set("include_path","../");
set_include_path(get_include_path().':/Library/Webserver/lib/'.':lib/:/home/ici/lib/');
function __autoload($class_name) {
   require_once $class_name . '.php';
}
$text = '<h2>Newsworthy Findings from StateData.info and Related Data Sets</h2>
<div class="boxed boxed_red" >
<a href="http://communityinclusion.github.io/book12/"><img src="/statedatabook/img/thumb_bluebook.png" alt="statedata book cover" align="left" style="padding-right:1em"  /></a>
<h4 style="color:red;">2012 Report</h4>
<h3>
<a href="http://communityinclusion.github.io/book12/">ICI\'s National Report on Employment Services and Outcomes 2012 is now available.</a>
</h3>
<p>ICI\'s National Report on Employment Services and Outcomes is now available. The book provides national and state level statistics spanning a twenty-year period. Its sources include several data sets that address the status of employment and economic self-sufficiency for individuals with ID/DD. <br /><br /><a href="/statedatabook/bluebook2012_final.pdf" class="jcbutton"><strong>Download the PDF here</strong></a></p> 
</div>';

$db_obj = new icidb('localhost','ici','iciici99','ici');
$datanotes = $db_obj->get_results("SELECT * FROM `article` WHERE `article_pub_num` LIKE  'DN%'ORDER BY `article_id` DESC");


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

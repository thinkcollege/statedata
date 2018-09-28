<?php  
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Article Administration');
$template->add_region('heading','Article Administration');
$template->add_region('content','
<?php 
$permission=new permission;
$check=$permission->get_permission($userid,$pageinfo["itemid"]);
if ($check["admin"]<>"true"){?>
Sorry, but you do not have the permission to administrate
<?php   }else{?>
<?php
$articlesclass=new article;
$articles=$articlesclass->get_articles();
for ($article=0;$article<$articles["count"];$article++){
?>
<b><a href="editarticle.php?article=<?php echo $articles["articleid[$article]"]?>"><?php echo $articles["title[$article]"];?></a> </b><br>
<?php
}
?>
<?php }?>
');
$template->make_template();
?>
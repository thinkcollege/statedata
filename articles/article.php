<?php  
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Article');
$template->add_region('heading','Article');
$template->add_region('content','
<?php
if ($_GET["article"]==""){?>
You must select an article
<?php }else{
$articles=new article;
$article=$articles->get_article($_GET["article"]);
if ($article["success"]=="false"){?>
That article does not exist
<?php }else{
$items=new item;
$item=$items->get_item("articles",$article["id"]);
$permission=new permission;
$check=$permission->get_permission($userid,$item["itemid"]);
if ($check["read"]<>"true"){?>
Sorry, but you do not have the permission to read this article 
<?php   }else{?>
<h3><?php echo $article["title"];?></h3>
<b><?php echo $article["posted"];?></b><br><br>
<?php echo $article["article"];?><br>
<?php
$user=new user;
$userinfo=$user->get_account($article["userid"]);?>
--<a href="../user/user.php?userinfo=<?php echo $userinfo["userid"]?>"><?php echo $userinfo["first_name"]?> 
<?php echo $userinfo["last_name"]?></a> 
<?php }}}?>
'); 
$template->make_template(); ?>

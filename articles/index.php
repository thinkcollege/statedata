<?php  
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Articles');
$template->add_region('heading','Articles');
$template->add_region('content','
<?php   
$permission=new permission;
$pages=new page;
$pageinfo=$pages->get_page($_SERVER["PHP_SELF"]);
$checkadmin=$permission->get_permission($userid,$pageinfo["itemid"]);
if ($checkadmin["read"]<>"true"){?> Sorry, but you do not have the permission to read articles 
<?php   }else{?>
<a href="submit.php">Submit Article</a><br>
<br>
<b>Categories</b>:<br>
<?php if ($_GET["category"]<>0 and $_GET["category"]<>""){?>
<?php
$tree=new tree;
$parent=$tree->get_parent($_GET["category"]);
?>
[<a href="index.php?category=<?php echo $parent["parent"]?>">Up one level</a>]<br>
<?php }?>
<?php
$article=new article;
$tree=new tree;
$todo="";
$level=0;
$subs=$tree->get_subs($article->article_treeid,$_GET["category"]);
$sub=0;
for (;;){
if ($sub<$subs["count"] or $level>0){
if ($subs["catid[$sub]"]==""){
$test="";
}else{
$test=@$tree->get_subs($article->article_treeid,$subs["catid[$sub]"]);
}
?>
<?php
if ($subs["title[$sub]"]<>""){
for ($dash=0;$dash<=$level;$dash++){?>-<?php }?><a href="index.php?category=<?php echo $subs["catid[$sub]"];?>"><?php echo $subs["title[$sub]"];?></a><br>
<?php }?>
<?php 
if ($test["count"]>0){
$level++;
$todo["sub[$level]"]=$sub;
$todo["subs[$level]"]=$subs;
$sub=-1;
$subs=$test;
}
if ($sub+1>=$subs["count"]){
$sub=$todo["sub[$level]"];
$subs=$todo["subs[$level]"];
$level--;
}
?>
<?php 
$sub++;
}else{break;}}
?>
<br>
<?php
$articlesclass=new article;
$articles=$articlesclass->get_articlesc($articlesclass->article_treeid,$_GET["category"]+0);
for ($article=0;$article<$articles["count"];$article++){
?>
<b><a href="article.php?article=<?php echo $articles["articleid[$article]"]?>"><?php echo $articles["title[$article]"];?></a> </b><br>
<?php echo $articlesclass->shorten_article($articles["article[$article]"],350);?>
<br><br>
<?php
}
?>
<?php }?>
');
$template->make_template();
?>
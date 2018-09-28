<?php  
ini_set("include_path","../../");
include("common/classes.php");
$template=new template;
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Edit Article');
$template->add_region('heading','Edit Article');
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
if ($check["admin"]<>"true"){?>
Sorry, but you do not have the permission to administrate 
<?php   }else{?>
<?php
if ($_POST["delete"]=="true"){
$articles->delete_article($article["id"]);
} else {
$articles->edit_article($article["id"],$_POST["title"],$_POST["article"],$userid,$_POST["posted"],$articles->article_treeid,$_POST["catid"]);
$article=$articles->get_article($article["id"]);
$thearticle=$article;
?>
<form name="edit" method="post" action="editarticle.php?article=<?php echo $_GET["article"]?>">
  <b>Title</b>: 
  <input type="text" name="title" maxlength="100" value="<?php echo $article["title"]?>">
  <br>
  <b>Posted</b>: 
  <input type="radio" name="posted" value="<?php echo date("m/d/Y");?>" checked>
  Today 
  <input type="radio" name="posted" value="<?php echo $article["posted"]?>">
  Original <br>
  <textarea name="article" cols="80" rows="12"><?php echo $article["formarticle"]?></textarea>
  <br>
  <br>
  Category:
  <select name="catid">
	<option value="0" <?php if ($thearticle["catid[0]"]==0){?>selected<?php }?>>Top</option>
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
if ($subs["title[$sub]"]<>""){?>
	<option value="<?php echo $subs["catid[$sub]"];?>" <?php if ($thearticle["catid[0]"]==$subs["catid[$sub]"]){?>selected<?php }?>> 
	<?php for ($dash=0;$dash<=$level;$dash++){?>-<?php }?><?php echo $subs["title[$sub]"];?></option>
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
  </select>
  <br>
  <br>
  <input type="checkbox" name="delete" value="true">
  Delete <br>
  <input type="submit" name="Submit" value="Submit">
</form>
<?php }}}}?>
'); $template->make_template(); ?> 

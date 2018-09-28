<?php  
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Submit Article');
$template->add_region('heading','Submit Article');
$template->add_region('content','
<?php
$user=new user;
$check=$user->logged_in($userid);
if ($check["success"]<>"true"){?>Sorry, but you must be logged in
<?php }else{
?>
<?php   
$permission=new permission;
$checkadmin=$permission->get_permission($userid,$pageinfo["itemid"]);
if ($checkadmin["write"]<>"true"){?>
Sorry, but you do not have the permission to post
<?php   }else{?>
<?php
$articles=new article;
$articles->add_article($userid,$_POST["title"],$_POST["article"],$articles->article_treeid,$_POST["catid"]);
?>
<form name="submit" method="post" action="submit.php">
<b>Title</b>: 
<input type="text" name="title" maxlength="100"><br><br>
  <textarea name="article" cols="60" rows="12"></textarea>
  <br>
  <br>
  Category:
  <select name="catid">
<option value="0" selected>Top</option>
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
if ($subs["title[$sub]"]<>""){?><option value="<?php echo $subs["catid[$sub]"];?>">
<?php for ($dash=0;$dash<=$level;$dash++){?>-<?php }?>
<?php echo $subs["title[$sub]"];?></option>
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
  <input type="submit" name="Submit" value="Submit Article">
</form>
<?php }}?>
');
$template->make_template();
?>
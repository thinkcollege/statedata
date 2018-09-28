<?php   
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Home');
$template->add_region('heading','mre_base'); 
$template->add_region('content',' 
  <br>
  <div align="left"><img src="images/extras/banner.gif" width="400" height="50"> </div>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr align="center" valign="top"> 
	<td width="50%"> 
	  <table width="100%" cellspacing="0" cellpadding="0" height="70">
		<tr align="left" valign="bottom"> 
		  <td width="50%" bgcolor="#EEEEEE" height="1"> <b>Welcome to mre_base</b><br>
			<img src="images/extras/gradual2.gif" width="100%" height="8"></td>
		</tr>
		<tr align="left" valign="top"> 
		  <td width="50%">mre_base is a Web-based community system that uses PHP. 
			It is object oriented, so it is easily extendible. Its database abstraction 
			layer allows it to be compatible with multiple databases. mre_base 
			is easily configurable, and includes content management systems, as 
			well as advanced administration for you to use in order to maintain 
			an incredibly sophisticated Web site.<br>
			<ul>
			  <li><a href="../common/index.php">About mre_base</a></li>
			  <li><a href="../common/support.php">Support mre_base</a></li>
			  <li><a href="../common/link.php">Link to mre_base</a></li>
			</ul>
		  </td>
		</tr>
	  </table>
	</td>
	<td width="50%"> 
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" height="70">
		<tr align="left" valign="bottom"> 
		  <td width="50%" bgcolor="#EEEEEE" height="1"><b>What\'s New</b><br>
			<img src="images/extras/gradual2.gif" width="100%" height="8"></td>
		</tr>
		<tr align="left" valign="top"> 
		  <td width="50%"> 
			<ul>
			  <li>Check out the latest version of mre_base</li>
			</ul>
		  </td>
		</tr>
	  </table>
	</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr align="center" valign="top"> 
	<td width="50%"> 
	  <table width="100%" cellspacing="0" cellpadding="0" height="70">
		<tr align="left" valign="bottom"> 
		  <td width="50%" bgcolor="#EEEEEE" height="1"> <b>Latest Content</b><br>
			<img src="images/extras/gradual2.gif" width="100%" height="8"></td>
		</tr>
		<tr align="left" valign="top"> 
		  <td width="50%"> 
<u>Articles:</u><br>
<?php
$article=new article;
$articles=$article->get_articles();
if ($articles["count"]==0){
?>No articles found<br><?php
}else{
for ($article=0;$article<$articles["count"] and $article<5;$article++){?>
&nbsp;&#149; <a href="articles/article.php?article=<?php echo $articles["articleid[$article]"]?>"> 
<?php echo $articles["title[$article]"];?></a><br>
<?php }}?>
<br>

<u>Forum posts:</u><br>
<?php
$forum=new forum;
$posts=$forum->get_all_posts();
if ($posts["count"]==0){
?>No posts found<br><?php
}else{
for ($post=0;$post<$posts["count"] and $post<5;$post++){?>
&nbsp;&#149; <a href="forum/forum.php?forum=<?php echo $posts["forumid[$post]"]?>&topic=<?php echo $posts["postid[$post]"]?>"> 
<?php echo $posts["subject[$post]"];?></a><br>
<?php }}?>
<br>

<u>Events:</u><br>
<?php
$calendar=new calendar;
$events=$calendar->get_events();
if ($events["count"]==0){
?>No events found<br><?php
}else{
for ($event=0;$event<$events["count"] and $event<5;$event++){?>
&nbsp;&#149; <a href="calendar/event.php?event=<?php echo $events["scheduleid[$event]"]?>"> 
<?php echo $events["title[$event]"];?></a><br>
<?php }}?>
		  </td>
		</tr>
	  </table>
	</td>
	<td width="50%"> 
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" height="70">
		<tr align="left" valign="bottom"> 
		  <td width="50%" bgcolor="#EEEEEE" height="1"><b>Poll</b><br>
			<img src="images/extras/gradual2.gif" width="100%" height="8"></td>
		</tr>
		<tr align="left" valign="top"> 
		  <td width="50%"> 
			<?php
$poll=new poll;
$poll->make_poll(1);
?>
		  </td>
		</tr>
	  </table>
	</td>
  </tr>
</table>
<br>
'); $template->make_template(); ?> 

<?php    
/*
class: forum
purpose: forum management
*/
class forum extends mre_base{

/*
function: add_forum
purpose: add forum
*/
function add_forum($userid,$title,$details){
	$return["success"]="false";
	if ($title<>"" and $details<>"" and $userid>0){
		$database = Database::getDatabase();
		$database->query("insert into forums(title,details) values('$title','$details');");
		$getid=$database->query("select forumid from forums where title='$title' and details='$details';");
		$return["forumid"]=$database->fetch_result($getid,0,'forumid');
		$forumid=$return["forumid"];
		$items=new item;
		$item=$items->add_item('forums',$forumid);
		$permission=new permission;
		$permission->add_permission($userid,'t','t','t',$item["id"]);
		$return["success"]="true";
	}
	return $return;
}

/*
function: delete_post
purpose: delete a post
*/
function delete_post($forumid,$postid){
	$return["success"]="false";
	if ($postid>0 and $forumid>0){
		$database = Database::getDatabase();
		$check=$database->query("select parent from posts where postid=$postid and forumid=$forumid");
		if ($database->fetch_result($check,0,'parent')==0){
			$forum=new forum;
			$children=$forum->get_posts($forumid,$postid);
			$database->query("delete from posts where postid=$postid and forumid=$forumid;");
			$database->query("delete from posts where parent=$postid and forumid=$forumid;");
			$items=new item;
			$item=$items->get_item('posts',$postid);
			$item=$item["itemid"];
			$items->delete_item('posts',$postid);
			for ($child=0;$child<$children["posts"];$child++){
				$item=$items->get_item('posts',$children["postid[$child]"]);
				$item=$item["itemid"];
				$items->delete_item('posts',$children["postid[$child]"]);
			}
			$return["success"]="true";
		}else{
			$items=new item;
			$database->query("delete from posts where postid=$postid and forumid=$forumid;");
			$items->delete_item('posts',$postid);
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: add_post
purpose: add forum post
*/
function add_post($userid,$forumid,$parent,$subject,$post){
	$return["success"]="false";
	if ($parent==""){$parent=0;}
	if ($userid>0 and $forumid>0 and $parent>=0 and $subject<>"" and $post<>""){
		$database = Database::getDatabase();
		$postdate=date("Y-m-d");
		$database->query("insert into posts (userid,forumid,parent,subject,post,postdate) values($userid,$forumid,$parent,'$subject','$post','$postdate');");
		$postid=$database->query("select postid from posts where userid=$userid and forumid=$forumid and parent=$parent and subject='$subject' and post='$post' and postdate='$postdate';");
		$postid=$database->fetch_result($postid,0,'postid');
		$items=new item;
		$items->add_item('posts',$postid);
		$getparent=$database->query("select parent from posts where forumid=$forumid and subject='$subject' and post='$post';");
		if ($database->num_rows($getparent)<>0){
			$return["parent"]=$database->fetch_result($getparent,0,'parent');
			if ($this->forum_emailid<>""){
				$notification=new notification;
				$thetemplate=$notification->get_email($this->forum_emailid);
				if ($thetemplate["subject"]<>"" and $thetemplate["body"]<>""){
					$subj=$thetemplate["subjectsend"];
					$body=$thetemplate["bodysend"];
					$numbersent=0;
					$wanters=$notification->get_wanters($this->forum_emailid);				
					$user=new user;
					for ($wanter=0; $wanter<$wanters["count"]; $wanter++){
						$emailbody=$body;
						$userinfo=$user->get_account($wanters["userid[$wanter]"]);
						$notification=new notification;
						$emailbody=str_replace("#first_name#",$userinfo["first_name"],$emailbody);
						$emailbody=str_replace("#last_name#",$userinfo["last_name"],$emailbody);
						$emailbody=str_replace("#forumpost_title#",$subject,$emailbody);
						$emailbody=str_replace("#forumpost_post#",$post,$emailbody);
						$emailbody=str_replace("#forumpost_url#",$this->mre_base_webpath.$this->forum_url."?forum=".$forumid."&topic=".$postid,$emailbody);
						$notification->send_email($userinfo["email"],$subj,$emailbody);
						$numbersent++;
					}
				}
			}
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: get_all_posts
purpose: get all posts
*/
function get_all_posts(){
	$return["success"]="false";
	$database = Database::getDatabase();
	$posts=$database->query("select forumid,postid,parent,subject,post,postdate,userid from posts order by postid desc;");
	for ($post=0;$post<$database->num_rows($posts);$post++){
		$functions=new functions;
		$return["forumid[$post]"]=$database->fetch_result($posts,$post,'forumid');
		$return["postid[$post]"]=$database->fetch_result($posts,$post,'postid');
		$return["parent[$post]"]=$database->fetch_result($posts,$post,'parent');
		$return["subject[$post]"]=nl2br($database->fetch_result($posts,$post,'subject'));
		$return["post[$post]"]=$functions->safehtml(nl2br($database->fetch_result($posts,$post,'post')));
		$return["postdate[$post]"]=$database->fetch_result($posts,$post,'postdate');
		$return["userid[$post]"]=$database->fetch_result($posts,$post,'userid');
		$return["count"]++;
		$return["success"]="true";
	}
	return $return;
}

/*
function: get_posts
purpose: get forum posts
*/
function get_posts($forumid,$parent){
	$return["success"]="false";
	if ($parent>=0){
		$database = Database::getDatabase();
		$posts=$database->query("select forumid,postid,parent,subject,post,postdate,userid from posts where parent=$parent and forumid=$forumid;");
		for ($post=0;$post<$database->num_rows($posts);$post++){
			$functions=new functions;
			$return["forumid[$post]"]=$database->fetch_result($posts,$post,'forumid');
			$return["postid[$post]"]=$database->fetch_result($posts,$post,'postid');
			$return["parent[$post]"]=$database->fetch_result($posts,$post,'parent');
			$return["subject[$post]"]=nl2br($database->fetch_result($posts,$post,'subject'));
			$return["post[$post]"]=$functions->safehtml(nl2br($database->fetch_result($posts,$post,'post')));
			$return["postdate[$post]"]=$database->fetch_result($posts,$post,'postdate');
			$return["userid[$post]"]=$database->fetch_result($posts,$post,'userid');
			$return["count"]++;
		}
		$return["success"]="true";
	}
	return $return;
}

/*
function: get_post
purpose: get forum post
*/
function get_post($forumid,$postid){
	$return["success"]="false";
	if ($postid>=0){
		$database = Database::getDatabase();
		$post=$database->query("select forumid,postid,parent,subject,post,postdate,userid from posts where postid=$postid and forumid=$forumid;");
		if ($database->num_rows($post)==1){
			$functions=new functions;
			$return["forumid"]=$database->fetch_result($post,0,'forumid');
			$return["postid"]=$database->fetch_result($post,0,'postid');
			$return["parent"]=$database->fetch_result($post,0,'parent');
			$return["subject"]=nl2br($database->fetch_result($post,0,'subject'));
			$return["post"]=$functions->safehtml(nl2br($database->fetch_result($post,0,'post')));
			$return["postdate"]=$database->fetch_result($post,0,'postdate');
			$return["userid"]=$database->fetch_result($post,0,'userid');
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: get_forum
purpose: get forum information
*/
function get_forum($forumid){
	$return["success"]="false";
	if ($forumid>0){
		$database = Database::getDatabase();
		$forum=$database->query("select forumid,title,details from forums where forumid=$forumid;");
		if ($database->num_rows($forum)<>0){
			$return["forumid"]=$database->fetch_result($forum,0,'forumid');
			$return["title"]=$database->fetch_result($forum,0,'title');
			$return["details"]=nl2br($database->fetch_result($forum,0,'details'));
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: get_forums
purpose: get forums
*/
function get_forums(){
	$database = Database::getDatabase();
	$return["success"]="false";
	$forums=$database->query("select forumid,title,details from forums order by title asc;");
	for ($forum=0;$forum<$database->num_rows($forums);$forum++){
		$return["forumid[$forum]"]=$database->fetch_result($forums,$forum,'forumid');
		$return["title[$forum]"]=$database->fetch_result($forums,$forum,'title');
		$return["details[$forum]"]=nl2br($database->fetch_result($forums,$forum,'details'));
		$return["count"]++;
		$return["success"]="true";
	}
	return $return;
}

}
?>
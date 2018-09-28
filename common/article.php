<?php    
/*
class: article
purpose: article management
*/
class article extends mre_base{

/*
function: add_article
purpose: add article
*/
function add_article($userid,$title,$article,$treeid,$catid){
	$return["success"]="false";
	if ($title<>"" and $article<>"" and $userid>0 and $catid>=0 and $treeid>0){
		$database = Database::getDatabase();
		$posted=date("Y-m-d");
		$database->query("insert into articles(title,article,userid,posted) values('$title','$article',$userid,'$posted');");
		$getid=$database->query("select articleid from articles where title='$title' and article='$article';");
		$return["articleid"]=$database->fetch_result($getid,0,'articleid');
		$articleid=$return["articleid"];
		$items=new item;
		$item=$items->add_item('articles',$articleid);
		$tree=new tree;
		$tree->add_relation($item["id"],$treeid,$catid);
		$permission=new permission;
		$permission->add_permission($userid,'t','t','t',$item["id"]);
		$notification=new notification;
		if ($this->article_emailid<>""){
			$thetemplate=$notification->get_email($this->article_emailid);
			if ($thetemplate["subject"]<>"" and $thetemplate["body"]<>""){
				$subject=$thetemplate["subjectsend"];
				$body=$thetemplate["bodysend"];
				$numbersent=0;
				$wanters=$notification->get_wanters($this->article_emailid);				
				$user=new user;
				for ($wanter=0; $wanter<$wanters["count"]; $wanter++){
					$emailbody=$body;
					$userinfo=$user->get_account($wanters["userid[$wanter]"]);
					$notification=new notification;
					$emailbody=str_replace("#first_name#",$userinfo["first_name"],$emailbody);
					$emailbody=str_replace("#last_name#",$userinfo["last_name"],$emailbody);
					$emailbody=str_replace("#article_title#",$title,$emailbody);
					$emailbody=str_replace("#article_text#",$article,$emailbody);
					$emailbody=str_replace("#article_url#",$this->mre_base_webpath.$this->article_url."?article=".$articleid,$emailbody);
					$notification->send_email($userinfo["email"],$subject,$emailbody);
					$numbersent++;
				}
			}
		}
		$return["success"]="true";
	}
	return $return;
}

/*
function: delete_article
purpose: delete article
*/
function delete_article($articleid){
	$return["success"]="false";
	if ($articleid>0){
		$database = Database::getDatabase();
		$database->query("delete from articles where articleid=$articleid");
		$items=new item;
		$item=$items->get_item('articles',$articleid);
		$item=$item["itemid"];
		$tree=new tree;
		$tree->delete_relationi($item);
		$items->delete_item('articles',$articleid);
		$return["success"]="true";
	}
	return $return;
}

/*
function: edit_article
purpose: edit article
*/
function edit_article($articleid,$title,$article,$userid,$posted,$treeid,$catid){
	$return["success"]="false";
	if ($articleid>0 and $title<>"" and $article<>"" and $userid>0 and $posted<>"" and $treeid>0 and $catid>=0){
		$database = Database::getDatabase();
		$database->query("update articles set title='$title',article='$article',userid=$userid,posted='$posted' where articleid=$articleid;");
		$item=new item;
		$item=$item->get_item("articles",$articleid);
		$item=$item["itemid"];
		$database->query("update catrel set treeid=$treeid,catid=$catid where itemid=$item;");
		$return["success"]="true";
	}
	return $return;
}

/*
function: get_article
purpose: get article
*/
function get_article($articleid){
	$return["success"]="false";
	if ($articleid>0){
		$database = Database::getDatabase();
		$article=$database->query("select title,article,userid,posted,articleid from articles where articleid=$articleid;");
		if ($database->num_rows($article)==1){
			$functions=new functions;
			$return["title"]=$database->fetch_result($article,0,'title');
			$return["article"]=$functions->safehtml(nl2br($database->fetch_result($article,0,'article')));
			$return["formarticle"]=$database->fetch_result($article,0,'article');
			$return["userid"]=$database->fetch_result($article,0,'userid');
			$return["posted"]=$database->fetch_result($article,0,'posted');
			$return["id"]=$database->fetch_result($article,0,'articleid');
			$item=new item;
			$theitem=$item->get_item("articles",$articleid);
			$itemid=$theitem["itemid"];
			$categories=$database->query("select catid from catrel where itemid=$itemid;");
			for ($category=0;$category<$database->num_rows($categories);$category++){
				$return["catid[$category]"]=$database->fetch_result($categories,$category,'catid');
			}
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: get_articles
purpose: get articles
*/
function get_articles(){
	$return["success"]="false";
	$database = Database::getDatabase();
	$articles=$database->query("select title,article,userid,posted,articleid from articles order by articleid desc;");
	for ($article=0;$article<$database->num_rows($articles);$article++){
		$functions=new functions;
		$return["title[$article]"]=$database->fetch_result($articles,$article,'title');
		$return["article[$article]"]=$functions->safehtml(nl2br($database->fetch_result($articles,$article,'article')));
		$return["formarticle[$article]"]=$database->fetch_result($articles,$article,'article');
		$return["userid[$article]"]=$database->fetch_result($articles,$article,'userid');
		$return["posted[$article]"]=$database->fetch_result($articles,$article,'posted');
		$return["articleid[$article]"]=$database->fetch_result($articles,$article,'articleid');
		$return["count"]++;
		$return["success"]="true";
	}
	return $return;
}

/*
function: get_articlesc
purpose: get articles in category
*/
function get_articlesc($treeid,$catid){
	$return["success"]="false";
	if ($catid>=0 and $treeid>0){
		$database = Database::getDatabase();
		$items=$database->query("select itemid from catrel where treeid=$treeid and catid=$catid order by catrelid desc;");
		for ($item=0;$item<$database->num_rows($items);$item++){
			$itemid=$database->fetch_result($items,$item,'itemid');
			$itemresult=$database->query("select id from items where itemid=$itemid");
			if ($database->num_rows($itemresult)==1){
				$functions=new functions;
				$articleid=$database->fetch_result($itemresult,0,'id');
				$article=$database->query("select title,article,userid,posted,articleid from articles where articleid=$articleid;");
				$return["title[$item]"]=$database->fetch_result($article,0,'title');
				$return["article[$item]"]=$functions->safehtml(nl2br($database->fetch_result($article,0,'article')));
				$return["formarticle[$item]"]=$database->fetch_result($article,0,'article');
				$return["userid[$item]"]=$database->fetch_result($article,0,'userid');
				$return["posted[$item]"]=$database->fetch_result($article,0,'posted');
				$return["articleid[$item]"]=$database->fetch_result($article,0,'articleid');
				$return["count"]++;
				$return["success"]="true";
			}
		}
	}
	return $return;
}

/*
function: shorten_article
purpose: shorten article
*/
function shorten_article($article,$characters){
	if ($article<>"" and $characters>0){
		$articleshortened=substr_replace($article, '', $characters);
		if ($article<>$articleshortened){$articleshortened.="...";}
		return nl2br($articleshortened);
	}
}

}
?>
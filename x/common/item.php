<?php    
/*
class: item
purpose: item management
*/
class item extends mre_base{

/*
function: add_item
purpose: add an item
*/
function add_item($tablename,$id){
	$return["success"]="false";
	if ($tablename<>"" and $id>0){
		$return["success"]="true";
		$database = Database::getDatabase();
		$database->query("insert into items (tablename,id) values('$tablename',$id);");
		$getid=$database->query("select itemid from items where tablename='$tablename' and id=$id");
		if($database->num_rows($getid)==1){
			$return["id"]=$database->fetch_result($getid,0,'itemid');
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: get_item
purpose: get item
*/
function get_item($tablename,$id){
	$return["success"]="false";
	if ($tablename<>"" and $id>=0){
		$database = Database::getDatabase();
		$itemid=$database->query("select itemid from items where tablename='$tablename' and id=$id;");
		if ($database->num_rows($itemid)==1){
			$return["itemid"]=$database->fetch_result($itemid,0,'itemid');
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: get_itemi
purpose: get item by id
*/
function get_itemi($itemid){
	$return["success"]="false";
	if ($itemid>0){
		$database = Database::getDatabase();
		$item=$database->query("select tablename,id,itemid from items where itemid=$itemid;");
		$return["itemid"]=$database->fetch_result($item,0,'itemid');
		$return["tablename"]=$database->fetch_result($item,0,'tablename');
		$return["id"]=$database->fetch_result($item,0,'id');
		$id=$return["id"];
		if ($database->fetch_result($item,0,'tablename')=='articles'){
			$return["type"]="Article";
			$name=$database->query("select title from articles where articleid=$id");
			$return["name"]=$database->fetch_result($name,0,'title');
		}
		if ($database->fetch_result($item,0,'tablename')=='categories'){
			$return["type"]="Category";
			$name=$database->query("select title from categories where catid=$id");
			$return["name"]=$database->fetch_result($name,0,'title');
		}
		if ($database->fetch_result($item,0,'tablename')=='emails'){
			$return["type"]="Email";
			$name=$database->query("select subject from emails where emailid=$id");
			$return["name"]=$database->fetch_result($name,0,'subject');
		}
		if ($database->fetch_result($item,0,'tablename')=='forums'){
			$return["type"]="Forum";
			$name=$database->query("select title from forums where forumid=$id");
			$return["name"]=$database->fetch_result($name,0,'title');
		}
		if ($database->fetch_result($item,0,'tablename')=='pages'){
			$return["type"]="Page";
			$name=$database->query("select page from pages where pageid=$id");
			$return["name"]=$database->fetch_result($name,0,'page');
		}
		if ($database->fetch_result($item,0,'tablename')=='posts'){
			$return["type"]="Post";
			$name=$database->query("select subject from posts where postid=$id");
			$return["name"]=$database->fetch_result($name,0,'subject');	
		}
		if ($database->fetch_result($item,0,'tablename')=='schedule'){
			$return["type"]="Event";
			$name=$database->query("select title from schedule where scheduleid=$id");
			$return["name"]=$database->fetch_result($name,0,'title');
		}
		if ($database->fetch_result($item,0,'tablename')=='trees'){
			$return["type"]="Tree";
			$name=$database->query("select treeid from trees where treeid=$id");
			$return["name"]=$database->fetch_result($name,0,'treeid');
		}
		if ($database->fetch_result($item,0,'tablename')==''){
			$return["type"]="Everything";
		}
		$return["success"]="true";
	}
	return $return;
}

/*
function: delete_item
purpose: delete item
*/
function delete_item($tablename,$id){
	$return["success"]="false";
	if ($tablename<>"" and $id>=0){
		$database = Database::getDatabase();
		$item=new item;
		$theitem=$item->get_item($tablename,$id);
		$item=$theitem["itemid"];
		$database->query("delete from rights where itemid=$item;");
		$database->query("delete from items where tablename='$tablename' and id=$id;");
		$return["success"]="true";
	}
	return $return;
}

/*
function: get_items
purpose: get items
*/
function get_items(){
	$return["success"]="false";
	$database = Database::getDatabase();
	$items=$database->query("select itemid,tablename,id from items order by tablename asc;");
	for ($item=0;$item<$database->num_rows($items);$item++){
		$return["itemid[$item]"]=$database->fetch_result($items,$item,'itemid');
		$return["tablename[$item]"]=$database->fetch_result($items,$item,'tablename');
		$return["id[$item]"]=$database->fetch_result($items,$item,'id');
		$id=$return["id[$item]"];
		if ($database->fetch_result($items,$item,'tablename')=='articles'){
			$return["type[$item]"]="Article";
			$name=$database->query("select title from articles where articleid=$id");
			$return["name[$item]"]=$database->fetch_result($name,0,'title');
		}
		if ($database->fetch_result($items,$item,'tablename')=='categories'){
			$return["type[$item]"]="Category";
			$name=$database->query("select title from categories where catid=$id");
			$return["name[$item]"]=$database->fetch_result($name,0,'title');
		}
		if ($database->fetch_result($items,$item,'tablename')=='emails'){
			$return["type[$item]"]="Email";
			$name=$database->query("select subject from emails where emailid=$id");
			$return["name[$item]"]=$database->fetch_result($name,0,'subject');
		}
		if ($database->fetch_result($items,$item,'tablename')=='forums'){
			$return["type[$item]"]="Forum";
			$name=$database->query("select title from forums where forumid=$id");
			$return["name[$item]"]=$database->fetch_result($name,0,'title');
		}
		if ($database->fetch_result($items,$item,'tablename')=='pages'){
			$return["type[$item]"]="Page";
			$name=$database->query("select page from pages where pageid=$id");
			$return["name[$item]"]=$database->fetch_result($name,0,'page');
		}
		if ($database->fetch_result($items,$item,'tablename')=='posts'){
			$return["type[$item]"]="Post";
			$name=$database->query("select subject from posts where postid=$id");
			$return["name[$item]"]=$database->fetch_result($name,0,'subject');	
		}
		if ($database->fetch_result($items,$item,'tablename')=='schedule'){
			$return["type[$item]"]="Event";
			$name=$database->query("select title from schedule where scheduleid=$id");
			$return["name[$item]"]=$database->fetch_result($name,0,'title');
		}
		if ($database->fetch_result($items,$item,'tablename')=='trees'){
			$return["type[$item]"]="Tree";
			$name=$database->query("select treeid from trees where treeid=$id");
			$return["name[$item]"]=$database->fetch_result($name,0,'treeid');
		}
		if ($database->fetch_result($items,$item,'tablename')==''){
			$return["type[$item]"]="Everything";
		}
		$return["count"]++;
		$return["success"]="true";
	}
	return $return;
}

}
?>
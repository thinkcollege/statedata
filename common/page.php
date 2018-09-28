<?php
/*
class: page
purpose: page management
*/
class page extends mre_base {

/*
function: add_page
purpose: if a page doesn't exist, add it
*/
function add_page($page){
	$return["success"]="false";
	if ($page<>""){
		$database = Database::getDatabase();
		$check=$database->query("select pageid from pages where page='$page';");
		if ($database->num_rows($check)<>1){
			$database->query("insert into pages(page) values('$page');");
			$getid=$database->query("select pageid from pages where page='$page';");
			if ($database->num_rows($getid)==1){
				$pageid=$database->fetch_result($getid,0,'pageid');
				$database->query("insert into items (tablename,id) values('pages',$pageid);");
				$return["success"]="true";
			}
		}
	}
	return $return;
}

/*
function: get_page
purpose: get page
*/
function get_page($page){
	$return["success"]="false";
	if ($page<>""){
		$pages=new page;
		$pages->add_page($page);
		$database=Database::getDatabase();
		$pageid=$database->query("select pageid from pages where page='$page';");
		if ($database->num_rows($pageid)==1){
			$return["pageid"]=$database->fetch_result($pageid,0,'pageid');
			$pageid=$return["pageid"];
			$itemid=$database->query("select itemid from items where tablename='pages' and id=$pageid;");
			$return["itemid"]=$database->fetch_result($itemid,0,'itemid');
			$return["success"]="true";
		}
	}
	
	//echo $return["itemid"];
	return $return;
}

}
?>
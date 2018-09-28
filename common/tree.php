<?php    
/*
class: tree
purpose: category tree management
*/
class tree extends mre_base{

/*
function: add_tree
purpose: add tree
*/
function add_tree($title){
	$return["success"]="false";
	if ($title<>""){
		$database = Database::getDatabase();
		$database->query("insert into trees(title) values('$title');");
		$getid=$database->query("select treeid from trees where title='$title';");
		if ($database->num_rows($getid)==1){
			$return["id"]=$database->fetch_result($getid,0,'treeid');
			$item=new item;
			$item->add_item("trees",$return["id"]);
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: add_category
purpose: add category
*/
function add_category($treeid,$parent,$title,$details){
	$return["success"]="false";
	if ($treeid>0 and $parent>=0 and $title<>"" and $details<>""){
		$database = Database::getDatabase();
		$database->query("insert into categories(treeid,parent,title,details) values($treeid,$parent,'$title','$details');");
		$getid=$database->query("select catid from categories where title='$title' and details='$details' and treeid=$treeid and parent=$parent;");
		if ($database->num_rows($getid)==1){
			$return["id"]=$database->fetch_result($getid,0,'catid');
			$item=new item;
			$item->add_item("categories",$return["id"]);
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: add_relation
purpose: add relation
*/
function add_relation($itemid,$treeid,$catid){
	$return["success"]="false";
	if ($itemid>0 and $catid>=0 and $treeid>0){
		$database = Database::getDatabase();
		$database->query("insert into catrel (itemid,treeid,catid) values($itemid,$treeid,$catid);");
		$return["success"]="true";
	}
	return $return;
}

/*
function: delete_relation
purpose: delete relation
*/
function delete_relation($catrelid){
	$return["success"]="false";
	if ($catrelid>0){
		$database = Database::getDatabase();
		$database->query("delete from catrel where catrelid=$catrelid;");
		$return["success"]="true";
	}
	return $return;
}

/*
function: delete_relationi
purpose: delete relation by itemid
*/
function delete_relationi($itemid){
	$return["success"]="false";
	if ($itemid>0){
		$database = Database::getDatabase();
		$database->query("delete from catrel where itemid=$itemid;");
		$return["success"]="true";
	}
	return $return;
}

/*
function: delete_tree
purpose: delete tree
*/
function delete_tree($treeid){
	$return["success"]="false";
	if ($treeid>0){
		$database = Database::getDatabase();
		$database->query("delete from trees where treeid=$treeid;");
		$database->query("delete from categories where treeid=$treeid;");
		$item=new item;
		$item->delete_item("trees",$treeid);
		$return["success"]="true";
	}
	return $return;
}

/*
function: delete_category
purpose: delete category
*/
function delete_category($catid){
	$return["success"]="false";
	if ($catid>0){
		$database = Database::getDatabase();
		$database->query("delete from categories where catid=$catid");
		$item=new item;
		$item->delete_item("categories",$catid);
		$return["success"]="true";
	}
	return $return;
}

/*
function: update_category
purpose: update category
*/
function update_category($catid,$title,$details){
	$return["success"]="false";
	if ($catid>0 and $title<>"" and $details<>""){
		$database = Database::getDatabase();
		$database->query("update categories set title='$title',details='$details' where catid=$catid;");
		$return["success"]="true";
	}
	return $return;
}

/*
function: get_categories
purpose: get categories
*/
function get_categories($treeid){
	$return["success"]="false";
	if ($treeid>0){
		$database = Database::getDatabase();
		$cats=$database->query("select title,details,catid,parent from categories where treeid=$treeid");
		for ($cat=0;$cat<$database->num_rows($cats);$cat++){
			$return["title[$cat]"]=$database->fetch_result($cats,$cat,'title');
			$return["details[$cat]"]=$database->fetch_result($cats,$cat,'details');
			$return["catid[$cat]"]=$database->fetch_result($cats,$cat,'catid');
			$return["parent[$cat]"]=$database->fetch_result($cats,$cat,'parent');
			$return["count"]++;
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: get_parent
purpose: get parent
*/
function get_parent($catid){
	$return["success"]="false";
	if ($catid>0){
		$database = Database::getDatabase();
		$parent=$database->query("select parent from categories where catid=$catid;");
		if ($database->num_rows($parent)==1){
			$return["parent"]=$database->fetch_result($parent,0,'parent');
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: get_subs
purpose: get subs
*/
function get_subs($treeid,$catid){
	$return["success"]="false";
	if ($treeid>0 and $catid>=0){
		if ($catid==""){$catid=0;}
		$database = Database::getDatabase();
		$tree=$database->query("select title from trees where treeid=$treeid");
		if ($database->num_rows($tree)==1){
			$return["treetitle"]=$database->fetch_result($tree,0,'title');
			$cat=$database->query("select title,details from categories where treeid=$treeid and catid=$catid;");
			if ($database->num_rows($cat)==1 or $catid==0){
				if ($catid>0){
					$return["title"]=$database->fetch_result($cat,0,'title');
					$return["details"]=$database->fetch_result($cat,0,'details');
				}
				$subs=$database->query("select title,details,catid from categories where treeid=$treeid and parent=$catid;");
				for ($sub=0;$sub<$database->num_rows($subs);$sub++){
					$return["title[$sub]"]=$database->fetch_result($subs,$sub,'title');
					$return["details[$sub]"]=$database->fetch_result($subs,$sub,'details');
					$return["catid[$sub]"]=$database->fetch_result($subs,$sub,'catid');
					$return["count"]++;
				}
				$return["success"]="true";
			}
		}
	}
	return $return;
}

/*
function: get_trees
purpose: get trees
*/
function get_trees(){
	$return["success"]="true";
	$database = Database::getDatabase();
	$trees=$database->query("select title,treeid from trees;");
	for ($tree=0;$tree<$database->num_rows($trees);$tree++){
		$return["title[$tree]"]=$database->fetch_result($trees,$tree,'title');
		$return["treeid[$tree]"]=$database->fetch_result($trees,$tree,'treeid');
		$return["count"]++;
	}
	return $return;
}

/*
function: get_tree
purpose: get tree
*/
function get_tree($treeid){
	$return["success"]="true";
	if ($treeid>0){
		$database = Database::getDatabase();
		$tree=$database->query("select title,treeid from trees where treeid=$treeid;");
		if ($database->num_rows($tree)==1){
			$return["title"]=$database->fetch_result($tree,0,'title');
			$return["treeid"]=$database->fetch_result($tree,0,'treeid');
			$return["success"]="true";
		}
	}
	return $return;
}

}
?>
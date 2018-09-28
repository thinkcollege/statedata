<?php   
/*
class: permission
purpose: user permission management
*/
class permission extends mre_base{
/*
function: add_permission
purpose: add permission
*/
function add_permission($userid,$read,$write,$admin,$itemid){
	$return["success"]="false";
	if ($userid<>"" and $read<>"" and $write<>"" and $admin<>"" and $itemid<>""){
		$database = Database::getDatabase();
		$check=$database->query("select rightid from rights where userid=$userid and itemid=$itemid");
		if ($database->num_rows($check)==0){
			$database->query("insert into rights(userid,canread,canwrite,canadmin,itemid) values($userid,'$read','$write','$admin',$itemid);");
		}else{
			$database->query("update rights set canread='$read',canwrite='$write',canadmin='$admin' where userid=$userid and itemid=$itemid");
		}
		$return["success"]="true";
	}
	return $return;
}

/*
function: delete_permission
purpose: delete a permission
*/
function delete_permission($rightid){
	$return["success"]="false";
	if ($rightid<>""){
		$database = Database::getDatabase();
		$database->query("delete from rights where rightid=$rightid;");
		$return["success"]="true";
	}
	return $return;
}

/*
function: get_permission
purpose: get a permission
*/
function get_permission($userid,$itemid){
	$return["success"]="false";
	if ($userid>=0 and $itemid>=0){
		$database = Database::getDatabase();
		$query = "select canread,canwrite,canadmin from rights where (userid=$userid or userid=0) and (itemid=$itemid or itemid=1) order by canread asc,canwrite asc,canadmin asc;";
		$permission=$database->query($query);
		if ($database->num_rows($permission)==0){
			$return["read"]=$this->permission_read;
			$return["write"]=$this->permission_write;
			$return["admin"]=$this->permission_admin;
		}else{
			$return["read"]=$database->fetch_result($permission,0,'canread');
			$return["write"]=$database->fetch_result($permission,0,'canwrite');
			$return["admin"]=$database->fetch_result($permission,0,'canadmin');
		}
		if ($return["read"]=="t"){
			$return["read"]="true";
		} elseif ($return["read"]=="f"){
			$return["read"]="false";
		}
		if ($return["write"]=="t"){
			$return["write"]="true";
		} elseif ($return["write"]=="f"){
			$return["write"]="false";
		}
		if ($return["admin"]=="t"){
			$return["admin"]="true";
		} elseif ($return["admin"]=="f"){
			$return["admin"]="false";
		}
		$return["success"]="true";
	}
	return $return;
}

/*
function: get_permissions
purpose: get all permissions
*/
function get_permissions(){
	$database = Database::getDatabase();
	$return["success"]="false";
	$permissions=$database->query("select rightid,canread,canwrite,canadmin,userid,itemid from rights");
	for ($permission=0;$permission<$database->num_rows($permissions);$permission++){
		$return["read[$permission]"]=$database->fetch_result($permissions,$permission,'canread');
		$return["write[$permission]"]=$database->fetch_result($permissions,$permission,'canwrite');
		$return["admin[$permission]"]=$database->fetch_result($permissions,$permission,'canadmin');
		if ($return["read[$permission]"]=="t"){
			$return["read[$permission]"]="true";
		} elseif ($return["read[$permission]"]=="f"){
			$return["read[$permission]"]="false";
		}
		if ($return["write[$permission]"]=="t"){
			$return["write[$permission]"]="true";
		} elseif ($return["write[$permission]"]=="f"){
			$return["write[$permission]"]="false";
		}
		if ($return["admin[$permission]"]=="t"){
			$return["admin[$permission]"]="true";
		} elseif ($return["admin[$permission]"]=="f"){
			$return["admin[$permission]"]="false";
		}
		$return["userid[$permission]"]=$database->fetch_result($permissions,$permission,'userid');
		$return["itemid[$permission]"]=$database->fetch_result($permissions,$permission,'itemid');
		$return["rightid[$permission]"]=$database->fetch_result($permissions,$permission,'rightid');
		$return["count"]++;
		$return["success"]="true";
	}
	return $return;
}

}
?>
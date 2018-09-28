<?php    
/*
class: filesystem
purpose: filesystem management
*/
class filesystem extends mre_base{

/*
function: add_folder
purpose: add folder
*/
function add_folder($foldername){
	$return["success"]="false";
	if ($foldername<>""){
		if (@mkdir($this->filesystem_path.$foldername,0700)){
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: delete_folder
purpose: delete folder
*/
function delete_folder($foldername){
	$return["success"]="false";
	if ($foldername<>""){
		if (@rmdir($this->filesystem_path.$foldername)){
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: add_file
purpose: add file
*/
function add_file($folder,$file){
	$return["success"]="false";
	if ($file<>""){
		if (@copy($file,$this->filesystem_path.ltrim(rtrim($folder,"/"),"/")."/".basename($file))){
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: delete_file
purpose: delete_file
*/
function delete_file($folder,$file){
	$return["success"]="false";
	if ($file<>""){
		if (@unlink($this->filesystem_path.ltrim(rtrim($folder,"/"),"/")."/".$file)){
			$return["success"]="true";
		}
	}
	return $return;
}

}
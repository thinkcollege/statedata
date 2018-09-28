<?php   
/*
class: bug
purpose: bug management
*/
class bug extends mre_base{

/*
function: add_bug
purpose: add a bug
*/
function add_bug($bug,$type,$userid){
//types:
//1: Error
//2: Suggestion
//3: Comment
//4: Typo
//5: Link
//6: Other
	$return["success"]="false";
	if ($bug<>"" and $type<>"" and $userid<>""){
		$database = Database::getDatabase();
		$bugdate=date("Y-m-d");
		$database->query("insert into bugs (bugtext,type,userid,bugdate) values('$bug',$type,$userid,'$bugdate');");
		$getid=$database->query("select bugid from bugs where bugtext='$bug' and type=$type and userid=$userid and bugdate='$bugdate';");
		if ($database->num_rows($getid)==1){
			$return["bugid"]=$database->fetch_result($getid,0,'bugid');
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: delete_bug
purpose: delete a bug
*/
function delete_bug($bugid){
	$return["success"]="false";
	if ($bugid<>""){
		$database = Database::getDatabase();
		$database->query("delete from bugs where bugid=$bugid;");
		$return["success"]="true";
	}
	return $return;
}

/*
function: get_bugs
purpose: get bugs
*/
function get_bugs(){
	$database = Database::getDatabase();
	$bugs=$database->query("select bugtext,type,bugdate,bugid,userid from bugs order by bugid desc");
	for ($bugrow=0; $bugrow < $database->num_rows($bugs); $bugrow++) {  
		if ($database->fetch_result($bugs,$bugrow,'type')==1) { $type="Error";}
		if ($database->fetch_result($bugs,$bugrow,'type')==2) { $type="Suggestion";}
		if ($database->fetch_result($bugs,$bugrow,'type')==3) { $type="Comment";}
		if ($database->fetch_result($bugs,$bugrow,'type')==4) { $type="Typo";}
		if ($database->fetch_result($bugs,$bugrow,'type')==5) { $type="Link error";}
		if ($database->fetch_result($bugs,$bugrow,'type')==6) { $type="Other";}
		$return["type[$bugrow]"]=$type;
		$return["bugtext[$bugrow]"]=nl2br($database->fetch_result($bugs,$bugrow,'bugtext'));
		$return["bugdate[$bugrow]"]=$database->fetch_result($bugs,$bugrow,'bugdate');
		$return["bugid[$bugrow]"]=$database->fetch_result($bugs,$bugrow,'bugid');
		$return["userid[$bugrow]"]=$database->fetch_result($bugs,$bugrow,'userid');
		$return["number"]++;
	}
	return $return;
}

}
?>
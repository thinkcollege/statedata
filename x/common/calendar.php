<?php  
/*
class: calendar
purpose: calendar management
*/
class calendar extends mre_base{

/*
function: add_event
purpose: add event
*/
function add_event($userid,$starttime,$endtime,$title,$details){
	$return["success"]="false";
	if ($userid>0 and $starttime<>"" and $endtime<>"" and $title<>"" and $details<>""){
		$database = Database::getDatabase();
		$database->query("insert into schedule (userid,starttime,endtime,title,details) values($userid,'$starttime','$endtime','$title','$details');");
		$getid=$database->query("select scheduleid from schedule where userid=$userid and title='$title' and details='$details' order by scheduleid desc;");
		if ($database->num_rows($getid)==1){
			$return["id"]=$database->fetch_result($getid,0,'scheduleid');
			$items=new item;
			$items->add_item("schedule",$return["id"]);
			$item=$items->get_item("schedule",$return["id"]);
			$return["itemid"]=$item["itemid"];
			$permission=new permission;
			$permission->add_permission($userid,'t','t','t',$return["itemid"]);
			if ($this->calendar_emailid<>""){
				$notification=new notification;
				$thetemplate=$notification->get_email($this->calendar_emailid);
				if ($thetemplate["subject"]<>"" and $thetemplate["body"]<>""){
					$subject=$thetemplate["subjectsend"];
					$body=$thetemplate["bodysend"];
					$numbersent=0;
					$wanters=$notification->get_wanters($this->calendar_emailid);				
					$user=new user;
					for ($wanter=0; $wanter<$wanters["count"]; $wanter++){
						$emailbody=$body;
						$userinfo=$user->get_account($wanters["userid[$wanter]"]);
						$notification=new notification;
						$emailbody=str_replace("#first_name#",$userinfo["first_name"],$emailbody);
						$emailbody=str_replace("#last_name#",$userinfo["last_name"],$emailbody);
						$emailbody=str_replace("#event_title#",$title,$emailbody);
						$emailbody=str_replace("#event_text#",$details,$emailbody);
						$emailbody=str_replace("#event_url#",$this->mre_base_webpath.$this->calendar_url."?event=".$return["id"],$emailbody);
						$notification->send_email($userinfo["email"],$subject,$emailbody);
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
function: delete_event
purpose: delete event
*/
function delete_event($scheduleid){
	$return["success"]="false";
	if ($scheduleid>0){
		$database = Database::getDatabase();
		$database->query("delete from schedule where scheduleid=$scheduleid;");
		$items=new item;
		$item=$items->get_item('schedule',$scheduleid);
		$item=$item["itemid"];
		$database->query("delete from rights where itemid=$item");
		$items->delete_item('schedule',$scheduleid);
		$return["success"]="true";
	}
	return $return;
}

/*
function: edit_event
purpose: edit event
*/
function edit_event($scheduleid,$starttime,$endtime,$title,$details){
	$return["success"]="false";
	if ($scheduleid>0 and $starttime<>"" and $endtime<>"" and $title<>"" and $details<>""){
		$database = Database::getDatabase();
		$database->query("update schedule set starttime='$starttime',endtime='$endtime',title='$title',details='$details' where scheduleid=$scheduleid;");
		$return["success"]="true";
	}
	return $return;
}

/*
function: get_event
purpose: get event
*/
function get_event($scheduleid){
	$return["success"]="false";
	if ($scheduleid>0){
		$database = Database::getDatabase();
		$event=$database->query("select userid,starttime,endtime,title,details,scheduleid from schedule where scheduleid=$scheduleid");
		if ($database->num_rows($event)==1){
			$return["userid"]=$database->fetch_result($event,0,'userid');
			$return["starttime"]=$database->fetch_result($event,0,'starttime');
			$return["endtime"]=$database->fetch_result($event,0,'endtime');
			if ($this->database_type=="postgresql"){
				$datepart = explode("-", $return["starttime"]);
				$timepart = explode(" ", $return["starttime"]);
				$timepart=$timepart[1];
				$timepart = explode(":", $timepart);
				$return["formatstart"]=date("D M d, Y g:i a", mktime($timepart[0],$timepart[1],0, $datepart[1], $datepart[2], $datepart[0]));				
				$datepart = explode("-", $return["endtime"]);
				$timepart = explode(" ", $return["endtime"]);
				$timepart=$timepart[1];
				$timepart = explode(":", $timepart);
				$return["formatend"]=date("D M d, Y g:i a", mktime($timepart[0],$timepart[1],0, $datepart[1], $datepart[2], $datepart[0]));
			}
			if ($this->database_type=="mysql"){
				$startend=$database->query("select UNIX_TIMESTAMP(starttime) as starttime, UNIX_TIMESTAMP(endtime) as endtime from schedule where scheduleid=$scheduleid;");
				$starttime=$database->fetch_result($startend,0,'starttime');
				$endtime=$database->fetch_result($startend,0,'endtime');
				$return["formatstart"]=date("D M d, Y g:i a",$starttime);
				$return["formatend"]=date("D M d, Y g:i a",$endtime);
			}
			$functions=new functions;
			$return["title"]=$database->fetch_result($event,0,'title');
			$return["details"]=$functions->safehtml(nl2br($database->fetch_result($event,0,'details')));
			$return["formdetails"]=$database->fetch_result($event,0,'details');
			$return["scheduleid"]=$database->fetch_result($event,0,'scheduleid');
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: get_events
purpose: get events
*/
function get_events(){
	$return["success"]="false";
	$database = Database::getDatabase();
	$events=$database->query("select userid,starttime,endtime,title,details,scheduleid from schedule order by scheduleid desc;");
	for ($event=0;$event<$database->num_rows($events);$event++){
		$functions=new functions;
		$return["userid[$event]"]=$database->fetch_result($events,$event,'userid');
		$return["starttime[$event]"]=$database->fetch_result($events,$event,'starttime');
		$return["endtime[$event]"]=$database->fetch_result($events,$event,'endtime');
		$return["title[$event]"]=$database->fetch_result($events,$event,'title');
		$return["details[$event]"]=$functions->safehtml(nl2br($database->fetch_result($events,$event,'details')));
		$return["scheduleid[$event]"]=$database->fetch_result($events,$event,'scheduleid');
		$return["count"]++;
		$return["success[$event]"]="true";
	}
	return $return;
}

/*
function: make_calendar
purpose: make a calendar
*/
function make_calendar($month,$year){
	$return["success"]="false";
	if (13>$month and 0<$month and $year>0){
		$database = Database::getDatabase();
		$month = (isset($month)) ? $month : date("n",time());  
  		$year = (isset($year)) ? $year : date("Y",time());  
  		$today = (isset($today))? $today : date("j", time());  
		$numdays = date("t",mktime(1,1,1,$month,1,$year)); 
		$wdays = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat'); 
		$return["code"].='<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#000000">';
		$return["code"].='<tr>';
		foreach($wdays as $value) {
			$return["code"].='<td width="14%">';
			$return["code"].='<div align="center"><b>'.$value.'</b></div>';
			$return["code"].='</td>';
		}
		$return["code"].='</tr>';
		$return["code"].='<tr align="left" valign="top"  height="70">';
		for ($i = 0; $i < $dayone = date("w",mktime(1,1,1,$month,1,$year)); $i++) {
			$return["code"].='<td width="14%" height="70">&nbsp;</td>';
		} 
		for ($zz = 1; $zz <= $numdays; $zz++) { 
		if ($i >= 7) {
			$return["code"].='</tr>';
			$return["code"].='<tr align="left" valign="top" height="70">';
			$i=0;  } 
			if ($zz == $today) { 
				$return["code"].='<td width="14%">';
				$return["code"].='<b>'.$zz.'</b><br>';
				$openday=date("Y-m-d H:i",mktime(0,0,0,$month,$zz,$year));
				$closeday=date("Y-m-d H:i",mktime(23,59,59,$month,$zz,$year));
				$events=$database->query("select title,scheduleid from schedule where starttime between '$openday' and '$closeday' order by starttime desc;");
				for ($event=0; $event < $database->num_rows($events); $event++) {
					$return["code"].='<img src="../images/bullet.gif"><a href="event.php?event='.$database->fetch_result($events,$event,"scheduleid").'">';
					$return["code"].=$database->fetch_result($events,$event,"title");
					$return["code"].='</a> <br>';
				}
				$return["code"].='</td>';
			} else {
				$return["code"].='<td width="14%">';
				$return["code"].='<b>'.$zz.'</b><br>';
				$openday=date("Y-m-d H:i",mktime(0,0,0,$month,$zz,$year));
				$closeday=date("Y-m-d H:i",mktime(23,59,59,$month,$zz,$year));
				$events=$database->query("select title,scheduleid from schedule where starttime between '$openday' and '$closeday' order by starttime desc;");
				for ($event=0; $event < $database->num_rows($events); $event++) {
					$return["code"].='<img src="../images/bullet.gif"><a href="event.php?event='.$database->fetch_result($events,$event,"scheduleid").'">';
					$return["code"].=$database->fetch_result($events,$event,"title").'</a><br>';
				}
				$return["code"].='</td>';
			} 
			$i++; 
		}   
		$return["code"].='</tr>';
		$return["code"].='</table>';
		$return["success"]="true";
	}
	return $return;
}

}
?>
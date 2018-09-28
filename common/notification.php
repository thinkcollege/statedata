<?php   
/* 
class: notification
purpose: email notification management
*/
class notification extends mre_base{

/*
function: change_preference
purpose: change user notification preference
*/
function change_preference($userid,$emailid,$send){
	$return["success"]="false";
	if ($emailid<>"" and $send<>""){
		$database = Database::getDatabase();
		$check=$database->query("select notifid from notification where userid=$userid and emailid=$emailid");
		if ($database->num_rows($check)==0){
			$database->query("insert into notification(userid,emailid,send) values($userid,$emailid,'$send');");
			$return["success"]="true";
		} else {
			$notifid=$database->fetch_result($check,0,'notifid');
			$database->query("update notification set send='$send' where notifid=$notifid;");
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: delete_preference
purpose: delete user notification preference
*/
function delete_preference($preference,$userid){
	$return["success"]="false";
		if ($preference<>"" and $userid<>""){
			$database = Database::getDatabase();
			$database->query("delete from notification where notifid=$preference and userid=$userid;");
			$return["success"]="true";
		}
	return $return;
}

/*
function: get_preferences
purpose: get user notification preferences
*/
function get_preferences($userid){
	$database = Database::getDatabase();
	$notifications=$database->query("select emailid,send,notifid from notification where userid=$userid");
	$return["success"]=="false";
		for ($notification=0;$notification<$database->num_rows($notifications);$notification++){
			$emailinfo=$database->query("select body,subject from emails where emailid=".$database->fetch_result($notifications,$notification,'emailid'));
			$return["subject[$notification]"]=$database->fetch_result($emailinfo,0,'subject');
			$return["body[$notification]"]=$database->fetch_result($emailinfo,0,'body');
			$return["notifid[$notification]"]=$database->fetch_result($notifications,$notification,'notifid');
				if ($database->fetch_result($notifications,$notification,'send')=="t"){
					$return["send[$notification]"]="true";
				}
				if ($database->fetch_result($notifications,$notification,'send')=="f"){
					$return["send[$notification]"]="false";
				}
			$return["emailid[$email]"]=$database->fetch_result($notifications,$notificaiton,'emailid');
			$return["prefcount"]++;
			$return["success"]="true";
		}
	return $return;
}

/*
function: get_emails
purpose: get emails
*/
function get_emails(){
	$database = Database::getDatabase();
	$emails=$database->query("select emailid,subject,body from emails");
	$return["success"]="false";
	for ($email=0;$email<$database->num_rows($emails);$email++){
		$return["emailid[$email]"]=$database->fetch_result($emails,$email,'emailid');
		$return["subject[$email]"]=$database->fetch_result($emails,$email,'subject');
		$return["body[$email]"]=$database->fetch_result($emails,$email,'body');
		$return["emailcount"]++;
		$return["success"]="true";
	}
	return $return;
}

/*
function: get_email
purpose: get email
*/
function get_email($emailid){
	$return["success"]="false";
	if ($emailid<>""){
		$database = Database::getDatabase();
		$email=$database->query("select emailid,subject,body from emails where emailid=$emailid");
		$return["emailid"]=$database->fetch_result($email,0,'emailid');
		$return["subject"]=$database->fetch_result($email,0,'subject');
		$return["body"]=$database->fetch_result($email,0,'body');
		$return["subjectsend"]=stripslashes($database->fetch_result($email,0,'subject'));
		$return["bodysend"]=stripslashes($database->fetch_result($email,0,'body'));
		$return["success"]="true";
	}
	return $return;
}

/*
function: add_email
purpose: add an email
*/
function add_email($subject,$body){
	$return["success"]="false";
	if ($subject<>"" and $body<>""){
		$database = Database::getDatabase();
		$database->query("insert into emails (subject,body) values ('$subject','$body');");
		$emailid=$database->query("select emailid from emails where subject='$subject' and body='$body';");
		$emailid=$database->fetch_result($emailid,0,'emailid');
		$items=new item;
		$items->add_item('emails',$emailid);
		$return["success"]="true";
	}
return $return;
}

/*
function: update_email
purpose: update an email
*/
function update_email($emailid,$subject,$body){
	$return["success"]="false";
	if ($emailid<>"" and $subject<>"" and $body<>""){
		$database = Database::getDatabase();
		$database->query("update emails set subject='$subject',body='$body' where emailid=$emailid;");
		$return["success"]="true";
	}
	return $return;
}

/*
function: delete_email
purpose: delete an email
*/
function delete_email($emailid){
	$return["success"]="false";
	if ($emailid<>""){
		$database = Database::getDatabase();
		$database->query("delete from emails where emailid=$emailid;");
		$items=new item;
		$items->delete_item('emails',$emailid);
		$return["success"]="true";
	}
	return $return;
}

/*
function: send_email
purpose: send an email
*/
function send_email($to,$subject,$body){
	$return["success"]="false";
	echo"here";
	if ($subject<>"" and $body<>"" and $to<>""){
		$mail=new Mail;
		$mail->From($this->email_from);
		$mail->To($to);
		$subject=stripslashes($subject);
		$mail->Subject($subject);
		$body=stripslashes($body);
		$mail->Body($body);
		$mail->Priority(1);
		$mail->Send();
		$this->log_email($to,$subject,$body);
	}
}

function log_email($to,$subject,$body){
	$database = Database::getDatabase();
	
	$query = sprintf("insert into sent_emails (toemail, fromemail, subject,body) values ('%s','%s','%s','%s');",
				mysql_real_escape_string($to),
	            mysql_real_escape_string($this->email_from),
				mysql_real_escape_string($subject),
				mysql_real_escape_string($body)
				);
	$database->query($query);
	
}

/*
function: get_wanters
purpose: get people who want an email
*/
function get_wanters($emailid){
	$return["success"]="false";
	if ($emailid>0){
		$database = Database::getDatabase();
		$users=$database->query("select email,userid from users;");
		for ($user=0;$user<$database->num_rows($users);$user++){
			$userid=$database->fetch_result($users,$user,'userid');
			$check=$database->query("select userid from notification where emailid=$emailid and send='f' and userid=$userid;");
			if ($database->num_rows($check)<1){
				$return["email[$user]"]=$database->fetch_result($users,$user,'email');
				$return["userid[$user]"]=$database->fetch_result($users,$user,'userid');
				$return["count"]++;
			}
		}
		$return["success"]="true";
	}
	return $return;
}

}
?>
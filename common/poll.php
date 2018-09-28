<?php   
/*
class: poll
purpose: poll management
*/
class poll extends mre_base{

/*
function: add_poll
purpose: add a poll
*/
function add_poll($question,$atext,$btext,$ctext,$dtext){
	$return["success"]="false";
	if ($question<>"" and $atext<>"" and $btext<>"" and $ctext<>"" and $dtext<>""){
		$database = Database::getDatabase();
		$database->query("insert into polls (question,atext,btext,ctext,dtext,votes) values('$question','$atext','$btext','$ctext','$dtext',0);");
		$return["success"]="true";
	}
	return $return;
}

/*
function get_polls
purpose: get polls
*/
function get_polls(){
	$return["success"]="false";
	$database = Database::getDatabase();
	$polls=$database->query("select question,atext,btext,ctext,dtext,pollid from polls;");
	for ($poll=0;$poll<$database->num_rows($polls);$poll++){
		$return["question[$poll]"]=$database->fetch_result($polls,$poll,'question');
		$return["pollid[$poll]"]=$database->fetch_result($polls,$poll,'pollid');
		$return["atext[$poll]"]=$database->fetch_result($polls,$poll,'atext');
		$return["btext[$poll]"]=$database->fetch_result($polls,$poll,'btext');
		$return["ctext[$poll]"]=$database->fetch_result($polls,$poll,'ctext');
		$return["dtext[$poll]"]=$database->fetch_result($polls,$poll,'dtext');
		$return["count"]++;
		$return["success"]="true";
	}
	return $return;
}

/*
function get_poll
purpose: get poll
*/
function get_poll($pollid){
	$return["success"]="false";
	$database = Database::getDatabase();
	$poll=$database->query("select question,atext,btext,ctext,dtext,pollid from polls where pollid=$pollid;");
	if ($database->num_rows($poll)==1){
		$return["question"]=$database->fetch_result($poll,0,'question');
		$return["pollid"]=$database->fetch_result($poll,0,'pollid');
		$return["atext"]=$database->fetch_result($poll,0,'atext');
		$return["btext"]=$database->fetch_result($poll,0,'btext');
		$return["ctext"]=$database->fetch_result($poll,0,'ctext');
		$return["dtext"]=$database->fetch_result($poll,0,'dtext');
		$return["success"]="true";
	}
	return $return;
}


/*
function edit_poll
purpose: edit a poll
*/
function edit_poll($pollid,$question,$atext,$btext,$ctext,$dtext){
	$return["success"]="false";
	if ($pollid>0 and $question<>"" and $atext<>"" and $btext<>"" and $ctext<>"" and $dtext<>""){
		$database = Database::getDatabase();
		$poll=$database->query("select pollid from polls where pollid=$pollid");
		if ($database->num_rows($poll)==1){
			$database->query("update polls set question='$question',atext='$atext',btext='$btext',ctext='$ctext',dtext='$dtext' where pollid=$pollid;");
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function delete_poll
purpose: delete a poll
*/
function delete_poll($pollid){
	$return["success"]="false";
	if ($pollid>0){
		$database = Database::getDatabase();
		$poll=$database->query("delete from polls where pollid=$pollid");
		$return["success"]="true";
	}
	return $return;
}

/*
function: vote
purpose: vote on a poll
*/
function vote($pollid,$vote){
	$return["success"]="false";
	if ($pollid>0 and ($vote=="a" or $vote=="b" or $vote=="c" or $vote=="d")){
		$database = Database::getDatabase();
		$poll=$database->query("select pollid from polls where pollid=$pollid");
		if ($database->num_rows($poll)==1){
			if ($vote=="a"){
				$votes=$database->query("select avotes from polls where pollid=$pollid;");
				$votesnew=$database->fetch_result($votes,0,'avotes');
				$votesnew++;
				$database->query("update polls set avotes=$votesnew");
			}
			if ($vote=="b"){
				$votes=$database->query("select bvotes from polls where pollid=$pollid;");
				$votesnew=$database->fetch_result($votes,0,'bvotes');
				$votesnew++;
				$database->query("update polls set bvotes=$votesnew");
			}
			if ($vote=="c"){
				$votes=$database->query("select cvotes from polls where pollid=$pollid;");
				$votesnew=$database->fetch_result($votes,0,'cvotes');
				$votesnew++;
				$database->query("update polls set cvotes=$votesnew");
			}
			if ($vote=="d"){
				$votes=$database->query("select dvotes from polls where pollid=$pollid;");
				$votesnew=$database->fetch_result($votes,0,'dvotes');
				$votesnew++;
				$database->query("update polls set dvotes=$votesnew");
			}
				$votes=$database->query("select votes from polls where pollid=$pollid");
				$votes=$database->fetch_result($votes,0,'votes');
				$votes++;
				$database->query("update polls set votes=$votes");
			$return["success"]="true";
		}
	}
	return $return;
}

/*
function: make_poll
purpose: display a poll
*/
function make_poll($pollid){
	if ($pollid>0){
		$database = Database::getDatabase();
		$poll=$database->query("select question,atext,btext,ctext,dtext,avotes,bvotes,cvotes,dvotes,votes from polls where pollid=$pollid");
		if ($database->num_rows($poll)==1){
			if ($_POST["vote"]<>"true"){
				echo "<form name=\"poll\" method=\"post\" action=\"\">";
				echo "<b>".$database->fetch_result($poll,0,'question')."</b><br>";
				echo "<input type=\"radio\" name=\"choice\" value=\"a\">".$database->fetch_result($poll,0,'atext')."<br>";
				echo "<input type=\"radio\" name=\"choice\" value=\"b\">".$database->fetch_result($poll,0,'btext')."<br>";
				echo "<input type=\"radio\" name=\"choice\" value=\"c\">".$database->fetch_result($poll,0,'ctext')."<br>";
				echo "<input type=\"radio\" name=\"choice\" value=\"d\">".$database->fetch_result($poll,0,'dtext')."<br>";
				echo "<input type=\"hidden\" name=\"vote\" value=\"true\">";
				echo "<input type=\"submit\" name=\"Submit\" value=\"Vote\">";
				echo "</form>";
			}else{
				$this->vote($pollid,$_POST["choice"]);
				$poll=$database->query("select question,atext,btext,ctext,dtext,avotes,bvotes,cvotes,dvotes,votes from polls where pollid=$pollid");
				$votes=$database->fetch_result($poll,0,'votes');
				$anum=$database->fetch_result($poll,0,'avotes');
				if ($votes>0){$apercent=($anum/$votes)*200;}
				$bnum=$database->fetch_result($poll,0,'bvotes');
				if ($votes>0){$bpercent=($bnum/$votes)*200;}
				$cnum=$database->fetch_result($poll,0,'cvotes');
				if ($votes>0){$cpercent=($cnum/$votes)*200;}
				$dnum=$database->fetch_result($poll,0,'dvotes');
				if ($votes>0){$dpercent=($dnum/$votes)*200;}
				echo "<table width=\"400\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				echo "<tr><td colspan=2><b>".$database->fetch_result($poll,0,'question')."</b></td></tr>";
				echo "<tr><td width=1>".$database->fetch_result($poll,0,'atext')." </td><td align=\"left\"><img src=\"".$this->mre_base_webpath.$this->poll_percentimage."\" height=15 width=".$apercent."></td></tr>";
				echo "<tr><td width=1>".$database->fetch_result($poll,0,'btext')." </td><td align=\"left\"><img src=\"".$this->mre_base_webpath.$this->poll_percentimage."\" height=15 width=".$bpercent."></td></tr>";
				echo "<tr><td width=1>".$database->fetch_result($poll,0,'ctext')." </td><td align=\"left\"><img src=\"".$this->mre_base_webpath.$this->poll_percentimage."\" height=15 width=".$cpercent."></td></tr>";
				echo "<tr><td width=1>".$database->fetch_result($poll,0,'dtext')." </td><td align=\"left\"><img src=\"".$this->mre_base_webpath.$this->poll_percentimage."\" height=15 width=".$dpercent."></td></tr>";
				echo "<tr><td colspan=2>Votes: ".$votes."</td></tr>";
				echo "</table>";
			}
		}
	}
}

}
?>
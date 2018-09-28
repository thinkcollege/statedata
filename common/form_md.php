<?php
/*
class: form
purpose: useful form parts
*/
class form extends formBase{

static function build_login_form() {
	$result = form::build_box_top("Login");
	$result .= form::build_form_field (	array('value' => '', 'type' => 'text', 'varname' => 'email', 'label' => 'Email:'));
	$result .= "<br/>";
	$result .= form::build_form_field (	array('value' => '', 'type' => 'password', 'varname' => 'password', 'label' => 'Password:'));
	$result .= form::build_form_field (	array('value' => 'login', 'type' => 'hidden', 'varname' => 'a'));
	$result .= "<br/>";
	$result .= form::build_button("submit",'document.forms[0].submit();',0);

	$result .= form::build_box_bottom();
	return $result;
}

static function build_upload_form() {
	$result = form::build_box_top("Upload file");
	$result .= form::build_form_field (	array('value' => '', 'type' => 'file', 'varname' => 'uploadedfile', 'label' => 'Select file to upload:'));
	$result .= "<br/>";
	$result .= "(The file must be a .csv file)<br />";
	$result .= form::build_form_field (	array('value' => 'upload', 'type' => 'hidden', 'varname' => 'a'));
	$result .= "<br/>";
	$result .= form::build_button("submit",'document.forms[0].submit();',0);

	$result .= form::build_box_bottom();
	return $result;
}

static function build_box_top_div ($strLeft = "&nbsp;", $strRight= "&nbsp;") {
	$result=<<<BOX
			<div class="box b3">
				<div class="mr">

					<div class="ml">
						<div class="tr">
							<div class="tl">
								<span style="float:left;padding:5">$strLeft</span>
								<span style="float:right;padding:5">$strRight</span>

								<!--<h2>Box 3</h2>-->

							</div> <!-- eof tl -->
						</div> <!-- eof tr -->

						<div class="br">
							<div class="bl">
BOX;
	return $result;
}

static function build_box_bottom_div ()
{
$result=<<<BOX
						  </div> <!-- eof bl -->

						</div> <!-- eof br -->
					</div> <!-- eof ml -->
				</div> <!-- eof mr -->
			</div> <!-- eof box -->
BOX;
	return $result;
}


static function build_box_top ($strLeft = "&nbsp;", $strRight= "&nbsp;",$color="", $onBoxClick="")
{
	$boxId = uniqid('php_');
	$bgcolor = ($color == "")? "336699": $color;
	$color = ($color == "")? $color: $color . "_";
	$hl = $color . "hl_bl.gif";
	$hr = $color . "hr_bl.gif";
	$tl = $color . "tlb.gif";
	$tr = $color . "trb.gif";
	$ml = $color . "mlb.gif";
	$result = "";
	$cursor = "";
	if ($onBoxClick != "") {
		$cursor = ";cursor:pointer;";
		$result.=<<<BOX
		<script type="text/javascript">
			$(document).ready(function(){
				$("#$boxId").click(function(){
					$onBoxClick;
				});
			});

		</script>
		<style>
		
		#$boxId   {
			color: #000;
			cursor:pointer;
		}
		#$boxId:hover  {
			color: #a00000;
			cursor:pointer;
		}			
		</style>
BOX;
	}
	
	$result.=<<<BOX
<!-- ------------------------------------------------------------------------------- -->
<!-- SECTION BOX: $strLeft						     -->
<!-- ------------------------------------------------------------------------------- -->
				<div id="$boxId"  style="margin:10px">
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="border-collapse: collapse">
					<tr>
						<td><img border="0" src="/images/box/$hl" width="15" height="22"></td>
						<td bgcolor="#$bgcolor" width="100%">
							<table width="100%" border="0" cellpadding="0" style="border-collapse: collapse">
								<tr>
									<td><span class="boxleft">$strLeft</span></td>
									<td align="right">$strRight</td>
								</tr>
							</table>
						</td>
						<td><img border="0" src="/images/box/$hr" width="15" height="22"></td>
					</tr>
				</table>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td><img border="0" src="/images/box/$tl" width="15" height="15"></td>
						<td width="100%"><img border="0" src="/images/pixels/spacer.gif" width="15" height="15"></td>
						<td><img border="0" src="/images/box/$tr" width="15" height="15"></td>
					</tr>
				</table>
				<table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" >
					<tr>
						<td background="/images/box/$ml"><img border="0" src="/images/box/$ml" width="15" height="15"></td>
						<td width="100%" valign="top" class="inner_content">
BOX;
return $result;
}


static function build_box_bottom ($color="",$strBottom = "&nbsp;")
{
$color = ($color == "")? $color: $color . "_";
$bgcolor = ($color == "")? "336699": $color;
$mr = $color . "mrb.gif";
$bl = $color . "blb.gif";
$bm = $color . "bmb.gif";
$br = $color . "brb.gif";
$result=<<<BOX
						</td>
						<td background="/images/box/$mr"><img border="0" src="/images/box/$mr" width="15" height="15"></td>
					</tr>
				</table>
				<table border="0" cellpadding="0" style="border-collapse: collapse" width="100%">
					<tr>
						<td><img border="0" src="/images/box/$bl" width="15" height="15"></td>
						<td background="/images/box/$bm" width="100%">
						<img border="0" src="/images/box/$bm" width="5" height="15"></td>
						<td><img border="0" src="/images/box/$br" width="15" height="15"></td>
					</tr>
					<tr>
						<td colspan="3" valign="top" style="font-size:0;" >
							$strBottom
						</td>
					</tr>
				</table>
			</div>
<!-- ------------------------------------------------------------------------------- -->
<!-- END SECTION BOX																 -->
<!-- ------------------------------------------------------------------------------- -->
BOX;
return $result;
}

static function build_msg($msg, $custom_type = "", $custom_msg = "") {
	global $msgs;
	$result = "<div>";
	$text = "";
	$type = "";
	if ($msg != "") {
		$text = $msgs[$msg]["msg"];
		$type = $msgs[$msg]["type"];
	}
	if ($custom_msg !="") {
		$text = $custom_msg;
	}
	if ($custom_type != "") {
		$type = $custom_type;
	}
	switch ($type) {
		case "info":
		  $result .= "<img src=\"images/icons/MSG_Info.gif\"/><span>".$text."</span>";
		  break;
		case "help":
		  $result .= "<img src=\"images/icons/MSG_Help.gif\"/><span>".$text."</span>";
		  break;
		case "error":
		  $result .= "<img src=\"images/icons/MSG_Error.gif\"/><span class=\"AlertError\">".$text."</span>";
		  break;
		case "alert":
		  $result .= "<img src=\"images/icons/MSG_Warning.gif\"/><span class=\"AlertError\">".$text."</span>";
		  break;
	}

	$result .= "</div>";
	return $result;
}

/*
function: build_table_heading
purpose: creates a row with the given values in an array
*/
static function build_table_heading ($cols, $start_cols = "", $end_cols="") {
	$result = "<thead><tr>" . TABBREAK;
	$result .= $start_cols . NEWLINE;

	foreach ($cols as $value) {
		$result .= "<th scope=\"col\">" . $value["name"] . "</th>" . NEWLINE;
	}
	$result .= $end_cols;
	$result .="</tr></thead>";
	return $result;
}
}
?>
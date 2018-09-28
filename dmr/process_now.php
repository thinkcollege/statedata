
<?
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$phone = $_REQUEST['phone'];
$state = $_REQUEST['state'];
$organization = $_REQUEST['organization'];
$comment = $_REQUEST['comment'];
$subject = $_REQUEST['subject'];

$message =
 "name: ".$name. "\n\n".  
"email: ".$email. "\n\n".
"phone: ".$phone. "\n\n".
"state: ".$state. "\n\n".
"organization: ".$organization. "\n\n".
"browser/platform: ".$_SERVER['HTTP_USER_AGENT']. "\n\n".
"comment/inquiry: ".$comment."\n"; 

 ?>
<p><blockquote>
<? if($subject == "DMR - feedback"){
	$to = "jeff.coburn@umb.edu, statedata@gmail.com, Frank.Smith@umb.edu";
	$subject="$subject"." ($name)";
mail($to, $subject, $message);
    ?>
    Thank you for your feedback. Should follow-up be required, sombody from the Institute for Community Inclusion will be in contact with you. Please start a new query by making a selection from the navigation menu, or <a href="/dmr/index.php">return to the home page</a>
<? }
 if($subject == "DMR - feedback"){
	 	$to = "john.butterworth@umb.edu, statedata@gmail.com, Frank.Smith@umb.edu";
	$subject="$subject"." ($name)";
mail($to, $subject, $message);
    ?>
Thank you for your inquiry. Should follow-up be required, sombody from the Institute for Community Inclusion will be in contact with you. Please start a new query by making a selection from the navigation menu, or <a href="/dmr/index.php">return to the home page</a>
<? }
?>
<br /><br /></blockquote></p>


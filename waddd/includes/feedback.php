<?php
if (count($_POST)) {
	$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
	$from = $user->getEmail();
	$org = isset($_POST['org']) ? $_POST['org'] : '';
	$comments = isset($_POST['comment']) ? $_POST['comment'] : '';
	
	if ($comments) {
		$headers = "From: {$user->getFirstName()} {$user->getLastName()} <$email>\r\n";
		$msg = $comments . "\n\n" . ($phone ? "Phone: $phone\n" : '') . ($org ? "Organization: $org" : '');
		mail('John Butterwork <john.butterworth@umb.edu', 'WA-DDD Feedback', $msg, $headers);
		$sent = true;
	} else if (!$comment) {
		error('Please provide some feedback!');
	} 
}
$template->addRegion('title','Feedback');
$template->addRegion('heading','Feedback');
$template->addRegion('content', '<p>Use the form below to submit to the webmaster any technical problems you are experiencing or significant data inconsistencies you observe. This form is only for technical difficulties with accessing data and reports. Questions about local level county employment outcomes can best be addressed by the local County Developmental Disabilities office <a href="http://www.dshs.wa.gov/pdf/adsa/ddd/county_coord.pdf">County Coordinator (PDF)</a>.</p>'
. (isset($sent) ? '<p class="success">Feedback send!</p>' : '') . '
<form action="./?page=feedback" method="post">
<p>Name: ' . $user->getFirstName() . ' ' . $user->getLastName() . '</p>
<p><label for="phone">Phone:</label>
<br /><input size="40" type="text" id="phone" name="phone" /></p>
<p><label for="org">Organization:</label>
<br /><input size="40" type="text" id="org" name="organization" /></p>
<p><label for="comment">Feedback/Inquiry:</label>
<br /><textarea rows=7 cols=60 id=question name="comment"></textarea>
<br />
<input type="submit" value="Send feedback" /></form>');
//write page
?>




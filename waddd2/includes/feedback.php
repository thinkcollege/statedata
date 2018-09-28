<?php
if (count($_POST)) {
	$phone = !empty($_POST['phone']) ? $_POST['phone'] : '';
	$from = !empty($_POST['email']) ? preg_replace('/[\00-\1F\7F]/', '', $_POST['email']) : '';
	$org = !empty($_POST['org']) ? preg_replace('/[\00-\1F\7F]/', '', $_POST['org']) : '';
	$comments = isset($_POST['comment']) ? preg_replace('/[\00-\09\0B-\1F\7F]/', '', $_POST['comment']) : '';
	if (empty($email)) {
		error("Please provide a valid email address.");
	} else if (!$comment) {
		error('Please provide some feedback!');
	} else if ($comments) {
		$headers = "From: {$user->getFirstName()} {$user->getLastName()} <$email>\r\n";
		$msg = $comments . "\n\n" . ($phone ? "Phone: $phone\n" : '') . ($org ? "Organization: $org" : '');
		mail('John Butterwork <john.butterworth@umb.edu', 'WA-DDD Feedback', $msg, $headers);
		$sent = true;
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

<?php
define('QUADODO_IN_SYSTEM', true);
require_once('../users/includes/header.php');
$qls->Security->check_auth_page('../members/index.php');
require_once("../common/classes.php");
?><!--[if lte IE 7]>
<h1 class="ieWarn" style="font-size: 1.3em; color: #bd3614; background color: #e6c0c0; border-top: 3px solid #bd3614; border-bottom: 3px solid #bd3614; margin: 0">Your browser is Internet Explorer version 7 or earlier.  This website will not function properly with this web browser.  <a href="http://update.microsoft.com">Update Internet Explorer</a>, or better yet, <a href="http://www.mozilla.org/en-US/firefox/new/">get the Firefox browser</a>.</h1>
<![endif]--><?php
if ($qls->user_info['username'] != '') {
	print "Welcome {$qls->user_info['username']},<br/>Below are the tools available to you.";
	if ($qls->Security->is_auth_page('../dds-eohhs/')) {
		print '<div style="width:50%;float:left">'
			. form::build_box_top("DDS Individual Placement Reporting Tool")
			. 'A tool for tracking job placements and their status. Each month new job placements need to be added and the status of the old ones needs to be updated.<br/><a href="../dds-eohhs/">Use tool</a>'
			. form::build_box_bottom() . '</div>';
	}
	if ($qls->user_info['group_id'] == 1 || $qls->user_info['group_id'] == 4 ) {
		print '<div style="width:50%;float:left">'
			. form::build_box_top("User Management Tool")
			. 'A tool for managing users and their group. This needs a lot of work, but for now you can use it to create admin level users. I still need to add functionality to support provider level users.<br/><a href="../users/admincp.php">Use tool</a>'
			. form::build_box_bottom() . '</div>';
	}
	if ($qls->Security->is_auth_page('../DMRDataUpload/index.php')) {
		print '<div style="width:50%;float:left;clear:left">'
			. form::build_box_top("DDS Data Upload Tool")
			. 'A tool adding individual data.<br/><a href="../DMRDataUpload/index.php">Use tool</a>'
			.  form::build_box_bottom() . '</div>';
	}
	if ($qls->Security->is_auth_page('../DMRDataUpload/admin/index.php')) {
		print '<div style="width:50%;float:left;clear:left">'
			. form::build_box_top("DDS Data Upload Admin Tool")
			. 'A admin tool to for managing the DDS Data Upload Tool.<br/><a href="../DMRDataUpload/admin/index.php">Use tool</a'
			. form::build_box_bottom() . '</div>';
	}
	/*<!--
	You are logged in as <?php echo $qls->user_info['username']; ?><br />
	Your email address is set to <?php echo $qls->user_info['email']; ?><br />
	There have been <b><?php echo $qls->hits('members.php'); ?></b> visits to this page.
	-->*/
	print '<div style="clear:both;text-align:center"><a href="../users/logout.php">Logout</a></div>';
} else {
	print 'You are currently not logged in. Please go to the <a href="../users/login.php">login page</a>.';
}

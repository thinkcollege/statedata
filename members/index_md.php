<?php
define('QUADODO_IN_SYSTEM', true);
require_once('../users/includes_md/header.php'); 
$qls->Security->check_auth_page('../members/index_md.php');

require_once("../common/classes_md.php");

if ($qls->user_info['username'] != '') { ?>
   <html><head><title>MDDA Employment Outcome Information System</title><style type="text/css"> .boxleft { color: #fff; } </style> </head><body>
<?php	print "Welcome {$qls->user_info['username']},<br/>Below are the tools available to you."; 
	
	if ($qls->user_info['group_id'] == 1 || $qls->user_info['group_id'] == 4 ) {
		print '<div style="width:50%;float:left">'
			. form::build_box_top("User Management Tool")
			. 'A tool for managing users and their group. This needs a lot of work, but for now you can use it to create admin level users. I still need to add functionality to support provider level users.<br/><a href="../users/admincp_md.php">Use tool</a>'
			. form::build_box_bottom() . '</div>';
	}
	if ($qls->Security->is_auth_page('../MDDADataUpload/index.php')) {
		print '<div style="width:50%;float:left;clear:left">'
			. form::build_box_top("MDDA Data Upload Tool")
			. 'A tool adding individual data.<br/><a href="../MDDADataUpload/index.php">Use tool</a>'
			.  form::build_box_bottom() . '</div>';
	}
	if ($qls->Security->is_auth_page('../MDDADataUpload/admin/index.php')) {
		print '<div style="width:50%;float:left;clear:left">'
			. form::build_box_top("MDDA Data Upload Admin Tool")
			. 'A admin tool to for managing the MDDA Data Upload Tool.<br/><a href="../MDDADataUpload/admin/index.php">Use tool</a'
			. form::build_box_bottom() . '</div>';
	}
	/*<!--
	You are logged in as <?php echo $qls->user_info['username']; ?><br />
	Your email address is set to <?php echo $qls->user_info['email']; ?><br />
	There have been <b><?php echo $qls->hits('members_md.php'); ?></b> visits to this page.
	-->*/
	print '<div style="clear:both;text-align:center"><a href="../users/logout_md.php">Logout</a></div>';
} else {
	print 'You are currently not logged in. Please go to the <a href="../users/login_md.php">login page</a>.';
} ?>
</body></html>
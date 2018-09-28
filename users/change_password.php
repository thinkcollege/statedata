<?php
define('QUADODO_IN_SYSTEM', true);
require_once('includes/header.php');
?>



<?php
/*** *** *** *** *** ***
* @package Quadodo Login Script
* @file    change_password.php
* @start   November 11th, 2007
* @author  Douglas Rennehan
* @license http://www.opensource.org/licenses/gpl-license.php
* @version 1.0.1
* @link    http://www.quadodo.com
*** *** *** *** *** ***
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*** *** *** *** *** ***
* Comments are always before the code they are commenting.
*** *** *** *** *** ***/

if ($qls->User->check_password_code()) {
	if (isset($_POST['process'])) {
		if ($qls->User->change_password()) {
		echo CHANGE_PASSWORD_SUCCESS;
		}
		else {
		printf($qls->User->change_password_error . CHANGE_PASSWORD_TRY_AGAIN, htmlentities(strip_tags($_GET['code']), ENT_QUOTES));
		}
	}
	else {
	require_once('html/change_password_form.php');
	}
}
else {
	// Are we just sending the email?
	if (!isset($_GET['code'])) {
		if (isset($_POST['process'])) {
			if ($qls->User->send_password_email()) {
   			$userarray = $qls->User->fetch_user_info($_REQUEST['username']);
            echo "<html><head><title>Password change link sent.</title></head><body><h2 style=\"width: 50%; padding: 50px 0 0 50px;\">Password change link sent.</h2><p style=\"width: 50%; padding: 10px 0 0 50px;\">The email was successfully sent to <strong>" . $userarray['email'] . "</strong>.  Please check your inbox for the link or ask your contact person to reset the password.  If this email should be changed for your organization, please contact <a href=\"mailto:ddsdata@statedata.info\">ddsdata@statedata.info</a></p></body></html>";
			}
			else {
			echo $qls->User->send_password_email_error . SEND_PASSWORD_EMAIL_TRY_AGAIN;
			}
		}
		else {
		require_once('html/request_password_change_form.php');
		}
	}
	else {
	echo CHANGE_PASSWORD_INVALID_CODE;
	}
}
?>
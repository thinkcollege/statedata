<?php
define('QUADODO_IN_SYSTEM', true);
require_once('includes_md/header.php');
$qls->Security->check_auth_registration();
?>



<?php
/*** *** *** *** *** ***
* @package Quadodo Login Script
* @file    register_md.php
* @start   July 25th, 2007
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

// Is the user logged in already?
if ($qls->user_info['username'] == '') {
	if (isset($_POST['process'])) {
		// Try to register the user
		if ($qls->User->register_user()) {
			switch ($qls->config['activation_type']) {
				default:
				echo REGISTER_SUCCESS_NO_ACTIVATION;
				break;
				case 1:
				echo REGISTER_SUCCESS_USER_ACTIVATION;
				break;
				case 2:
				echo REGISTER_SUCCESS_ADMIN_ACTIVATION;
				break;
			}
		}
		else {
		// Output register error
		echo $qls->User->register_error . REGISTER_TRY_AGAIN;
		}
	}
	else {
	// Get the random id for use in the form
	$random_id = $qls->Security->generate_random_id();
	require_once('html_md/register_form.php');
	}
}
else {
echo REGISTER_ALREADY_LOGGED;
}
?>
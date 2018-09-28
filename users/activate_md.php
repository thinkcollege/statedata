<?php
define('QUADODO_IN_SYSTEM', true);
require_once('includes_md/header.php');
?>



<?php
/*** *** *** *** *** ***
* @package Quadodo Login Script
* @file    activate.php
* @start   July 25th, 2007
* @author  Douglas Rennehan
* @license http://www.opensource.org/licenses/gpl-license.php
* @version 1.0.0
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

// Are they already logged in?
if ($qls->user_info['username'] == '') {
	// Pfft is user validation even turned on
	if ($qls->config['activation_type'] == 1) {
		// Try to activate them
		if ($qls->User->activate_user()) {
		echo ACTIVATE_SUCCESS;
		}
		else {
		echo $qls->User->activate_error;
		}
	}
	elseif ($qls->config['activation_type'] == 2) {
	echo ACTIVATE_ADMIN_VERFICATION;
	}
	else {
	echo ACTIVATE_NO_NEED;
	}
}
else {
echo ACTIVATE_ALREADY_LOGGED;
}
?>
<?php
/*** *** *** *** *** ***
* @package   Quadodo Login Script
* @file      database_info.php
* @author    Douglas Rennehan
* @generated December 23rd, 2008
* @link      http://www.quadodo.com
*** *** *** *** *** ***
* Comments are always before the code they are commenting
*** *** *** *** *** ***/
if (!defined('QUADODO_IN_SYSTEM')) {
exit;
}

define('SYSTEM_INSTALLED', true);
$database_prefix = 'user_';
$database_type = 'MySQL';
$database_server_name = 'localhost';
$database_username = 'mdda_user';
$database_password = 'f7Y6d9G8';
$database_name = 'mdda_db';
$database_port = false;

/**
 * Use persistent connections?
 * Change to true if you have a high load
 * on your server, but it's not really needed.
 */
$database_persistent = false;
?>
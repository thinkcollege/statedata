<?php
error_reporting(E_ALL);
	ini_set('display_errors', 'Off');
/*** *** *** *** *** ***
* @package Quadodo Login Script
* @file    admincp_md.php
* @start   July 26th, 2007
* @author  Douglas Rennehan
* @license http://www.opensource.org/licenses/gpl-license.php
* @version 2.0.0
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
define('QUADODO_IN_SYSTEM', true);
require_once('includes_md/header.php');

// Is the user logged in and an admin?
if ($qls->user_info['username'] != '') {
	if ($qls->user_info['auth_admin'] == 1) {
		// Find out which action we are doing
		switch ($_GET['do']) {
			case 'main':
			echo ADMIN_PANEL_WELCOME;
			break;
			case 'bulkinsert':
				echo "bulk user insert <br/>";
				$array = array();
				$array[] = "aditus_jd,ZRgXtaEh,43905";
				$array[] = "advancewithvac_jd,pekFzgm4,44003";
				$array[] = "advocatesinc_jd,exnk2yAx,43906";
				$array[] = "alternativesnet_jd,FynDxfCQ,43908";
				$array[] = "altsupports_jd,ttW7zkM9,43907";
				$array[] = "amegoinc_jd,u4GrdgTR,43909";
				$array[] = "americantrain_jd,DAZRbWWH,43910";
				$array[] = "arcsouthshore_jd,NPrd2BnD,43994";
				$array[] = "attleboro_jd,M2gB3jL9,43916";
				$array[] = "attleboroent_jd,JnQjsnCy,43916";
				$array[] = "autismserve_jd,gS7FHvtQ,43917";
				$array[] = "bamsi_jd,E4XGxzP9,43927";
				$array[] = "barrypricectr_jd,N2nUp4Eg,43918";
				$array[] = "baycove_jd,nHq8NnYq,43934";
				$array[] = "bc_jd,vYVcTBnH,43924";
				$array[] = "berkhills_jd,rEEUmXTE,50002";
				$array[] = "bestbuddies_jd,4a5YKunF,43922";
				$array[] = "bettercomm_jd,vHazbhUe,43923";
				$array[] = "bfair_jd,fRmQA3mh,43921";
				$array[] = "bridgewell_jd,9tWhADXu,43925";
				$array[] = "brockarc_jd,Rmfywcsf,43926";
				$array[] = "capeabilities_jd,TMpfGyV9,43929";
				$array[] = "ccworc_jd,LyRWsdQB,43932";
				$array[] = "charlesriverctr_jd,kfjdQEwf,43936";
				$array[] = "coletta_jd,K2f5zmTm,43930";
				$array[] = "commcon_jd,dbNhKYaJ,43937";
				$array[] = "comment_jd,bjq7YMRP,43938";
				$array[] = "commop_jd,KBWLmWrX,43939";
				$array[] = "coop_jd,dnGmYbX3,43941";
				$array[] = "crcmass_jd,AhPBWrsd,43931";
				$array[] = "cwsbos_jd,2j8PUt3v,43940";
				$array[] = "deltaprojects_jd,q6UtBtCg,43942";
				$array[] = "eliotchs_jd,rBAkFWuL,43945";
				$array[] = "empresources_jd,N8cbLnKv,43911";
				$array[] = "friendhome_jd,ASmCVcdA,50003";
				$array[] = "gaamha_jd,cGXkYwLC,43947";
				$array[] = "glec_jd,Nz6wyvkz,43950";
				$array[] = "goodwillmass_jd,XV4cBkj2,43974";
				$array[] = "growassoc_jd,6ZjCHbp6,43954";
				$array[] = "gwarc_jd,bkyMyvca,43953";
				$array[] = "gwmass_jd,4Dhcn4LS,43974";
				$array[] = "halcyonctr_jd,hSBsHHvE,43919";
				$array[] = "hmea_jd,gguykDcT,43955";
				$array[] = "houseyawk_jd,JTHJgd7t,50006";
				$array[] = "hru_jd,qGRsp8TX,43956";
				$array[] = "ici_jd,PSQyU3Lz,43957";
				$array[] = "ippi_jd,UCgfngJT,43958";
				$array[] = "jri1_jd,bNHmBbum,43960";
				$array[] = "jvsboston_jd,fvzAXtwM,43959";
				$array[] = "kdc_jd,pZmS9Ln4,43961";
				$array[] = "ledges_jd,AzRPNEwp,43962";
				$array[] = "lifefocus_jd,huLCsmbW,43963";
				$array[] = "lifestreaminc_jd,qEzzKRhW,43964";
				$array[] = "lifeworksma_jd,XuN4xapR,43965";
				$array[] = "mabcomm_jd,9hKbRSjA,43967";
				$array[] = "mayinstitute_jd,ALFY3GWG,43969";
				$array[] = "meccorp_jd,vhTYT96f,43971";
				$array[] = "meridianassoc_jd,VqhqEVm4,43970";
				$array[] = "microtek_jd,9SBg9NZh,43972";
				$array[] = "minutemanarc_jd,AMzBMg2a,43973";
				$array[] = "molife_jd,yaYCzhCr,43966";
				$array[] = "nearc_jd,RKYsRsZw,43980";
				$array[] = "necc_jd,wAKSs8Tp,43978";
				$array[] = "nemgroup_jd,sb7tbsnJ,43976";
				$array[] = "nevillage_jd,76tyfkXy,43979";
				$array[] = "northsuffolk_jd,YtYuYH69,43981";
				$array[] = "Nupat_jd,tUMehBgN,50007";
				$array[] = "nycap_jd,7mdvKBMB,43948";
				$array[] = "oppworks_jd,T8mbQ5RV,43952";
				$array[] = "ourgoodwill_jd,EuwsXKUW,43949";
				$array[] = "partserve_jd,K3kYAaRP,43983";
				$array[] = "peopleincfr_jd,uERkSfbR,43984";
				$array[] = "perkinschool_jd,Khd4d9yM,43943";
				$array[] = "pluscompany_jd,bwxd3qHb,43985";
				$array[] = "polusctr_jd,naZbdwtZ,43986";
				$array[] = "prideinc_jd,7cErRjGV,43982";
				$array[] = "regemp_jd,wbG2XtVV,43987";
				$array[] = "rehabresinc_jd,k3yfJvHV,43988";
				$array[] = "roadtoresp_jd,HUpFD55H,43990";
				$array[] = "rsi_jd,75z7bLTV,43989";
				$array[] = "servnetinc_jd,8kG7yX8U,50004";
				$array[] = "sevenhillsc_jd,6s3KDSrP,43991";
				$array[] = "sevenhillsf_jd,ZhDqJ5d5,43992";
				$array[] = "smecollab_jd,U3aLXNZD,43993";
				$array[] = "sowocore2_jd,AQ5hkF5V,50005";
				$array[] = "sunshine_jd,35bFx5NW,43996";
				$array[] = "thearcofgp_jd,j5UEarZD,43913";
				$array[] = "theemarc_jd,WQsyHfG3,43944";
				$array[] = "tillinc_jd,VEVc5bZJ,43997";
				$array[] = "triangleinc_jd,wUV4gZkR,43998";
				$array[] = "valleyEd_jd,ae8mLyHL,43999";
				$array[] = "vinfen1_jd,5HVv85yq,44000";
				$array[] = "vinfengate_jd,hg64DJKP,44001";
				$array[] = "wearewci_jd,TPN9t4e4,44005";
				$array[] = "workoppctr_jd,Sc6WWKvu,44008";
				$array[] = "wscinc_jd,DVdhgAAy,44004";
				$array[] = "test_frank,DVdhgAAy,44004";
				
				$count = count($array);				
				for($i=0;$i<$count;$i++){
					$parts = explode(",",$array[$i]);
					echo "adding " . $parts[0] . ", " . $parts[1] . ", agnes.zalewska@umb.edu  " . $parts[2] . "<br/>";
					//uncomment to insert these again
					//$qls->User->insert_registration_data($parts[0], $parts[1], "agnes.zalewska@umb.edu", $parts[2]);
					//also need to set the group_id to 3. I did this directly in phpmyadmin user_users table
					echo "done<br/>";
				}

			break;
			
			case 'phpinfo':
				if ($qls->user_info['auth_admin_phpinfo'] == 1) {
				@phpinfo();
				}
				else {
				echo ADMIN_PHPINFO_NO_AUTH;
				}
			break;
			case 'updates':
			require_once('html_md/admin_updates.php');
			break;
			case 'configuration':
				if ($qls->user_info['auth_admin_configuration'] == 1) {
					if ($_GET['type'] == 'process') {
						if ($qls->Admin->edit_configuration()) {
						echo ADMIN_CONFIG_SUCCESS;
						}
						else {
						echo $qls->Admin->configuration_error . ADMIN_CONFIG_TRY_AGAIN;
						}
					}
					else {
					require_once('html_md/admin_configuration_form.php');
					}
				}
				else {
				echo ADMIN_CONFIG_NO_AUTH;
				}
			break;
			case 'add_user':
				if ($qls->user_info['auth_admin_add_user'] == 1) {
					if ($_GET['type'] == 'process') {
						if ($qls->Admin->add_user()) {
						echo ADMIN_ADD_USER_SUCCESS;
						}
						else {
						echo $qls->Admin->add_user_error . ADMIN_ADD_USER_TRY_AGAIN;
						}
					}
					else {
					// Get the groups and masks
					$groups_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}groups`");
					$masks_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}masks`");
					$providers_result = $qls->SQL->query("SELECT * FROM `mdda_providers` order by vendor");
					require_once('html_md/admin_add_user_form.php');
					}
				}
				else {
				echo ADMIN_ADD_USER_NO_AUTH;
				}
			break;
			case 'user_list':
				if ($qls->user_info['auth_admin_user_list'] == 1) {
				$perpage = 20;
				// Grab the necessary variables and find out some info
				$page = (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0) ? $qls->Security->make_safe($_GET['page']) : 1;
				$offset = ($page - 1) * $perpage;
				$users_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}users` ORDER BY `id` DESC LIMIT {$offset},{$perpage}");
				require_once('html_md/admin_list_users.php');
				}
				else {
				echo ADMIN_USER_LIST_NO_AUTH;
				}
			break;
			case 'remove_user':
				if ($qls->user_info['auth_admin_remove_user'] == 1) {
					if ($_GET['type'] == 'process') {
						// What are we using currently?
						if (isset($_GET['user_id'])) {
						$user_id = $qls->Security->make_safe($_GET['user_id']);
						$username = stripslashes($qls->id_to_username($_GET['user_id']));
						}
						else {
						$user_id = $qls->User->username_to_id($_GET['username']);
						$username = htmlentities($_GET['username']);
						}

						if ($qls->Admin->remove_user()) {
						printf(ADMIN_REMOVE_USER_SUCCESS, $username);
						}
						else {
						printf($qls->Admin->remove_user_error . ADMIN_REMOVE_USER_TRY_AGAIN, $user_id);
						}
					}
					else {
					require_once('html_md/admin_remove_user_form.php');
					}
				}
				else {
				echo ADMIN_REMOVE_USER_NO_AUTH;
				}
			break;
			case 'edit_user':
				if ($qls->user_info['auth_admin_edit_user'] == 1) {
					if ($_GET['type'] == 'process') {
						// Grab the user id and the rest of their information
						if (isset($_GET['user_id'])) {
						$user_id = $qls->Security->make_safe($_GET['user_id']);
						}
						else {
						$user_id = $qls->User->username_to_id($_GET['username']);
						}

					$result = $qls->SQL->select('*',
						'users',
						array('id' =>
							array(
								'=',
								$user_id
							)
						)
					);
					$row = $qls->SQL->fetch_array($result);
						if ($_GET['type2'] == 'process') {
							if ($qls->Admin->edit_user()) {
							// Everything went well...
							printf(ADMIN_EDIT_USER_SUCCESS, stripslashes($row['username']), $user_id);
							}
							else {
							printf($qls->Admin->edit_user_error . ADMIN_EDIT_USER_TRY_AGAIN, $user_id);
							}
						}
						else {
						// Get the groups and masks
						$groups_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}groups`");
						$masks_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}masks`");
						$providers_result = "";
						//if ($qls->user_info['provider_id'] == 0) {
							//an admin user
							$providers_result = $qls->SQL->query("SELECT * FROM `mdda_providers` order by vendor");
						//}
						
						require_once('html_md/admin_edit_user_real_form.php');
						}
					}
					else {
					require_once('html_md/admin_edit_user_form.php');
					}
				}
				else {
				echo ADMIN_EDIT_USER_NO_AUTH;
				}
			break;
			case 'list_activations':
				if ($qls->user_info['auth_admin_activate_account'] == 1) {
					if ($qls->config['activation_type'] == 1 || $qls->config['activation_type'] == 2) {
						if ($_GET['type'] == 'process') {
							if (isset($_GET['user_id'])) {
							$user_id = htmlentities($_GET['user_id']);
							$username = stripslashes($qls->User->id_to_username($_GET['user_id']));
							}
							else {
							$user_id = $qls->User->username_to_id($_GET['username']);
							$username = htmlentities($_GET['username']);
							}

							if ($qls->Admin->activate_account()) {
							printf(ADMIN_ACTIVATE_USER_SUCCESS, $username);
							}
							else {
							printf($qls->Admin->activate_user_error . ADMIN_ACTIVATE_USER_TRY_AGAIN, $user_id);
							}
						}

					// Display the activations even if we processed and output above
					$result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}users` WHERE `active`='no' ORDER BY `id` DESC");
					require_once('html_md/admin_list_activations.php');
					}
					else {
					echo ADMIN_ACTIVATE_NO_NEED;
					}
				}
				else {
				echo ADMIN_ACTIVATE_USER_NO_AUTH;
				}
			break;
			case 'add_page':
				if ($qls->user_info['auth_admin_add_page'] == 1) {
				// Add page is not using AJAX! It will go to a new page
					if ($_GET['type'] == 'process') {
					$upload = ($_GET['type2'] == 'process') ? true : false;
						if ($qls->Admin->add_page($upload)) {
						$page_name = ($upload) ? trim($_FILES['upload']['name']) : trim($_POST['name']);
						echo ADMIN_ADD_PAGE_SUCCESS;
						}
						else {
						echo $qls->Admin->add_page_error . ADMIN_ADD_PAGE_TRY_AGAIN;
						}
					}
					else {
					require_once('html_md/admin_add_page_form.php');
					}
				}
				else {
				echo ADMIN_ADD_PAGE_NO_AUTH;
				}
			break;
			case 'page_list':
				if ($qls->user_info['auth_admin_page_list'] == 1) {
				$pages_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}pages`");
				require_once('html_md/admin_list_pages.php');
				}
				else {
				echo ADMIN_PAGE_LIST_NO_AUTH;
				}
			break;
			case 'remove_page':
				if ($qls->user_info['auth_admin_remove_page'] == 1) {
					if ($_GET['type'] == 'process') {
						if (isset($_GET['page_id'])) {
						$page_id = htmlentities($_GET['page_id']);
						$page_name = $qls->page_id_to_name($_GET['page_id']);
						}
						else {
						$page_id = $qls->page_name_to_id($_GET['page_name']);
						$page_name = htmlentities($_GET['page_name']);
						}

						if ($qls->Admin->remove_page()) {
						printf(ADMIN_REMOVE_PAGE_SUCCESS, $page_name);
						}
						else {
						printf($qls->Admin->remove_page_error . ADMIN_REMOVE_PAGE_TRY_AGAIN, $page_id);
						}
					}
					else {
					// Grab this information for the form
					$pages_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}pages`");
					require_once('html_md/admin_remove_page_form.php');
					}
				}
				else {
				echo ADMIN_REMOVE_PAGE_NO_AUTH;
				}
			break;
			case 'edit_page':
				if ($qls->user_info['auth_admin_edit_page'] == 1) {
					if ($_GET['type'] == 'process') {
						if (isset($_GET['page_id'])) {
						$page_id = $qls->Security->make_safe($_GET['page_id']);
						$page_name = $qls->page_id_to_name($_GET['page_id']);
						}
						else {
						$page_id = $qls->page_name_to_id($_GET['page_name']);
						$page_name = trim($_GET['page_name']);
						}

					// Grab the page information for the form
					$result = $qls->SQL->select('*',
						'pages',
						array('id' =>
							array(
								'=',
								$page_id
							)
						)
					);
					$row = $qls->SQL->fetch_array($result);
						if ($_GET['type2'] == 'process') {
							if ($qls->Admin->edit_page()) {
							printf(ADMIN_EDIT_PAGE_SUCCESS, stripslashes($row['name']), $page_id);
							}
							else {
							printf($qls->Admin->edit_page_error . ADMIN_EDIT_PAGE_TRY_AGAIN, $page_id);
							}
						}
						else {
							// Try to read from the file for the form
							if (!$file_data = $qls->fetch_file_data($page_name)) {
							printf($qls->file_data_error, $page_name);
							}
							else {
							require_once('html_md/admin_edit_page_real_form.php');
							}
						}
					}
					else {
					// Grab this information for the form
					$pages_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}pages`");
					require_once('html_md/admin_edit_page_form.php');
					}
				}
				else {
				echo ADMIN_EDIT_PAGE_NO_AUTH;
				}
			break;
			case 'add_mask':
				if ($qls->user_info['auth_admin_add_mask'] == 1) {
					if ($_GET['type'] == 'process') {
						if ($qls->Admin->add_mask()) {
						echo ADMIN_ADD_MASK_SUCCESS;
						}
						else {
						echo $qls->Admin->add_mask_error . ADMIN_ADD_MASK_TRY_AGAIN;
						}
					}
					else {
					// Get for the form
					$pages_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}pages`");
					require_once('html_md/admin_add_mask_form.php');
					}
				}
				else {
				echo ADMIN_ADD_MASK_NO_AUTH;
				}
			break;
			case 'list_masks':
				if ($qls->user_info['auth_admin_list_masks'] == 1) {
				$masks_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}masks`");
				require_once('html_md/admin_list_masks.php');
				}
				else {
				echo ADMIN_LIST_MASKS_NO_AUTH;
				}
			break;
			case 'remove_mask':
				if ($qls->user_info['auth_admin_remove_mask'] == 1) {
					if ($_GET['type'] == 'process') {
						if ($qls->Admin->remove_mask()) {
						echo ADMIN_REMOVE_MASK_SUCCESS;
						}
						else {
							// What method are we using right now?
							if (isset($_GET['mask_id'])) {
							$mask_id = htmlentities($_GET['mask_id']);
							}
							else {
							$mask_id = $qls->mask_name_to_id($_GET['mask_name']);
							}

						printf($qls->Admin->remove_mask_error . ADMIN_REMOVE_MASK_TRY_AGAIN, $mask_id);
						}
					}
					else {
					// Get for the form
					$masks_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}masks`");
					require_once('html_md/admin_remove_mask_form.php');
					}
				}
				else {
				echo ADMIN_REMOVE_MASK_NO_AUTH;
				}
			break;
			case 'edit_mask':
				if ($qls->user_info['auth_admin_edit_mask'] == 1) {
					if ($_GET['type'] == 'process') {
						if (isset($_GET['mask_id'])) {
						$mask_id = $qls->Security->make_safe($_GET['mask_id']);
						}
						else {
						$mask_id = $qls->mask_name_to_id($_GET['mask_id']);
						}

					// Grab the information from the database
					$result = $qls->SQL->select('*',
						'masks',
						array('id' =>
							array(
								'=',
								$mask_id
							)
						)
					);
					$row = $qls->SQL->fetch_array($result);
						if ($_GET['type2'] == 'process') {
							if ($qls->Admin->edit_mask()) {
							printf(ADMIN_EDIT_MASK_SUCCESS, stripslashes($row['name']), $mask_id);
							}
							else {
							printf($qls->Admin->edit_mask_error . ADMIN_EDIT_MASK_TRY_AGAIN, $mask_id);
							}
						}
						else {
						// Get the pages
						$pages_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}pages`");
						require_once('html_md/admin_edit_mask_real_form.php');
						}
					}
					else {
					// Get this information for the form
					$masks_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}masks`");
					require_once('html_md/admin_edit_mask_form.php');
					}
				}
				else {
				echo ADMIN_EDIT_MASK_NO_AUTH;
				}
			break;
			case 'add_group':
				if ($qls->user_info['auth_admin_add_group'] == 1) {
					if ($_GET['type'] == 'process') {
						if ($qls->Admin->add_group()) {
						echo ADMIN_ADD_GROUP_SUCCESS;
						}
						else {
						echo $qls->Admin->add_group_error . ADMIN_ADD_GROUP_TRY_AGAIN;
						}
					}
					else {
					// Mask information for the form
					$masks_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}masks`");
					require_once('html_md/admin_add_group_form.php');
					}
				}
				else {
				echo ADMIN_ADD_GROUP_NO_AUTH;
				}
			break;
			case 'list_groups':
				if ($qls->user_info['auth_admin_list_groups'] == 1) {
				$groups_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}groups`");
				require_once('html_md/admin_list_groups.php');
				}
				else {
				echo ADMIN_LIST_GROUPS_NO_AUTH;
				}
			break;
			case 'remove_group':
				if ($qls->user_info['auth_admin_remove_group'] == 1) {
					if ($_GET['type'] == 'process') {
						// Which one are we using?
						if (isset($_GET['group_id'])) {
						$group_id = htmlentities($_GET['group_id']);
						$group_name = stripslashes($qls->group_id_to_name($_GET['group_id']));
						}
						else {
						$group_id = $qls->group_name_to_id($_GET['group_name']);
						$group_name = htmlentities($_GET['group_name']);
						}

						if ($qls->Admin->remove_group()) {
						printf(ADMIN_REMOVE_GROUP_SUCCESS, $group_name);
						}
						else {
						printf($qls->Admin->remove_group_error . ADMIN_REMOVE_GROUP_TRY_AGAIN, $group_id);
						}
					}
					else {
					// Get the group information for the form
					$groups_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}groups`");
					require_once('html_md/admin_remove_group_form.php');
					}
				}
				else {
				echo ADMIN_REMOVE_GROUP_NO_AUTH;
				}
			break;
			case 'edit_group':
				if ($qls->user_info['auth_admin_edit_group'] == 1) {
					if ($_GET['type'] == 'process') {
						if (isset($_GET['group_id'])) {
						$group_id = $qls->Security->make_safe($_GET['group_id']);
						}
						else {
						$group_id = $qls->group_name_to_id($_GET['group_name']);
						}

					// Grab the stuff from the database
					$result = $qls->SQL->select('*',
						'groups',
						array('id' =>
							array(
								'=',
								$group_id
							)
						)
					);
					$row = $qls->SQL->fetch_array($result);
						if ($_GET['type2'] == 'process') {
							if ($qls->Admin->edit_group()) {
							printf(ADMIN_EDIT_GROUP_SUCCESS, stripslashes($row['name']), $group_id);
							}
							else {
							printf($qls->Admin->edit_group_error . ADMIN_EDIT_GROUP_TRY_AGAIN, $group_id);
							}
						}
						else {
						// Get the mask information for the form
						$masks_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}masks`");
						require_once('html_md/admin_edit_group_real_form.php');
						}
					}
					else {
					// Get the group information for the form
					$groups_result = $qls->SQL->query("SELECT * FROM `{$qls->config['sql_prefix']}groups`");
					require_once('html_md/admin_edit_group_form.php');
					}
				}
				else {
				echo ADMIN_EDIT_GROUP_NO_AUTH;
				}
			break;
			case 'send_invite':
				if ($qls->user_info['auth_admin_send_invite'] == 1) {
					if ($_GET['type'] == 'process') {
						if ($qls->Admin->send_invite()) {
						echo ADMIN_SEND_INVITE_SUCCESS;
						}
						else {
						echo $qls->Admin->send_invite_error . ADMIN_SEND_INVITE_TRY_AGAIN;
						}
					}
					else {
					$site_url = $qls->config['cookie_domain'] . $qls->config['cookie_path'];
						// This is the current URL to the register_md.php page
						if (substr($qls->config['cookie_domain'], 0, 1) == '.') {
							if (substr($qls->config['cookie_path'], -1) == '/') {
							$register_url = "http://www{$site_url}users/register_md.php";
							}
							else {
							$register_url = "http://www{$site_url}/users/register_md.php";
							}
						}
						else {
							if (substr($qls->config['cookie_path'], -1) == '/') {
							$register_url = "http://{$site_url}users/register_md.php";
							}
							else {
							$register_url = "http://{$site_url}/users/register_md.php";
							}
						}

					require_once('html_md/admin_send_invite_form.php');
					}
				}
				else{
				echo ADMIN_SEND_INVITE_NO_AUTH;
				}
			break;
			default:
			require_once('html_md/admin_panel.php');
			break;
		}
	}
	else {
	echo ADMIN_NOT_ADMIN;
	}
}
else {
echo ADMIN_NOT_LOGGED;
}
?>
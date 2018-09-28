<?php
/* DO NOT REMOVE */
if (!defined('QUADODO_IN_SYSTEM')) {
exit;
}
/*****************/
?>
<fieldset>
	<legend>
		<?php echo ADMIN_EDIT_USER_LABEL; ?>

	</legend>
	<form action="#" method="get">
		<input type="hidden" id="type2" name="type2" value="process" />
		<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>" />
		<table border="0">
			<tr>
				<td>
					<?php echo NEW_USERNAME_LABEL; ?>

				</td>
				<td>
					<input type="text" id="new_username" name="new_username" maxlength="<?php echo $qls->config['max_username']; ?>" value="<?php echo stripslashes($row['username']); ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo NEW_EMAIL_LABEL; ?>

				</td>
				<td>
					<input type="text" id="new_email" name="new_email" maxlength="255" value="<?php echo $row['email']; ?>" />
				</td>
			</tr>
			<?php 
			//if ($qls->user_info['provider_id'] == 0) { 
			?>
			<tr>
				<td>
					<?php echo NEW_PROVIDER_LABEL; ?>

				</td>
				<td>
					<select name="new_provider_id" id="new_provider_id">
					<option value="0"<?php if ($row['provider_id'] == 0) { ?> selected="selected"<?php } ?>><?php echo ICI_ADMIN_LABEL; ?></option>
<?php
	// $groups_result was provided by admin.php
	while ($providers_row = $qls->SQL->fetch_array($providers_result)) {
	
		if ($providers_row['provider_id'] == $row['provider_id']) {
?>
						<option value="<?php echo $providers_row['provider_id']; ?>" selected="selected"><?php echo stripslashes($providers_row['Vendor']); ?></option>
<?php
		}
		else {
?>
						<option value="<?php echo $providers_row['provider_id']; ?>"><?php echo stripslashes($providers_row['Vendor']); ?></option>
<?php
		}
	}
?>
					</select>
				</td>
			</tr>
			<?php //} else { 
			?>
			<!--	<input type="hidden" name="provider_id" id="provider_id" value="<?php echo $qls->user_info['provider_id']; ?>"/> -->
			<?php //} 
			?>
			<tr>
				<td>
					<?php echo NEW_PERMISSION_MASK_LABEL; ?>

				</td>
				<td>
					<select name="new_mask_id" id="new_mask_id">
						<option value="0"<?php if ($row['mask_id'] == 0) { ?> selected="selected"<?php } ?>><?php echo NONE_IF_GROUP_LABEL; ?></option>
<?php
	// $groups_result was provided by admin.php
	while ($masks_row = $qls->SQL->fetch_array($masks_result)) {
		if ($masks_row['id'] == $row['mask_id']) {
?>
						<option value="<?php echo $masks_row['id']; ?>" selected="selected"><?php echo stripslashes($masks_row['name']); ?></option>
<?php
		}
		else {
?>
						<option value="<?php echo $masks_row['id']; ?>"><?php echo stripslashes($masks_row['name']); ?></option>
<?php
		}
	}
?>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo NEW_GROUP_LABEL; ?>

				</td>
				<td>
					<select name="new_group_id" id="new_group_id">
<?php
	// $masks_result was provided by admin.php
	while ($groups_row = $qls->SQL->fetch_array($groups_result)) {
		if ($groups_row['id'] == $row['group_id']) {
?>
						<option value="<?php echo $groups_row['id']; ?>" selected="selected"><?php echo stripslashes($groups_row['name']); ?></option>
<?php
		}
		else {
?>
						<option value="<?php echo $groups_row['id']; ?>"><?php echo stripslashes($groups_row['name']); ?></option>
<?php
		}
	}
?>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo BANNED_LABEL; ?>

				</td>
				<td>
					<select name="new_banned" id="new_banned">
						<option value="0"<?php if ($row['blocked'] == 'no') { ?> selected="selected"<?php } ?>><?php echo NO_LABEL; ?></option>
						<option value="1"<?php if ($row['blocked'] == 'yes') { ?> selected="selected"<?php } ?>><?php echo YES_LABEL; ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="center">
					<input type="button" onclick="javascript:run_form('edit_user', new Array('type2','user_id','new_username','new_email','new_provider_id','new_mask_id','new_group_id','new_banned'));" value="<?php echo GO_LABEL; ?>" />
				</td><td><?php $last_login = date("Y-m-d, H:i:s",$row['last_login']); echo "Last Login: $last_login"; ?></td>
			</tr>
		</table>
	</form>
</fieldset>
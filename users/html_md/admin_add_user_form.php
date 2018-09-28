<?php
/* DO NOT REMOVE */
if (!defined('QUADODO_IN_SYSTEM')) {
exit;
}
/*****************/
?>
<fieldset>
	<legend>
		<?php echo ADMIN_ADD_USER_LABEL; ?>

	</legend>
	<form action="#" method="get">
		<table border="0">
			<tr>
				<td>
					<?php echo USERNAME_LABEL; ?>

				</td>
				<td>
					<input type="text" id="username" name="username" maxlength="<?php echo $qls->config['max_username']; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo PASSWORD_LABEL; ?>

				</td>
				<td>
					<input type="password" id="password" name="password" maxlength="<?php echo $qls->config['max_password']; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo PASSWORD_CONFIRM_LABEL; ?>

				</td>
				<td>
					<input type="password" id="password_c" name="password_c" maxlength="<?php echo $qls->config['max_password']; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo EMAIL_LABEL; ?>

				</td>
				<td>
					<input type="text" id="email" name="email" maxlength="255" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo EMAIL_CONFIRM_LABEL; ?>

				</td>
				<td>
					<input type="text" id="email_c" name="email_c" maxlength="255" />
				</td>
			</tr>
			<?php //if ($qls->user_info['provider_id'] == 0) { 
			?>
			
			<tr>
				<td>
					<?php echo PROVIDER_LABEL; ?>

				</td>
				<td>
					<select name="provider_id" id="provider_id">
					<option value="0" selected="selected"><?php echo ICI_ADMIN_LABEL; ?></option>
<?php
	// $masks_result was provided by admin.php
	while ($providers_row = $qls->SQL->fetch_array($providers_result)) {
?>
						<option value="<?php echo $providers_row['provider_id']; ?>"><?php echo stripslashes($providers_row['Vendor']); ?></option>
<?php
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
			
	
				<td>
					<?php echo GROUP_LABEL; ?>

				</td>
				<td>
					<select name="group_id" id="group_id">
<option value="5">MDDA Data Entry</option>
<option value="4">System Administrator</option>
					</select>
               <input type="hidden" name="mask_id" id="mask_id" value="0" />
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="button" onclick="javascript:run_form('add_user', new Array('username','password','password_c','email','email_c','mask_id','group_id','provider_id'));" value="<?php echo GO_LABEL; ?>" />
				</td>
			</tr>
		</table>
	</form>
</fieldset>
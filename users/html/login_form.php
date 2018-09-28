<?php
/* DO NOT REMOVE */
if (!defined('QUADODO_IN_SYSTEM')) {
exit;
}
/*****************/
?>
<fieldset>
	<legend>
		<?php echo LOGIN_LABEL; ?>
	</legend>
	<form action="login_process.php" method="post" id="form1">
		<input type="hidden" name="process" value="true" />
		<table>
			<tr>
				<td>
					<?php echo USERNAME_LABEL; ?>

				</td>
				<td>
					<input type="text" name="username" id="username" maxlength="<?php echo $qls->config['max_username']; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo PASSWORD_LABEL; ?>

				</td>
				<td>
					<input type="password" name="password" maxlength="<?php echo $qls->config['max_password']; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo REMEMBER_ME_LABEL; ?>

				</td>
				<td>
					<input type="checkbox" name="remember" value="1" />
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;
				</td>
				<td>
					<input type="submit" value="<?php echo LOGIN_SUBMIT_LABEL; ?>" />
				</td>
			</tr>
		</table>Forgot password?  <a href="https://www.statedata.info/users/change_password.php">Follow this link to reset it and have it e-mailed to you</a>.  You will need to have your username (usually first initial and last name).
	</form>
</fieldset>
<script>
document.forms[0].username.focus();
</script>

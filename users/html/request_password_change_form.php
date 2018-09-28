<?php
/* DO NOT REMOVE */
if (!defined('QUADODO_IN_SYSTEM')) {
exit;
}
/*****************/
?>
<fieldset>
	<legend>
		<?php echo CHANGE_PASSWORD_LABEL; ?>
	</legend>
	<form action="change_password.php" method="post">
		<input type="hidden" name="process" value="true" />
		<table>
			<tr>
				<td>
					<?php echo USERNAME_LABEL; ?>

				</td>
			<td>
				<input type="text" name="username" maxlength="<?php echo $qls->config['max_username']; ?>" /><br /><strong>Important: </strong>enter your username above, NOT, your e-mail address.  E-mail <a href="mailto:ddsdata@statedata.info">ddsdata@statedata.info</a> if you do not know your username.
			</td>
			</tr>
			<tr>
				<td>
					&nbsp;
				</td>
				<td>
					<input type="submit" value="<?php echo GO_LABEL; ?>" />
				</td>
			</tr>
		</table>
	</form>
</fieldset>
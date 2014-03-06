
<?php echo validation_errors(); ?>

<?php echo form_open('login'); ?>
	
	<div>
		<label>Username</label>
		<input type="text" name="username" value="<?php echo set_value('username', ''); ?>" size="50" />
	</div>
	<div>
		<label>Password</label>
		<input type="password" name="password" value="" size="50" />
	</div>
	<div>
		<input type="submit" value="Submit" />
	</div>
</form>


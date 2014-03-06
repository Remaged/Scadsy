
<?php echo validation_errors(); ?>

<?php echo form_open('login'); ?>
	
	<div>
		<label>Email</label>
		<input type="email" name="email" value="" size="50" />
	</div>
	<div>
		<label>Password</label>
		<input type="password" name="password" value="" size="50" />
	</div>
	<div>
		<input type="submit" value="Submit" />
	</div>
</form>


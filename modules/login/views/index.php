<?php echo validation_errors(); ?>
<?php echo form_open('login'); ?>
<?php echo $failed_message; ?>
	
	<div>
		<?php echo form_label('School', 'school'); ?>
		<?php echo form_dropdown('school', $schools, set_value('school')); ?>
	</div>				
	<div>
		<?php echo form_label('Username', 'username'); ?>
		<?php echo form_input('username',set_value('username')); ?>
	</div>
	<div>
		<?php echo form_label('Password', 'password'); ?>
		<?php echo form_password('password'); ?>
	</div>		
	<div>	
		<?php echo form_submit('submit', 'Log in'); ?>
	</div>
</form>

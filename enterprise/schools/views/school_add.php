<style>
	fieldset{
		border: 1px solid black;
		margin: 15px 0px;
		padding: 10px;
	}
	label{
		display: inline-block;
		width: 130px;
	}
</style>

<h2>Add new school</h2>

<p>
	By submitting the form below a new school will be created. Because it creates a new database
	it might take a while to be completed.
</p>

<?php echo validation_errors(); ?>

<?php echo form_open(uri_string()); ?>
	
	<div>
		<?php echo form_label('School name', 'school'); ?>
		<?php echo form_input('school',set_value('school')); ?>
	</div>		
	<div>
		<?php echo form_label('Database Name', 'name'); ?>
		<?php echo form_input('name',set_value('name')); ?>
	</div>		
	<div>
		<?php echo form_label('Database Username', 'username'); ?>
		<?php echo form_input('username',set_value('username')); ?>
	</div>	
	<div>
		<?php echo form_label('Database Password', 'password'); ?>
		<?php echo form_password('password',set_value('password')); ?>
	</div>	
	<div>	
		<?php echo form_submit('submit', 'Save'); ?>
	</div>
	
<?php echo form_close(); ?>


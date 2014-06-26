<h1>Login</h1>

<?php echo validation_errors(); ?>
<?php echo $failed_message; ?>

<?php echo form_open(uri_string(), array("class" => "sc-form")); ?>

	<?php echo form_fieldset('Acces information'); ?>
	
	<?php echo form_label_input('username'); ?>
	<?php echo form_label_password('password'); ?>

	<div>
		<?php echo form_submit('login','Login'); ?>
	</div>
	
	<?php echo form_fieldset_close(); ?>
	
<?php echo form_close(); ?>



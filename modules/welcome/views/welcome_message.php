<h1>Welcome</h1>

<p>
	This is an example module. By going to the Manage modules, this module can be disabled/enabled. 
</p>

<?php echo validation_errors(); ?>

<?php echo form_open(); ?>
	<?php echo form_label_input('gewoon_test'); ?>
	
	<?php echo form_extra('some_test_fields'); ?>
	
	<?php echo form_submit('submit','Submit'); ?>
	
<?php echo form_close(); ?>
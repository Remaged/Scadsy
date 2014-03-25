<h1>Add new school</h1>

<p>
	By submitting the form below a new school will be created. Because it creates a new database
	it might take a while to be completed.
</p>

<?php echo validation_errors(); ?>

<?php echo form_open(uri_string()); ?>
	<?php echo form_fieldset(); ?>
		<?php echo form_label_input('school','School name'); ?>
		<?php echo form_label_input('name','Database name'); ?>
		<?php echo form_label_input('username','Database username'); ?>
		<?php echo form_label_input('password','Database password'); ?>
		<div>	
			<?php echo form_submit('submit', 'Save'); ?>
		</div>	
	<?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>


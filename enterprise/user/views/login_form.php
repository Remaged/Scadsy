<h1>
	Login to a school
</h1>

<?php echo validation_errors(); ?>
<?php echo $failed_message; ?>

<?php echo form_open(uri_string()); ?>
	<?php echo form_fieldset(); ?>
		<?php echo form_label_dropdown('school',$schools); ?>
		<?php echo form_label_input('username'); ?>
		<?php echo form_label_password('password'); ?>	
		<div>	
			<?php echo form_submit('submit', 'Log in'); ?>
		</div>
	<?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>
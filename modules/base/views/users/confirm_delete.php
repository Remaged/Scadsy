<h1>
	Remove user: <?php echo $username; ?>
</h1>

<p>
	Removing a user will also remove information that is related to this user. 
</p>



<?php echo form_open(uri_string(), array("class" => "sc-form")); ?>
	<p>
		Are you sure you want to remove this user?
	</p>
	<?php echo form_submit('delete_user','Yes, delete this user'); ?>
	<a id="delete_button" href="<?php echo site_url(site_action_uri('edit/'.$username)); ?>" class="button">No, go back</a>
<?php echo form_close(); ?>

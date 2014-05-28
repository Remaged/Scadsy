<h1>SMS</h1>

<?php echo form_open(NULL,array('class'=>'sc-form','id'=>'sms_form')); ?>
	<div>
		<label>Selected</label>
		<div>
			<div class="selected_users">
				<?php echo form_input(array('type'=>'button','value'=>'Add','id'=>'add_button','class'=>'button')); ?>
				&nbsp;
			</div>
			<div id="search_and_select_users">
				<?php echo form_search('search'); ?>
				<?php echo form_input(array('type'=>'button','value'=>'Search','id'=>'search_button','class'=>'button')); ?>
				<?php echo form_input(array('type'=>'button','value'=>'Close','id'=>'close_button','class'=>'button')); ?>
				<div id="search_users_container">
					<?php include('search_users.php'); ?>
				</div>
			</div>
		</div>
	</div>

	<?php echo form_label_textarea('message'); ?>
	<div><span id="sms_characters_left">140</span>/140 characters (<span id="sms_amount">1</span> sms)</div>
		
	<?php echo form_submit('send','Send'); ?>
	
<?php echo form_close(); ?>


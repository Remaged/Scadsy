<h1>SMS</h1>

<p>
	Below you can select student and parents, by adding specific people or adding groups. 
</p>
<p>
	Please note that by selecting a group, the people without phone number won't receive a SMS-message
</p>

<?php echo form_open(NULL,array('class'=>'sc-form','id'=>'sms_form')); ?>
	<div>
		<label>Selected people</label>
		<div>
			<div class="selected_users">
				<?php echo form_input(array('type'=>'button','value'=>'Add people','id'=>'add_people_button','class'=>'button')); ?>
				&nbsp;
			</div>
			<div id="search_users_container" class="select_container">
				<?php include('search_users.php'); ?>
			</div>
			
		</div>
	</div>
	
	<div>
		<label>Selected groups</label>
		<div>
			<div class="selected_groups">				
				<?php echo form_input(array('type'=>'button','value'=>'Add groups','id'=>'add_groups_button','class'=>'button')); ?>
			</div>
			<div id="select_groups_container" class="select_container">			
				<?php echo form_input(array('type'=>'button','value'=>'Close','class'=>'button close_button')); ?>	
				<table class="sc-table">
					<thead>
					<tr>
						<th>Group</th>
						<th>Select students</th>
						<th>Select Parents of students</th>
					</tr>
					</thead>
					<?php foreach($group_checkbox_options AS $group_name => $parent_group): ?>								
						<tr>
							<td>
								<?php echo $group_name; ?>
							</td>
							<td>
								<?php echo form_hidden('parent_group','students_'.$parent_group); ?>
								<?php echo form_hidden('name',$group_name. ' (to students)'); ?>
								<?php echo form_checkbox('selected_group_students[]','students_'.$group_name, null,'data-selectType="group_students"'); ?>
							</td>
							<td>
								<?php echo form_hidden('parent_group','parents_'.$parent_group); ?>
								<?php echo form_hidden('name',$group_name. ' (to parents)'); ?>
								<?php echo form_checkbox('selected_group_parents[]','parents_'.$group_name, null,'data-selectType="group_parents"'); ?>
							</td>
						</tr>						
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>

	<?php echo form_label_textarea('message'); ?>
	<div><span id="sms_characters_left">140</span>/140 characters (<span id="sms_amount">1</span> sms)</div>
		
	<?php echo form_submit('send','Send'); ?>
	
<?php echo form_close(); ?>


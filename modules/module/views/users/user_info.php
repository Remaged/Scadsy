<h1>
	<?php if(!$user->username): ?>
			Add new user
	<?php else: ?>
		Manage user: <?php echo $user->username; ?>
	<?php endif; ?>
</h1>

<div class="button_container">
	<a href="<?php echo site_url(site_action_uri('userlist')); ?>" class="button">Back to list</a>
	<?php if($user->username): ?>
		<a href="<?php echo site_url(site_action_uri('delete/'.$user->username)); ?>" class="button">Delete this user</a>
	<?php endif; ?>
</div>

<?php echo form_open(site_action_uri('save'.($user->username?'/'.$user->username:'')), array("class" => "sc-form")); ?>
	<p>
		* = Required field.
	</p>
	
	<?php if($this->router->get_action() == 'add'): ?>
		<?php echo form_hidden('edit_user',null); ?>
	<?php else: ?>
		<?php echo form_hidden('edit_user',$user->id); ?>
	<?php endif; ?>
	
	<?php echo form_fieldset('Acces information'); ?>
		<?php echo form_label_input('username',null,$user->username,'required'); ?>
		<?php echo form_label_password('password',null,null, $user->username ? 'placeholder="Leave blank for no change."' : 'required'); ?>
		<?php echo form_label_password('password_confirm',null,null, $user->username ? '' : 'required'); ?>
		
		
	<?php echo form_fieldset_close(); ?>
	
	<?php echo form_fieldset('Personal information'); ?>
		<?php echo form_label_input('first_name',null,$user->first_name,'required'); ?>	
		<?php echo form_label_input('middle_name',null,$user->middle_name); ?>	
		<?php echo form_label_input('last_name',null,$user->last_name,'required'); ?>			
		<?php echo form_label_date('date_of_birth',null,$user->date_of_birth); ?>	
		<?php 
			$gender_options = array('male'=>'Male','female'=>'Female'); 
			echo form_label_dropdown('gender',$gender_options,null,$user->gender); 
		?>
		<?php 
			$language_options = array(); 
			foreach($languages AS $language){
				$language_options[$language->id] = $language->name;
			}
			echo form_label_dropdown('language_id',$language_options, 'Primary Language',$user->language->id); 
		?>		
		<?php 
			$ethnicity_options = array(); 
			foreach($ethnicities AS $ethnicity){
				$ethnicity_options[$ethnicity->id] = $ethnicity->name;
			}
			echo form_label_dropdown('ethnicity_id',$ethnicity_options,'Ethnicity',$user->ethnicity->id); 
		?>
	<?php echo form_fieldset_close(); ?>
	
	<?php echo form_fieldset('Contact information'); ?>
		<?php echo form_label_email('email', null, $user->email,'required'); ?>
		<?php echo form_label_input('phone_number', null, $user->phone_number); ?>
	<?php echo form_fieldset_close(); ?>
	
	<?php echo form_fieldset('User-group information'); ?>
		<div id="user_group_options">
			<?php echo form_label('Groups'); ?>
			<?php 
				$user_groups = array(); 
				foreach($user->group->get() AS $user_group){
					 $user_groups[] = $user_group->name;
				};
				function show_group_options($groups, $user_groups){
					if($groups->exists() === FALSE){
						return;
					}
					echo "<ul>";
					foreach($groups AS $group){
						$CI =& get_instance();
						$checked = ($CI->input->post('groups') && in_array($group->name, $CI->input->post('groups'))) ? TRUE : FALSE;
						if(in_array($group->name, $user_groups) && !$CI->input->post('groups')){
							$checked = TRUE;
						}
						echo "<li>".form_checkbox('groups[]',$group->name, $checked).' '.$group->name."</li>";
						show_group_options($group->child_group, $user_groups);
					}
					echo "</ul>";
				}
				show_group_options($groups, $user_groups);
			?>
		</div>
	<?php echo form_fieldset_close(); ?>
	
	<?php echo form_fieldset('Children information',array('id'=>'fields_children_information')); ?>
		<div>
		<?php echo form_label('Children (usernames)'); ?>
			<div>
				<?php foreach($user->guardian->student->get() AS $child): ?>
					<div>
						<?php echo form_input('children[]',$child->user->username); ?>
						<?php echo form_input(array('type'=>'button','value'=>'remove','class'=>'remove_child_to_parent button')); ?>
					</div>
				<?php endforeach; ?>
				<?php echo form_input(array('type'=>'button','value'=>'Add child','class'=>'button add_child_to_parent')); ?>
			</div>
		</div>
	<?php echo form_fieldset_close(); ?>
	
	<?php echo form_fieldset('Student information',array('id'=>'fields_student_information')); ?>
		<?php echo form_label_input('alternate_id','Alternate ID',$user->student->alternate_id); ?>
		<?php 
			$grade_options = array(); 
			foreach($grades AS $grade){
				$grade_options[$grade->id] = $grade->name;
			}
			echo form_label_dropdown('grade_id',$grade_options,'Grade',$user->student->grade->id); 
		?>
	<?php echo form_fieldset_close(); ?>
	
	<?php echo form_fieldset('Enrollment information',array('id'=>'fields_enrollment_information')); ?>
		<?php echo form_label_date('start_date',null,$user->start_date, 'required'); ?>	
		<?php echo form_label_date('end_date',null,$user->end_date); ?>	
	<?php echo form_fieldset_close(); ?>
	
	<div>
		<?php echo form_submit('submit','Save'); ?>
	</div>

<?php form_close(); ?>

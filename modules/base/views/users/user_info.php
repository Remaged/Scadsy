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

	<div id="accordion">
		
		<h2>Acces information</h2>
		<div>
			<?php echo form_label_input('username',null,$user->username,'required'); ?>
			<?php echo form_label_password('password',null,null, $user->username ? 'placeholder="Leave blank for no change."' : 'required'); ?>
			<?php echo form_label_password('password_confirm',null,null, $user->username ? '' : 'required'); ?>
		</div>
		
		<h2>Personal information</h2>
		<div>
			<?php echo form_label_input('first_name',null,$user->first_name,'required'); ?>
			<?php echo form_label_input('last_name',null,$user->last_name,'required'); ?>			
			<?php echo form_label_date('date_of_birth',null,$user->date_of_birth); ?>	
			<?php 
				$gender_options = array('male'=>'Male','female'=>'Female'); 
				echo form_label_dropdown('gender',$gender_options,null,$user->gender); 
			?>
		</div>
		
		<h2>Contact information</h2>
		<div>
			<?php echo form_label_email('email', null, $user->email); ?>
			<?php echo form_label_input('phone_number', null, $user->phone_number); ?>
		</div>
		
		<h2>Group information</h2>
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
	
	</div>
	
	<br />
	
	<div>
		<?php echo form_submit('submit','Save'); ?>
	</div>



<?php form_close(); ?>

<h1>
	<?php if($user->exists()): ?>
		Edit <?php echo $user->first_name. ' ' . $user->last_name; ?> 
	<?php else: ?>
		Add new student
	<?php endif; ?>
</h1>


<div class="button_container">
	<a href="<?php echo site_url(site_action_uri('index')); ?>" class="button">Back to list</a>
	<?php /* if($user->username): ?>
		<a href="<?php echo site_url(site_action_uri('delete/'.$user->username)); ?>" class="button">Delete this user</a>
	<?php endif; */ ?>
</div>


<?php echo form_open(NULL, array("class" => "sc-form")); ?>

	<div id="student_information" class="accordion">
		
		<h2>Personal information</h2>
		<div id="personal_information">
			<?php echo form_label_input('first_name',null,$user->first_name,'required'); ?>
			<?php echo form_label_input('last_name',null,$user->last_name,'required'); ?>			
			<?php echo form_label_date('date_of_birth',null,$user->date_of_birth); ?>	
			<?php echo form_label_dropdown('gender',array('male'=>'Male','female'=>'Female'),null,$user->gender); ?>			
			<?php echo form_label_email('email', null, $user->email); ?>
			<?php echo form_label_input('phone_number', null, $user->phone_number); ?>				
			<?php if($user->id){ echo form_hidden('user_id', $user->id); } ?>
			
		</div>
		
		<h2>Enrollment information</h2>
		<div>
			<table class="sc-table">
				<tr>
					<td>Grade/group</td>
					<td>Start date</td>
					<td>End date</td>
					<td></td>
				</tr>
				<tr style="display: none;">
					<td><?php echo form_dropdown('enrollment[grade][]', $student_group_options); ?></td>
					<td><?php echo form_date('enrollment[start_date][]',NULL); ?></td>
					<td><?php echo form_date('enrollment[end_date][]',NULL); ?></td>
					<td>
						<?php echo form_hidden('enrollment[disabled][]','true'); ?>
						<?php echo form_hidden('enrollment[id][]', '0'); ?>
						<?php echo form_input(array('type'=>'button','value'=>'Remove','class'=>'button')); ?>
					</td>
				</tr>
				<?php foreach($user->student->enrollment->get() AS $enrollment): ?>
					<tr>
						<td>
							<?php 
								echo form_dropdown('enrollment[grade][]', $student_group_options, $enrollment->group->name); 
							?>
							
						</td>
						<td><?php echo form_date('enrollment[start_date][]',$enrollment->start_date); ?></td>
						<td><?php echo form_date('enrollment[end_date][]',$enrollment->end_date); ?></td>
						<td>
							<?php echo form_hidden('enrollment[id][]', $enrollment->id); ?>
							<?php echo form_input(array('type'=>'button','value'=>'Remove','class'=>'button')); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				<tr>
					<td colspan="4">
						<?php echo form_input(array('type'=>'button','value'=>'Add enrollment','class'=>'button')); ?>
					</td>
				</tr>
			</table>
		</div>
		
		<h2>Parents/Guardians</h2>
		<div id="parent_information">
			<table class="sc-table">
				<tr>
					<td>First & last name</td>
					<td>Gender & birthdate</td>
					<td>Email & phone</td>
					<td></td>
				</tr>
				<tr style="display: none;">
					<td>
						<?php echo form_input('guardian[first_name][]','','placeholder="First name"'); ?>
						<?php echo form_input('guardian[last_name][]','','placeholder="Last name"'); ?>	
					</td>
					<td>
						<?php echo form_dropdown('guardian[gender][]',array('male'=>'Male','female'=>'Female')); ?>
						<?php echo form_date('guardian[date_of_birth][]',''); ?>	
					</td>
					<td>
						<?php echo form_input('guardian[email][]', '','placeholder="Email adress"'); ?>
						<?php echo form_input('guardian[phone_number][]','','placeholder="Phone number"'); ?>
					</td>
					<td>
						<?php echo form_hidden('guardian[disabled][]', 'true'); ?>
						<?php echo form_hidden('guardian[id][]', 0); ?>
							<?php echo form_hidden('guardian[user_id][]', 0); ?>
						<?php echo form_input(array('type'=>'button','value'=>'Remove','class'=>'button')); ?>
					</td>
				</tr>
				<?php foreach($user->student->guardian->get() AS $guardian): ?>
					<tr>
						<td>
							<?php echo form_input('guardian[first_name][]',$guardian->user->first_name,'placeholder="First name"'); ?>
							<?php echo form_input('guardian[last_name][]',$guardian->user->last_name,'placeholder="Last name"'); ?>	
						</td>
						<td>
							<?php echo form_dropdown('guardian[gender][]',array('male'=>'Male','female'=>'Female'),$guardian->user->gender); ?>
							<?php echo form_date('guardian[date_of_birth][]',$guardian->user->date_of_birth); ?>	
						</td>
						<td>
							<?php echo form_input('guardian[email][]', $guardian->user->email,'placeholder="Email adress"'); ?>
							<?php echo form_input('guardian[phone_number][]', $guardian->user->phone_number,'placeholder="Phone number"'); ?>
						</td>
						<td>
							<?php echo form_hidden('guardian[id][]', $guardian->id); ?>
							<?php echo form_hidden('guardian[user_id][]', $guardian->user_id); ?>
							<?php echo form_input(array('type'=>'button','value'=>'Remove','class'=>'button')); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				<tr>
					<td colspan="4">					
						<?php echo form_input(array('type'=>'button','value'=>'Add parent/guardian','class'=>'button')); ?>
					</td>
				</tr>
			</table>
		</div>
		
	</div>
	
	<?php echo form_submit('save','Save'); ?>


<?php echo form_close(); ?>

<?php include('search_users_pagination.php'); ?>

<table class="sc-table">
	<thead>
	<tr>
		<th colspan="3">Students</th>
		<th colspan="3">Parents</th>
	</tr>
	</thead>
	<tr>
		<td></td>
		<td>Name</td>
		<td>Phone number</td>
		<td></td>
		<td>Name</td>
		<td>Phone number</td>
	</tr>
	<?php if($users->exists() === FALSE): ?>
		<tr>
			<td colspan="6">No results</td>
		</tr>
	<?php endif; ?>
	<?php
		$shown_parents = array(); 
		foreach($users AS $user): 
		if(in_array($user->username,$shown_parents)){
			continue;
		}
	?>		
		<tr>
			<td>
				<?php if($user->phone_number): ?>
					<?php echo form_hidden('name',$user->first_name.' '.$user->middle_name.' '.$user->last_name); ?>
					<?php echo form_checkbox('selected[]',$user->username,null,'data-selecttype="students"'); ?>
				<?php endif; ?>
			</td>
			<td>
				<?php echo $user->first_name; ?>
				<?php echo $user->middle_name; ?>
				<?php echo $user->last_name; ?>
			</td>
			<td>
				<?php echo $user->phone_number; ?>
			</td>
			<td>
				<?php foreach($user->student->guardian->get() AS $parent): ?>
					<?php if($parent->user->phone_number): ?>
						<?php echo form_hidden('name',$parent->user->first_name.' '.$parent->user->middle_name.' '.$parent->user->last_name); ?>
						<?php echo form_checkbox('selected[]',$parent->user->username,null,'data-selecttype="parents"'); ?>
						<br />
					<?php endif; ?>
				<?php endforeach; ?>
			</td>
			<td>
				<?php foreach($user->student->guardian->get() AS $parent): ?>
					<?php echo $parent->user->first_name; ?>
					<?php echo $parent->user->middle_name; ?>
					<?php echo $parent->user->last_name; ?>
					<br />
				<?php endforeach; ?>
			</td>
			<td>
				<?php foreach($user->student->guardian->get() AS $parent): ?>
					<?php echo $parent->user->phone_number; ?>
					<br />
				<?php endforeach; ?>
			</td>
		</tr>

	<?php endforeach; ?>
</table>

<?php include('search_users_pagination.php'); ?>

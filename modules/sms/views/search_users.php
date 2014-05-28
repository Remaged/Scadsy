<table class="sc-table">
	<tr>
		<td></td>
		<td>Username</td>
		<td>Name</td>
		<td></td>
	</tr>
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
					<?php echo form_checkbox('selected[]',$user->username); ?>
				<?php endif; ?>
			</td>
			<td><?php echo $user->username; ?></td>
			<td>
				<?php echo $user->first_name; ?>
				<?php echo $user->middle_name; ?>
				<?php echo $user->last_name; ?>
			</td>
			<td></td>
		</tr>
		<?php foreach($user->student->guardian->get() AS $parent): 
			if(in_array($parent->user->username,$shown_parents)){
				continue;
			}
			$shown_parents[] = $parent->user->username; 
		?>
			<tr>
				<td>
					<?php if($parent->user->phone_number): ?>
						<?php echo form_hidden('name',$parent->user->first_name.' '.$parent->user->middle_name.' '.$parent->user->last_name); ?>
						<?php echo form_checkbox('selected[]',$parent->user->username); ?>
					<?php endif; ?>
					
				</td>
				<td><?php echo $parent->user->username; ?></td>
				<td>
					<?php echo $parent->user->first_name; ?>
					<?php echo $parent->user->middle_name; ?>
					<?php echo $parent->user->last_name; ?>
				</td>
				<td>
					parent of:
					<?php foreach($parent->student->get() AS $child): ?>
						<br /><?php echo $child->user->username; ?>
						(<?php echo $child->user->first_name; ?>)
					<?php endforeach; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		
	<?php endforeach; ?>
</table>
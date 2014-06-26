<?php include('search_users_pagination.php'); ?>

<table class="sc-table">
	<thead>
	<tr>
		<th colspan="2">Students</th>
		<th colspan="2">Parents</th>
	</tr>
	</thead>
	<tr>
		<td>Last name</td>
		<td>First name</td>
		<td>Full name</td>
		<td>Phone number</td>
	</tr>
	<?php if($users->exists() === FALSE): ?>
		<tr>
			<td colspan="6">No results</td>
		</tr>
	<?php endif; ?>
	<?php foreach($users AS $user): ?>		
		<tr data-username="<?php echo $user->username; ?>">
			<td>
				<?php echo $user->last_name; ?>
			</td>
			<td>
				<?php echo $user->first_name; ?>
			</td>
			<td>
				<?php foreach($user->student->guardian->get() AS $parent): ?>
					<?php echo $parent->user->first_name; ?>
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

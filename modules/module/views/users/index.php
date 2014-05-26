<h1>Users</h1>

<div class="button_container">
	<a id="add_new_user_button" href="<?php echo site_url(site_action_uri('add')); ?>" class="button">New user</a>
</div>



<?php include('pagination.php'); ?>
 
<table class="sc-table" id="user_list">
	<thead>
		<tr>
			<th>Username</th>
			<th>First name</th>
			<th>Last name</th>
			<th>Email</th>
			<th>Phone number</th>
		</tr>
	</thead>
	
	<?php foreach($users AS $user): ?>
		
		<tr onclick="window.location = '<?php echo site_url(site_action_uri('edit/'.$user->username)); ?>'">
			<td><?php echo $user->username; ?></td>
			<td><?php echo $user->first_name; ?></td>
			<td><?php echo $user->last_name; ?></td>
			<td><?php echo $user->email; ?></td>
			<td><?php echo $user->phone_number; ?></td>
		</tr>
	<?php endforeach; ?>

</table>

<?php include('pagination.php'); ?>
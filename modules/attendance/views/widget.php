<h2>Absent Students</h2>

<table class="sc-table">
	<thead>
		<tr>
			<th>First name</th>
			<th>Last name</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($attendances as $attendance) { ?>
	<?php $user = new User(); $user->get_where(array('id' => $attendance->user_id)); ?>
		<tr>
			<td><?php echo $user->first_name; ?></td>
			<td><?php echo $user->middle_name . " " . $user->last_name;?></td>
			<td><?php echo anchor(site_url("sms/Sms_messager/new_sms/".$user->id), "Send text to parents"); ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>


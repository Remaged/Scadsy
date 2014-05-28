<h1>
	SMS detail info
</h1>

<div class="button_container">
	<a href="<?php echo site_url(site_action_uri('index')); ?>" class="button">Back to list</a>
</div>

<div class="sc-form">
	<?php echo form_fieldset('message'); ?>
		<?php echo $sms->message; ?>
	<?php echo form_fieldset_close(); ?>
		
	<?php echo form_fieldset('Time and date'); ?>
		<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $sms->date_time)->format('H:i  \a\t  d M Y'); ?>
	<?php echo form_fieldset_close(); ?>
		
	<?php echo form_fieldset('Receivers'); ?>
		<table class='sc-table'>
			<thead>
				<tr>
					<th>Username</th>
					<th>Name</th>
					<th>Phone number</th>
				</tr>
			</thead>	
			<?php foreach($sms->user AS $user): ?>
				<tr>
					<td><?php echo $user->username; ?></td>
					<td>
						<?php echo $user->first_name; ?>
						<?php echo $user->middle_name; ?>
						<?php echo $user->last_name; ?>
					</td>
					<td><?php echo $user->phone_number; ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php echo form_fieldset_close(); ?>
	
	<?php echo form_fieldset('Replies'); ?>
		<table class='sc-table'>
			<thead>
				<tr>
					<th>User</th>
					<th>Time and date</th>
					<th>Message</th>
				</tr>
			</thead>	
			<?php if($sms->reply->exists() === FALSE): ?>
				<tr>
					<td colspan="3">
						There are no replies to this message.
					</td>
				</tr>
			<?php endif; ?>
			<?php foreach($sms->reply AS $reply): ?>
				<tr>
					<td><?php echo (new User($reply->user_id))->get()->username; ?></td>
					<td>
						<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $reply->date_time)->format('H:i  \a\t  d M Y'); ?>
					</td>
					<td><?php echo $reply->message; ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php echo form_fieldset_close(); ?>

</div>
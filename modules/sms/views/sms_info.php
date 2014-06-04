<h1>
	SMS detail info
</h1>

<div class="button_container">
	<a href="<?php echo site_url(site_action_uri('index')); ?>" class="button">Back to list</a>
</div>

<div class="sc-form">
	<?php echo form_fieldset('Message'); ?>
		<?php echo $sms->message; ?>
	<?php echo form_fieldset_close(); ?>
	
	<?php echo form_fieldset('Sent by'); ?>
		<?php $user = new User(); echo $user->get_where(array('id'=>$sms->user_id))->username;  ?>
	<?php echo form_fieldset_close(); ?>
		
	<?php echo form_fieldset('Time and date'); ?>
		<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $sms->date_time)->format('H:i  \a\t  d M Y'); ?>
	<?php echo form_fieldset_close(); ?>
		
	<?php echo form_fieldset('Receivers'); ?>
		<table class='sc-table'>
			<thead>
				<tr>
					<th>Name</th>
					<th>Phone number</th>
					<th>Time of receipt</th>
				</tr>
			</thead>	
			<?php foreach($sms->user AS $user): ?>
				<tr>
					<td>
						<?php echo $user->first_name; ?>
						<?php echo $user->last_name; ?>
					</td>
					<td><?php echo $user->phone_number; ?></td>
					<td>
						<?php if(!$user->join_sent_date_time): ?>
							not received (yet)
						<?php else: ?>
							<?php echo DateTime::createFromFormat('Y-m-d H:i:s',$user->join_sent_date_time)->format('d M Y  \a\t  H:i'); ?>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php echo form_fieldset_close(); ?>
	
	<?php echo form_fieldset('Replies'); ?>
		<table class='sc-table'>
			<thead>
				<tr>
					<th>Name</th>
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
					<td>
						<?php 
							$user = new User($reply->user_id);
							echo $user->first_name.' '.$user->last_name; 
						?>
					</td>
					<td>
						<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $reply->date_time)->format('d M Y  \a\t  H:i'); ?>
					</td>
					<td><?php echo $reply->message; ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php echo form_fieldset_close(); ?>

</div>
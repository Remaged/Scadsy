<h1>SMS</h1>

<div class="button_container">
	<a id="add_new_sms" href="<?php echo site_url(site_action_uri('new_sms')); ?>" class="button">New SMS</a>
</div>


<?php include('pagination.php'); ?>
 
<table class="sc-table" id="sms_list">
	<thead>
		<tr>
			<th>Message</th>
			<th>Sent by</th>
			<th>Receivers</th>
			<th>Replies</th>
			<th>Time and date</th>
		</tr>
	</thead>
	
	<?php foreach($smses AS $sms): ?>		
		<tr onclick="window.location = '<?php echo site_url(site_action_uri('detail/'.$sms->id)); ?>'">
			<td><?php echo $sms->message; ?></td>
			<td><?php echo $sms->sender->username; ?> (<?php echo $sms->sender->first_name.' '.$sms->sender->middle_name.' '.$sms->sender->last_name; ?>)</td>	
			<td><?php echo $sms->user->result_count(); ?></td>
			<td><?php echo $sms->reply->result_count(); ?></td>
			<td>
				<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $sms->date_time)->format('H:i  \a\t  d M Y'); ?>
			</td>
		</tr>
	<?php endforeach; ?>

</table>

<?php include('pagination.php'); ?>
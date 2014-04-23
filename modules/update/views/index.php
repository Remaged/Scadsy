<h1>Updates</h1>

<?php if ($updates->result_count() == 0) { ?>
	<p>There currently are no updates!</p>
<?php } else { ?>
<table class="sc-table">
	<thead>
		<tr>
			<th>Type</th>
			<th>Name</th>
			<th>Current Version</th>
			<th>New Version</th>
			<th>Action</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Type</th>
			<th>Name</th>
			<th>Current Version</th>
			<th>New Version</th>
			<th>Action</th>
		</tr>
	</tfoot>
	<?php foreach($updates as $update) { 
		if($update->module_id != 0) {
			$update->module->get();
		}
		?>
		<tr>
			<td><?php echo ($update->module_id == 0) ? 'System' : 'Module'; ?></td>
			<td><?php echo ($update->module_id == 0) ? 'SCADSY' : $update->module->name; ?></td>
			<td><?php echo ($update->module_id == 0) ? VERSION : $update->module->version; ?></td>
			<td><?php echo $update->to_version; ?></td>
			<td><?php echo post_link("update/updates/install", "Install update!", array("update" => $update->id), "
				if(data.indexOf('failed') == -1) {
					showNotification('succes', data); 
					myLink.closest('tr').fadeOut();
				} else {
					showNotification('error', data); 
				}				
			"); ?></td>
		</tr>
	<?php } ?>
</table>
<?php } ?>
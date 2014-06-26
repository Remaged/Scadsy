<h1><?php echo __('Updates'); ?></h1>

<?php if ($updates->result_count() == 0) { ?>
	<p><?php echo __('There currently are no updates!'); ?></p>
<?php } else { ?>
<table class="sc-table">
	<thead>
		<tr>
			<th><?php echo __('Type'); ?></th>
			<th><?php echo __('Name'); ?></th>
			<th><?php echo __('Current Version'); ?></th>
			<th><?php echo __('New Version'); ?></th>
			<th><?php echo __('Action'); ?></th>
			<th><?php echo __('Change Log'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th><?php echo __('Type'); ?></th>
			<th><?php echo __('Name'); ?></th>
			<th><?php echo __('Current Version'); ?></th>
			<th><?php echo __('New Version'); ?></th>
			<th><?php echo __('Action'); ?></th>
			<th><?php echo __('Change Log'); ?></th>
		</tr>
	</tfoot>
	<?php foreach($updates as $update) { 
		if($update->module_id != 0) {
			$m = new Module($update->module_id);
			$m = $m->get();
		}
		?>
		<tr>
			<td><?php echo ($update->module_id == 0) ? __('System') : __('Module'); ?></td>
			<td><?php echo ($update->module_id == 0) ? 'SCADSY' : $m->name; ?></td>
			<td><?php echo ($update->module_id == 0) ? VERSION : $m->version; ?></td>
			<td><?php echo $update->to_version; ?></td>
			<td><?php echo post_link("update/updates/install", __("Install update!"), array("update" => $update->id), "
				if(data.indexOf('failed') == -1) {
					showNotification('succes', data); 
					myLink.closest('tr').fadeOut();
				} else {
					showNotification('error', data); 
				}				
			"); ?></td>
			<td><?php echo $update->change_log; ?></td>
		</tr>
	<?php } ?>
</table>
<?php } ?>
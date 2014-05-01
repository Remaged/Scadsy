<h2>Updates Available!</h2>

<p><a href="<?php echo site_url('update/updates/index'); ?>">Please click here to install the available updates.</a></p>

<table class="sc-table">
	<thead>
		<tr>
			<th><?php echo __('Name'); ?></th>
			<th><?php echo __('New Version'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($updates as $update) {
			
		if($update->module_id != 0) {
			$m = (new Module($update->module_id))->get();
		}
		?>
		<tr>
			<td><?php echo ($update->module_id == 0) ? 'SCADSY' : $m->name; ?></td>
			<td><?php echo $update->to_version; ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
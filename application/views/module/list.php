<table border=1>
	<tr>
		<th>Name</th>
		<th>Directory</th>
		<th>Enabled</th>
		<th>Action</th>
	</tr>

<?php foreach($modules as $module) { ?>
	<tr>
		<td><?php echo $module->name; ?></td>
		<td><?php echo $module->directory; ?></td>
		<td><?php echo $module->status; ?></td>
		<td>
			<?php 
				if($module->status == 'enabled') {
					echo anchor('module/disable/'.$module->directory, 'Disable');
				} else {
					echo anchor('module/enable/'.$module->directory, 'Enable');
				}
			?>
		</td>
	</tr>
<?php } ?>
</table>
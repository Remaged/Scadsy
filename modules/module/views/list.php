<table border=1>
	<tr>
		<th>Name</th>
		<th>Directory</th>
		<th>Enabled</th>
	</tr>

<?php foreach($modules as $module) { ?>
	<tr>
		<td><?php echo $module->name; ?></td>
		<td><?php echo $module->directory; ?></td>
		<td><?php echo $module->status; ?></td>
	</tr>
<?php } ?>
</table>
<?php echo validation_errors(); ?>
<?php echo form_open('admin'); ?>

<?php foreach($modules_per_school AS $school_db => $school_modules): ?>
	
	<h2><?php echo $school_db; ?></h2>
	<table border=1>
		<tr>
			<th>Name</th>
			<th>Directory</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	
	<?php foreach($school_modules as $module): ?>
		<tr>
			<td><?php echo $module->name; ?></td>
			<td><?php echo $module->directory; ?></td>
			<td><?php echo $module->status; ?></td>
			<td>
				<?php 
					if($module->status == 'enabled') {
						echo anchor('admin/disable/'.$module->directory, 'Disable');
					} else {
						echo anchor('admin/enable/'.$module->directory, 'Enable');
					}
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endforeach; ?>

<?php echo form_close(); ?>
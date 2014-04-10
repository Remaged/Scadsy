<h1>
	Manage modules
</h1>

<?php echo validation_errors(); ?>
<?php echo form_open('module/module/save_modules',array('id'=>'modules_form_superadmin')); ?>

<div id="accordion">

<?php foreach($modules_per_school AS $school_db => $school_modules): ?>
	
	<h3><?php echo $school_db; ?></h3>
	<div>
		<table border=1>
			<tr>
				<th>Name</th>
				<th>Directory</th>
				<th>Status</th>
			</tr>
		
		<?php foreach($school_modules as $module): ?>
			<tr>
				<td><?php echo $module->name; ?></td>
				<td><?php echo $module->directory; ?></td>
				<td>
					<?php if($module->status === NULL): ?>
						Not installed
					<?php else: ?>
						<div class="switchbutton">
						<?php 
							$checkbox_data = array(
								'name' => 'status['.$school_db.']['.$module->directory.']',
								'checked' => $module->status == 'enabled' ? TRUE : FALSE,
								'value' => '1',
								'data-school' => $school_db,
								'data-module' => $module->directory
							);			
							echo form_checkbox($checkbox_data); 
						?>
						</div>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	</div>
<?php endforeach; ?>

</div>

<?php echo form_submit('submit', 'Save');?>

<?php echo form_close(); ?>
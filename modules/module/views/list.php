<h1>
	Manage modules
</h1>

<div id="module_manager_notices">
	<?php echo validation_errors(); ?>
</div>

<?php echo form_open('module/module/save_modules',array('id'=>'modules_form_admin')); ?>
	
	<table id="module_list">
		<tr>
			<th>Name</th>
			<th>Directory</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	
	<?php foreach($modules as $module): ?>
		<tr>
			<td><?php echo $module->name; ?></td>
			<td><?php echo $module->directory; ?></td>
			<td class="switchbutton">	
				<?php 
					if($module->status !== 'not_installed') {
						$checkbox_data = array(
							'name' => 'status['.$module->directory.']',
							'checked' => $module->status == 'enabled' ? TRUE : FALSE,
							'value' => '1',
							'data-module' => $module->directory
						);		
						echo form_checkbox($checkbox_data); 
					}
				?>	
			</td>
			<td>
				<?php if ($module->status === 'not_installed') { ?>
					<?php echo post_link('module/module/install', 'Install', array("module" => $module->directory), "location.reload()","callback_install_fail()"); ?>
				<?php } else if ($module->status === 'disabled') { ?>
					<?php echo post_link('module/module/uninstall', 'Uninstall', array("module" => $module->directory),  "location.reload()","callback_deinstall_fail()"); ?>
				<?php } ?>	
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	
	<?php echo form_submit('submit', 'Save');?>

<?php echo form_close(); ?>
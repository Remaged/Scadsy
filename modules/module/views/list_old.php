<h1>Manage modules</h1>

<div id="module_manager_notices">
	<?php echo validation_errors(); ?>
</div>


<div class="sc-table-filter">
	<a class="active" href="">Everything <span>(6)</span></a> | 
	<a href="">Enabled <span>(5)</span></a>
</div>

<div class="sc-table-nav">
	<select>
		<option>Actions</option>
		<option>Enable</option>
		<option>Disable</option>
		<option>Delete all modules</option>
	</select>
	<button>Execute</button>
</div>

<?php echo form_open('module/module/save_modules',array('id'=>'modules_form_admin')); ?>
	
	<table id="module_list" class="sc-table">
		<thead>
			<tr>
				<th><input type="checkbox"></th>
				<th>Name</th>
				<th>Directory</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th><input type="checkbox"></th>
				<th>Name</th>
				<th>Directory</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</tfoot>
	
	<?php foreach($modules as $module): ?>
		<tr>
			<td><input type="checkbox"></td>
			<td><?php echo $module->name; ?></td>
			<td><?php echo $module->directory; ?></td>
			<td>	
				<?php 
					if($module->status !== 'not_installed') {
						echo ucfirst($module->status);
					}
				?>	
			</td>
			<td>
				<?php if ($module->status === 'not_installed') { ?>
					<?php echo post_link('module/module/install', 'Install', array("module" => $module->directory), "location.reload()","callback_install_fail()"); ?>
				<?php } else if ($module->status === 'disabled') { ?>
					<?php echo post_link('module/module/uninstall', 'Uninstall', array("module" => $module->directory),  "location.reload()","callback_deinstall_fail()"); ?>
				<?php } else { ?>
					---
				<?php } ?>		
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	
	<?php echo form_submit('submit', 'Save');?>

<?php echo form_close(); ?>
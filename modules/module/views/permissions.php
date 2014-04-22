<h1>Manage permissions</h1>

<div id="accordion">
<?php foreach($modules as $module) { ?>
	<h3><?php echo $module->name; ?> (<?php echo $module->directory;?>)</h3>
	<div>		
		<?php $module_pages = array(); ?>
		<table class="sc-table">
		<?php foreach($module->permissions as $permission) { ?>
			<?php if(!in_array($permission->controller_name.'/'.$permission->action_name, $module_pages)): ?>
				<?php $module_pages[] = $permission->controller_name.'/'.$permission->action_name; ?>		
				<thead>
					<tr>Group</tr>
					<tr>Allowed</tr>
					<tr>Action</tr>
				</thead>
				<tfoot>
					<tr>Group</tr>
					<tr>Allowed</tr>
					<tr>Action</tr>
				</tfoot>		
			<?php endif; ?>		
			<tr>											
				<td><?php echo $permission->group_name; ?></td>
				<td><?php echo ($permission->allowed == 1) ? 'Yes' : 'No'; ?></td>
				<td>
					<?php if($permission->allowed == 1) {
						echo 'Disallow';
					} else {
						echo 'Allow';
					} ?>						
				</td>		
			</tr>
				
		<?php } ?>	
		</table>
	</div>
<?php } ?>
</div>
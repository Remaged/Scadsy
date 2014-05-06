<?php foreach($groups as $group): ?>	
	<tr>											
		<td style="width:20px;">
			<?php echo form_open(site_action_uri('permission_edit')); ?>
				<?php echo form_hidden(array(
							"action" => $action->name, 
							"controller" => $action->controller,
							"module" => $action->module->directory,
							"parent_group"=>isset($parent_group_name) ? $parent_group_name : NULL,
							"group" => $group->name)); ?>
				<input type="checkbox" value="1" name="allowed" <?php echo ($group->permission->allowed == 1) ? 'checked' : '';?>>
			<?php echo form_close(); ?>															
		</td>	
		<td>
			<?php echo $group->name; ?>	
		</td>	
	</tr>
	<?php if($group->child_group->exists()): ?>
		<tr>
			<td colspan="2">
				<table class="sc-table" 
					data-group="<?php echo $group->name; ?>" 
					data-action="<?php echo $action->name; ?>" 
					data-controller="<?php echo $action->controller; ?>"
					data-module="<?php echo $action->module->directory; ?>"
					>
					<?php
						$parent_group_name = $group->name;
						$groups = $group->child_group; 
						include('permissions_group_options.php'); 
					?>
				</table>				
			</td>
		</tr>
	<?php endif; ?>
<?php endforeach; ?>
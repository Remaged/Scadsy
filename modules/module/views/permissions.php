<h1>Manage permissions</h1>

<div id="accordion">
	<?php foreach($modules as $module): ?>
		<h3>
			<?php echo $module->name; ?> (<?php echo $module->directory;?>)
		</h3>
		<div>			
			<?php foreach($module->action as $action): ?>
				<table class="sc-table">
					<thead>
						<tr>
							<th colspan="2">
								<?php echo $action->controller.'/'.$action->name; ?>
							</th>
						</tr>
					</thead>			
					<?php foreach($action->group as $group): ?>
						<tr>											
							<td><?php echo $group->name; ?></td>
							<td>
								<?php echo form_open('module/manage_modules/permission_edit'); ?>
									<?php echo form_hidden(array(
												"action" => $action->name, 
												"controller" => $action->controller,
												"module" => $module->directory,
												"group" => $group->name)); ?>
									<div class="switchbutton">
										<input type="checkbox" value="1" name="allowed" <?php echo ($group->permission->allowed == 1) ? 'checked' : '';?>>
									</div>
								<?php echo form_close(); ?>															
							</td>		
						</tr>					
					<?php endforeach; ?>
				</table>
			<?php endforeach; ?>
		</div>	
	<?php endforeach; ?>
</div>
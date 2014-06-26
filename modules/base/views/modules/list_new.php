<h1>Manage modules</h1>

<div id="module_manager_notices">
	<?php echo validation_errors(); ?>
</div>

<table class="sc-table">
	<thead>
		<tr>
			<!--   <th class="checkbox"><input type="checkbox"></th> -->
			<th class="module">Module</th>
			<th>Description</th>
		</tr>
	</thead>
	<?php foreach($modules as $module): ?>
		<tr class="<?php echo $module->status; ?>">
			<!--  <td class="checkbox"><span class="stripe"></span><input type="checkbox"></td> -->
			<td class="module"><span class="stripe"></span>
				<div class="sc-module-name"><?php echo $module->name; ?></div>
				<div class="sc-module-actions">
					<?php if ($module->status == 'disabled') { 
						echo post_link(site_action_uri('enable'), "Enable", array("module" => $module->directory), "showNotification('succes', 'Module ".$module->directory." has been enabled!'); location.reload();","showNotification('fail','Module ".$module->directory." could not be enabled.')");
						echo " | ";
						echo post_link(site_action_uri('uninstall'), "Uninstall", array("module" => $module->directory), "showNotification('succes', 'Module ".$module->directory." has been uninstalled!'); location.reload();","showNotification('fail','Module ".$module->directory." could not be uninstalled. There may be other modules that depend on this module. Uninstall those before uninstalling this module.')");
					} else if ($module->status == 'enabled') { 
						echo post_link(site_action_uri('disable'), "Disable", array("module" => $module->directory), "showNotification('succes', 'Module ".$module->directory." has been disabled!'); location.reload();","showNotification('fail','Module ".$module->directory." could not be disabled.')");
					} else if ($module->status == 'not_installed') { 
						echo post_link(site_action_uri('install'), "Install", array("module" => $module->directory), "showNotification('succes', 'Module ".$module->directory." has been installed!'); location.reload();","showNotification('fail','Module ".$module->directory." could not be installed. This module might depend on other modules. Make sure those are installed first.')");
					} 
					
					if($module->status != 'not_installed') {
						echo ' | '.post_link(site_action_uri('refresh'), "Refresh", array("module" => $module->directory), "showNotification('succes', 'Module ".$module->directory." has been refreshed!'); location.reload();");
					}
					?>
					
					<?php /* for development testing
						<?php  echo form_open(site_action_uri('install')); ?>
							<?php echo form_hidden('module',$module->directory); ?>
							
							<?php echo form_submit('submit','install'); ?>
						
						<?php echo form_close();  ?>
						<?php  echo form_open(site_action_uri('uninstall')); ?>
							<?php echo form_hidden('module',$module->directory); ?>
							
							<?php echo form_submit('submit','uninstall'); ?>
						
						<?php echo form_close();  ?>
					 */ ?>
					  
				</div>
			</td>	
			<td>
				<div class="sc-module-description"><?php echo $module->description; ?></div>
				<div class="sc-module-meta">
					Version: <?php echo $module->version; ?>
					<?php if ($module->author_uri != '' && $module->author != '') { ?>
					 | By <a target="_blank" href="<?php echo $module->author_uri; ?>"><?php echo $module->author; ?></a>
					<?php } else if ($module->author != '' && $module->author_uri == '') { ?>
					 | By <?php echo $module->author; ?>	
					<?php } ?> 	
					<?php if ($module->uri != '') { ?>
					  | <a target="_blank" href="<?php echo $module->uri; ?>">Visit plugin site</a></div>
					 <?php } ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
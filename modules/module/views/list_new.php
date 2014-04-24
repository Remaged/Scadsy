<h1>Manage modules</h1>

<div id="module_manager_notices">
	<?php echo validation_errors(); ?>
</div>

<!--
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
-->
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
						echo post_link(site_action_uri('enable'), "Enable", array("module" => $module->directory), "showNotification('succes', 'Module ".$module->directory." has been enabled!'); location.reload();");
						echo " / ";
						echo post_link(site_action_uri('uninstall'), "Uninstall", array("module" => $module->directory), "showNotification('succes', 'Module ".$module->directory." has been uninstalled!'); location.reload();");
					} else if ($module->status == 'enabled') { 
						echo post_link(site_action_uri('disable'), "Disable", array("module" => $module->directory), "showNotification('succes', 'Module ".$module->directory." has been disabled!'); location.reload();");
					} else if ($module->status == 'not_installed') { 
						echo post_link(site_action_uri('install'), "Install", array("module" => $module->directory), "showNotification('succes', 'Module ".$module->directory." has been installed!'); location.reload();");
					} ?>
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
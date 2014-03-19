<div id="accordion">
<?php foreach($modules as $module) { ?>
	<h3><?php echo $module->name; ?> (<?php echo $module->directory;?>)</h3>
	<div>
		<div class="table">
			<div class="tr">
				<div class="th">Page</div>
				<div class="th">Controller</div>
				<div class="th">Module</div>
				<div class="th">Group</div>
				<div class="th switchbutton">Status</div>
			</div>
		<?php foreach($module->permissions as $permission) { ?>
			<?php echo form_open('module/module/permissionEdit'); ?>
			<div class="tr">			
				<?php echo form_hidden(array(
								"action" => $permission->action_name, 
								"controller" => $permission->controller_name,
								"module" => $permission->module_name,
								"group" => $permission->group_name)); ?>
				<div class="td"><?php echo $permission->action_name; ?> </div>
				<div class="td"><?php echo $permission->controller_name; ?></div>
				<div class="td"><?php echo $permission->module_name; ?></div>
				<div class="td"><?php echo $permission->group_name; ?></div>
				<div class="td switchbutton"><input type="checkbox" value="1" name="allowed" <?php echo ($permission->allowed == 1) ? 'checked' : '';?>></div>		
			</div>
				<?php echo form_close(); ?>
		<?php } ?>	
		</div>
	</div>
<?php } ?>
</div>

<script>
$(function() {
	$( "#accordion" ).accordion({ collapsible: true, active: false, heightStyle: "content" });
	
	// Change the submit for each form
	$("#accordion form").each(function() {
		$(this).submit(function() {
			$.ajax({
	           type: "POST",
	           url: $(this).attr('action'),
	           data: $(this).serialize(), 
	           success: function(data)
	           {
	           }
	         });
	
		    return false; 
	    });
	});
	
	$(".switchbutton input").switchButton({
		on_label: 'ENABLED',
		off_label: 'DISABLED',
		on_callback: function() {
			$(this).closest('form').submit();
		},
		off_callback: function() {  
			$(this).closest('form').submit(); 	
		}	
	});
});
</script>
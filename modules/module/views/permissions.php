<style>
	#accordion table{
		border-collapse:separate;
		border-spacing: 0px 5px;
		width: 100%;
		border: 0px;
	}
	#accordion table th{
		background: white;
		font-weight: bold;
		margin: 15px 0;
		text-align:left;
		border: 0px;
		border-bottom:1px solid #C0C0C0;
	}
	
	#accordion table td{
		background: #F2F2F2;
		border: 0px;
	}
</style>

<h1>Manage permissions</h1>



<div id="accordion">
<?php foreach($modules as $module) { ?>
	<h3><?php echo $module->name; ?> (<?php echo $module->directory;?>)</h3>
	<div>		
		<?php $module_pages = array(); ?>
		<table>
		<?php foreach($module->permissions as $permission) { ?>
			<?php if(!in_array($permission->controller_name.'/'.$permission->action_name, $module_pages)): ?>
				<?php $module_pages[] = $permission->controller_name.'/'.$permission->action_name; ?>		
				<tr>
					<th colspan="2">
						<?php echo $permission->controller_name.'/'.$permission->action_name; ?>
					</th>
				</tr>		
			<?php endif; ?>		
			<tr>											
				<td style="width: 130px;"><?php echo $permission->group_name; ?></td>
				<td>
					<?php echo form_open('module/module/permissionEdit'); ?>
						<?php echo form_hidden(array(
									"action" => $permission->action_name, 
									"controller" => $permission->controller_name,
									"module" => $permission->module_name,
									"group" => $permission->group_name)); ?>
						<div class="switchbutton">
							<input type="checkbox" value="1" name="allowed" <?php echo ($permission->allowed == 1) ? 'checked' : '';?>>
						</div>
					<?php echo form_close(); ?>
				</td>		
			</tr>
				
		<?php } ?>	
		</table>
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
		on_label: 'ALLOW',
		off_label: 'DENY',
		on_callback: function() {
			$(this).closest('form').submit();
		},
		off_callback: function() {  
			$(this).closest('form').submit(); 	
		}	
	});
});
</script>
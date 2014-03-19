<script>
$(function(){
	$(".switchbutton input").switchButton({
		on_label: 'ENABLED',
		off_label: 'DISABLED',
		on_callback: function() {
			save_module_status(this,'enable');
		},
		off_callback: function() {  
			save_module_status(this,'disable');	
		}	
	});
	
	$("#modules_form_admin [name='submit']").remove();
})

function save_module_status(input_elm, action){
	var postdata = {
		module : $(input_elm).attr('data-module'),
		csrf_token : $("#modules_form_admin input[name='csrf_token']").val()
	};
	$.post(
		action,
		postdata,
		function(data){
			$("#module_manager_notices").html("Reload page for changes to become visible.");
			$(elm).closest("tr").find(".status_field").text(action+'d');
		}
	);
}
</script>

<div id="module_manager_notices">
	<?php echo validation_errors(); ?>
</div>

<?php echo form_open('module/module/save_modules',array('id'=>'modules_form_admin')); ?>


<table border=1>
	<tr>
		<th>Name</th>
		<th>Directory</th>
		<th>Status</th>
	</tr>

<?php foreach($modules as $module) { ?>
	<tr>
		<td><?php echo $module->name; ?></td>
		<td><?php echo $module->directory; ?></td>
		<td>
			<div class="switchbutton">
			<?php 
				$checkbox_data = array(
					'name' => 'status['.$module->directory.']',
					'checked' => $module->status == 'enabled' ? TRUE : FALSE,
					'value' => '1',
					'data-module' => $module->directory
				);			
				echo form_checkbox($checkbox_data); 
			?>
			</div>
		</td>
	</tr>
<?php } ?>
</table>

<?php echo form_submit('submit', 'Save');?>

<?php echo form_close(); ?>
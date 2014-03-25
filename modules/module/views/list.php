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
<style>
	table#module_list{
		border-collapse:separate;
		border-spacing: 0px 5px;
		width: 100%;
		border: 0px;
	}
	#module_list tr:first-child th{
		background: white;
		font-weight: bold;
		margin: 15px 0;
		text-align:left;
		border: 0px;
		border-bottom:1px solid #C0C0C0;
	}
	
	#module_list td{
		background: #F2F2F2;
		border: 0px;
	}
</style>

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
		<th class="switchbutton">Status</th>
	</tr>

<?php foreach($modules as $module): ?>
	<tr>
		<td><?php echo $module->name; ?></td>
		<td><?php echo $module->directory; ?></td>
		<td class="switchbutton">

			<?php 
				$checkbox_data = array(
					'name' => 'status['.$module->directory.']',
					'checked' => $module->status == 'enabled' ? TRUE : FALSE,
					'value' => '1',
					'data-module' => $module->directory
				);			
				echo form_checkbox($checkbox_data); 
			?>

		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo form_submit('submit', 'Save');?>

<?php echo form_close(); ?>
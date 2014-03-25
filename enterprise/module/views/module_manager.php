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

<script>
$(function(){
	$( "#accordion" ).accordion({ collapsible: true, active: false, heightStyle: "content" });

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
		
	$("#modules_form_superadmin [name='submit']").remove();

})

function save_module_status(input_elm, action){
	var postdata = {
		school_db : $(input_elm).attr('data-school'),
		module : $(input_elm).attr('data-module'),
		csrf_token : $("#modules_form_superadmin input[name='csrf_token']").val()
	};
	$.post(
		action,
		postdata,
		function(data){
			$(elm).closest("tr").find(".status_field").text(action+'d');
		}
	);
}
</script>
<h1>
	Manage modules
</h1>

<?php echo validation_errors(); ?>
<?php echo form_open('module/module/save_modules',array('id'=>'modules_form_superadmin')); ?>

<div id="accordion">

<?php foreach($modules_per_school AS $school_db => $school_modules): ?>
	
	<h3><?php echo $school_db; ?></h3>
	<div>
		<table border=1>
			<tr>
				<th>Name</th>
				<th>Directory</th>
				<th>Status</th>
			</tr>
		
		<?php foreach($school_modules as $module): ?>
			<tr>
				<td><?php echo $module->name; ?></td>
				<td><?php echo $module->directory; ?></td>
				<td>
					<?php if($module->status === NULL): ?>
						Not installed
					<?php else: ?>
						<div class="switchbutton">
						<?php 
							$checkbox_data = array(
								'name' => 'status['.$school_db.']['.$module->directory.']',
								'checked' => $module->status == 'enabled' ? TRUE : FALSE,
								'value' => '1',
								'data-school' => $school_db,
								'data-module' => $module->directory
							);			
							echo form_checkbox($checkbox_data); 
						?>
						</div>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	</div>
<?php endforeach; ?>

</div>

<?php echo form_submit('submit', 'Save');?>

<?php echo form_close(); ?>
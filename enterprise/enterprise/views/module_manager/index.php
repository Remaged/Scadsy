<style>
	h2{
		font-weight: bold;
		font-size: 1.2em;
		margin: 10px 0px;
	}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>

	$(function(){
		$("#modules_form_superadmin [name='submit']").remove();
		
		$("#modules_form_superadmin input[type='checkbox']").change(function(){
			var elm = this;
			var action = ($(this).is(':checked')) ? 'enable' : 'disable';
			var postdata = {
				school_db : $(this).attr('data-school'),
				module : $(this).attr('data-module'),
				csrf_token : $("#modules_form_superadmin input[name='csrf_token']").val()
			};
			$.post(
				'module/'+action,
				postdata,
				function(data){
					$(elm).closest("tr").find(".status_field").text(action+'d');
				}
			);
			
		})

	})
	
</script>

<?php echo validation_errors(); ?>
<?php echo form_open('module/save_modules',array('id'=>'modules_form_superadmin')); ?>

<?php foreach($modules_per_school AS $school_db => $school_modules): ?>
	
	<h2><?php echo $school_db; ?></h2>
	<table border=1>
		<tr>
			<th>Name</th>
			<th>Directory</th>
			<th>Status</th>
			<th>Enable</th>
		</tr>
	
	<?php foreach($school_modules as $module): ?>
		<tr>
			<td><?php echo $module->name; ?></td>
			<td><?php echo $module->directory; ?></td>
			<td class='status_field'><?php echo $module->status; ?></td>
			<td>
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
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endforeach; ?>

<?php echo form_submit('submit', 'Save');?>

<?php echo form_close(); ?>
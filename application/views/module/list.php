<table border=1>
	<tr>
		<th>Name</th>
		<th>Directory</th>
		<th>Enabled</th>
		<th>Action</th>
		<th>Remove</th>
	</tr>

<?php foreach($modules as $module) { ?>
	<tr>
		<td><?php echo $module->name; ?></td>
		<td><?php echo $module->directory; ?></td>
		<td><?php echo $module->status; ?></td>
		<td>
			<?php 
				if($module->status == 'enabled') {
					echo anchor('module/disable/'.$module->directory, 'Disable');
				} else {
					echo anchor('module/enable/'.$module->directory, 'Enable');
				}
			?>
		</td>
		<td>
			<?php if($module->status == 'disabled') { ?>
				<a class="delete" href="<?php echo base_url('module/delete/'.$module->directory); ?>">Delete</a>					
			<?php } ?>
		</td>
	</tr>
<?php } ?>

</table>

<div id="dialog-confirm" title="Remove module?">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This module will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>

<script>
  $(function() {
    $( "#dialog-confirm" ).dialog({
      dialogClass: "no-close",
      autoOpen: false,
      resizable: false,
      height:160,
      modal: true,
      buttons: {
        "Delete module": function() {
          $( this ).dialog( "close" );
          alert("IMPLEMENT THIS");
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });
    
    $('.delete').click(function() {
    	$( "#dialog-confirm" ).dialog( "open" );
    	return false;
    });
  });
  </script>
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
				} else if ($module->status == 'disabled') {
					echo anchor('module/enable/'.$module->directory, 'Enable');
				} else if ($module->status == 'not_installed') {
					echo anchor('module/install/'.$module->directory, 'Install');
				}
			?>
		</td>
		<td>
			<?php if($module->status == 'disabled') { ?>
				<a href="<?php echo site_url('module/uninstall/'.$module->directory); ?>">Uninstall</a>					
			<?php } ?>
		</td>
	</tr>
<?php } ?>

</table>

<div id="dialog-confirm" title="Remove module?">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>When this model gets deleted all of its data will be removed. Are you sure you want to delete this module?</p>
</div>

<script>
  $(function() {
    $( "#dialog-confirm" ).dialog({
      dialogClass: "no-close",
      autoOpen: false,
      resizable: false,
      height:180,
      modal: true,
      buttons: {
        "OK": function() {
          $( this ).dialog( "close" );
        },
        "Cancel": function() {
          $( this ).dialog( "close" );
        }
      }
    });
    
    $('.uninstall').click(function() {
    	var result = $( "#dialog-confirm" ).dialog( "open" );
    	if(result == "OK") {
    		alert("OK");
    	} else {
    		alert("NOT OK");
    	}
    	return false;
    });
  });
  </script>
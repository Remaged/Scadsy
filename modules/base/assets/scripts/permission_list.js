$(function() {
	$( "#accordion" ).accordion({ collapsible: true, active: false, heightStyle: "content", header: "h2" });
	$( ".sub_accordion" ).accordion({ 
		collapsible: false, 
		heightStyle: "content",
		header: "h3", 
		icons: { "header": false, "activeHeader": false },
		animate: false
	});

	// Change the submit for each form
	$("#accordion form").each(function() {
		$(this).submit(function() {			
			var group = $(this).find("[name='group']").val();
			var action = $(this).find("[name='action']").val();	
			var controller = $(this).find("[name='controller']").val();	
			var module = $(this).find("[name='module']").val();	
			var checkbox = $(this).find("[name='allowed']");	
			$.ajax({
	           type: "POST",
	           url: $(this).attr('action'),
	           data: $(this).serialize(), 
	           success: function(data)
	           {
	           	if(data){
	           		showNotification('saving_permission', 'Saving '+group+'-permission for /'+module+'/'+controller+'/'+action+' failed: '+ data);
	           		checkbox.prop("checked", !checkbox.prop("checked"));
	           	}
	           	else{
	           		showNotification('saving_permission', 'Saving '+group+'-permission for /'+module+'/'+controller+'/'+action+' successful.');
	           	}
	           }
	        });
		    return false; 
	    });
	});
	
	$('[name="allowed"]').change(function(){
		var group = $(this).closest('form').find("[name='group']").val();
		var action = $(this).closest('form').find("[name='action']").val();
		var controller = $(this).closest('form').find("[name='controller']").val();
		var module = $(this).closest('form').find("[name='module']").val();
		if($(this).is(":checked")){						
			$("[data-group='"+group+"'][data-action='"+action+"'][data-controller='"+controller+"'][data-module='"+module+"']")
				.find("[name='allowed']").prop('checked','checked');
		}
		else if($(this).closest("[data-group]").closest("tr").prev().find("[name='allowed']").is(":checked")){
			showNotification('saving_permission', 'Saving '+group+'-permission for /'+module+'/'+controller+'/'+action+' failed: Cannot deny when parent-group is allowed.');
			$(this).prop('checked','checked');
			return;
		}
		$(this).closest('form').submit();
	});
});
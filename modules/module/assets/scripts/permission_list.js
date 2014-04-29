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
	           	alert(data);
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
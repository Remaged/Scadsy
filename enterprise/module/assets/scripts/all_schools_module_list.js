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
$(function(){
	$(".switchbutton input").not("[data-status='not_installed']").switchButton({
		on_label: 'ENABLED',
		off_label: 'DISABLED',
		on_callback: function() {
			save_module_status(this,'enable');
		},
		off_callback: function() {  
			save_module_status(this,'disable');	
		}	
	});
	
	$(".switchbutton input[data-status='not_installed']").hide();
	
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
			location.reload();
		}
	);
}

function callback_install_fail(){
	alert('Something went wrong. The installation did likely not succeed.');
}

function callback_deinstall_fail(){
	alert('Something went wrong. The de-installation did likely not succeed.');
}
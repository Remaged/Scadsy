$(function(){
	show_hide_fields();
	$("select[name='group']").change(show_hide_fields);
});

function show_hide_fields(){
	$("#fields_student_information").hide();
	$("#fields_enrollment_information").hide();
	var group = $("select[name='group']").val();
	if(group == 'student'){
		$("#fields_student_information,#fields_enrollment_information").show();
	}
	else if(group == 'teacher'){
		$("#fields_enrollment_information").show();
	}
}
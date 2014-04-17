$(function(){
	show_hide_fields();
	$("select[name='group_id']").change(show_hide_fields);
});

function show_hide_fields(){
	$("#fields_student_information").hide();
	$("#fields_enrollment_information").hide();
	var group_id = $("select[name='group_id']").val();
	var group = $("select[name='group_id'] option[value='"+group_id+"']").text();
	if(group == 'student'){
		$("#fields_student_information,#fields_enrollment_information").show();
	}
	else if(group == 'teacher'){
		$("#fields_enrollment_information").show();
	}
}
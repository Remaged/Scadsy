$(function(){
	$( "#accordion" ).accordion({ collapsible: true, heightStyle: "content", header: "h2" });
	
	$(":required").after("*");
	show_hide_fields();

	$("#user_group_options input[type='checkbox']:checked").each(function(){
		$(this).parents('ul').prev('li').find('input').prop('checked','checked');
	});
	
	$("#user_group_options input[type='checkbox']").click(function(){
		if($(this).is(":checked")){
			$(this).parents('ul').prev('li').find('input').prop('checked',true);
		}
		else{
			$(this).closest('li').next('ul').find('input').prop('checked',false);
		}
		
		show_hide_fields();
	});
	
	$(".form_search_user [name='page_size']").change(function(){
		$(this).closest("form").submit();
	})
	
	$(".form_search_user").submit(function(){
		var url = $(this).prop('action')+'/1';
		url += '/'+$(this).find("[name='page_size']").val();		
		url += '/'+$(this).find("[name='search_group']").val();
		url += '/'+$(this).find("[name='search_name']").val();
		window.location = url;
		return false;
	});
	
	$(".form_search_user input[name='search_name']").change(function(){
		$(".form_search_user input[name='search_name']").val($(this).val());
	});
	$(".form_search_user [name='search_group']").change(function(){
		$(".form_search_user [name='search_group']").val($(this).val());
	});
	
	$(".add_child_to_parent").click(function(){
		$(this).before("<div><input type='text' name='children[]' /><input type='button' value='remove' class='button remove_child_to_parent'></div>");
	})
	$("#fields_children_information").on('click','.remove_child_to_parent',function(){
		$(this).parent().remove();
	})
	
});

function show_hide_fields(){
	$("#fields_student_information,#fields_children_information,#fields_enrollment_information").hide();
	$("#fields_student_information,#fields_enrollment_information").find("[required]").prop("required",false);
	
	if($("input[name='groups[]'][value='student']:checked").length){
		$("#fields_student_information,#fields_enrollment_information").find("[required]").prop("required",true);
		$("#fields_student_information,#fields_enrollment_information").show();
	}
	if($("input[name='groups[]'][value='parent']:checked").length){
		$("#fields_children_information").show();
	}
}




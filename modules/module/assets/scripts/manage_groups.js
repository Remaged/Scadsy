$(function(){
	var forms = $(".manage_group_form");
	
	function manage_group_form_default_hide(){
		forms.children("[name='save'],[name='cancel']").hide();
		$(".new_subgroup_list_holder").hide();
	};
	manage_group_form_default_hide();
	
	forms.children("[name='add']").click(function(){
		forms.children(":not([type='text'])").hide();
		$(this).closest('li').children(".new_subgroup_list_holder").show();
	});
	forms.children("[name='edit']").click(function(){
		forms.children(":not([type='text'])").hide();
		$(this).closest('form').children("[name='save'],[name='cancel']").show();
		$(this).closest('form').children("[name='name']").prop('disabled',false);
	});
	forms.children("[name='delete']").click(function(){
		if(confirm('Are you sure you want to delete this group?')){
			$(this).parent().find("[name='delete']").val('1');
			$(this).parent().submit();
		}
	});
	
	$("[type='reset']").click(function(){
		forms.children().show();
		forms.children("[name='name']").prop('disabled',true);
		manage_group_form_default_hide();
	});
	
	

});



/*
$(function(){
	$(".sc-form").on('click','.add_group',function(){
		var groupname = $(this).closest('li').children('input').val();
		$(this).closest('li').children('ul').append(
			"<li><input type='text' name='groups["+groupname+"][]' /> <input type='button' class='add_group button' value='+' disabled/> <input type='button' class='delete_group button' value='-'/><ul></ul></li>"
		);
	}).on('click','.delete_group',function(){
		$(this).closest('li').remove();
	}).on('change','input',function(){
		$(this).closest('li').children('ul').children('li').children('input').prop('name','groups['+$(this).val()+'][]');
	}).on('keyup','input',function(){
		if($(this).val()){
			$(this).closest('li').children('.add_group').prop('disabled',false);
		}
		else{
			$(this).closest('li').children('.add_group').prop('disabled',true);
		}
	});
})
*/
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
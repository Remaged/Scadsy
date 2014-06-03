$(function(){
	
	
	$(".form_search_sms").submit(function(){	
		var url = $(this).prop('action')+'/1';
		url += '/'+$(this).find("[name='page_size']").val();
		url += '/'+$(this).find("[name='search_name']").val();
		window.location = encodeURI(url);
		return false;
	});
	
	
	$(".select_container").on('click',"[type='checkbox']",function(e){
		shift_select_checkboxes(this, e, $(this).data('selecttype'));
	});
	
	var last_checked = { students: null, parents: null, student_groups: null, parent_groups: null};
	function shift_select_checkboxes(checkbox_obj, e, type){
		$(checkbox_obj).closest("#search_users_container").find("[type='checkbox'][value='"+checkbox_obj.value+"']").prop('checked',checkbox_obj.checked);
				
    	var $chkboxes = $("[data-selecttype='"+type+"']");
    	if(e.shiftKey && last_checked[type] != null) {
            var start = $chkboxes.index(checkbox_obj);
            var end = $chkboxes.index(last_checked[type]);
            $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', last_checked[type].checked);
        } 
        last_checked[type] = checkbox_obj;
        set_selected(type);
	}
	
	function set_selected(type){
		if(type == 'students' || type == 'parents'){
			set_selected_users();
		}
		else{
			set_selected_groups();
		}
	}
	
	function add_to_selection(selection_holder_type, element){
		if(! $(".selected_"+selection_holder_type+" [value='"+element.value+"']").length){
			$(".selected_"+selection_holder_type+" .button").before(
				'<div><input type="hidden" name="selected['+selection_holder_type+'][]" value="'+element.value+'" />'+
				$(element).parent().children('[name=name]').val()+
				'<span class="remove_from_selected">x</span></div> '
			);
		}
	}
	function remove_from_selection(selection_holder_type, element){
		$(".selected_"+selection_holder_type+" [value='"+element.value+"']").parent().remove();
	}
	
	function set_selected_users(){
    	$("#search_users_container [type='checkbox']:checked").each(function(){
    		add_to_selection('users',this);
    		
    	});
    	$("#search_users_container [type='checkbox']:not(:checked)").each(function(){
    		$(".selected_users [value='"+this.value+"']").parent().remove();
    	});
    }
    function set_selected_groups(){
    	$("#select_groups_container [type='checkbox']").each(function(){
    		var parent_group_name = $(this).parent().children("[name='parent_group']").val();
    		var parent_is_checked = $("#select_groups_container [type='checkbox'][value='"+parent_group_name+"']").is(":checked");
    		if(parent_is_checked){
    			$(this).prop("checked",true).prop("disabled",true);
    		}
    		else{
    			$(this).prop("disabled",false);
    		}
    		if( $(this).prop('checked') === true && $(this).prop('disabled') === false){
    			add_to_selection('groups',this);
    		}
  			else{
    			remove_from_selection('groups',this);
    		}
    	});
    }

    function set_selected_checkboxes(){
    	$(".selected_users input").each(function(){
    		$("#search_users_container [value='"+this.value+"']").prop('checked',true);
    	});
    }

    $(".selected_users").on('click','.remove_from_selected',function(){
    	var username = $(this).parent().find('input').val();
    	$("#search_users_container [value='"+username+"']").prop('checked',false);
    	$(this).parent().remove();
    });
    $(".selected_groups").on('click','.remove_from_selected',function(){
    	var name = $(this).parent().find('input').val();
    	$("#select_groups_container [type='checkbox'][value='"+name+"']").prop('checked',false);
    	$(this).parent().remove();
    	set_selected_groups();
    });
    
    $(".search_button").click(function(){   	
    	search_users();
    });
    
    $("#search_users_container").on("change","[name='search_group']",function(){
    	$(".sms_search_users_pagination [name='page']").val('1');
    	search_users();
    });
    
    $("#search_users_container").on("change",".sms_search_users_pagination [name='page_size']",function(){
    	$(".sms_search_users_pagination [name='page']").val('1');
    	search_users();
    });
    
    $("#search_users_container").on("change",".sms_search_users_pagination [name='page']",function(){
    	search_users();
    });
    
    $("#search_users_container").on("change",".sms_search_users_pagination [name]",function(){
    	$(".sms_search_users_pagination [name='"+$(this).prop('name')+"']").val(this.value);
    });
    
    
    function search_users(){
    	var url = 'search';
    	url += '/'+$(".sms_search_users_pagination [name='page']").val();
    	url += '/'+$(".sms_search_users_pagination [name='page_size']").val();
		url += '/'+$("#search_users_container [name='search_group']").val();
		url += '/'+$("#search_users_container [name='search']").val();
		$("#search_users_container").html("<p>Searching...</p>");
		$("#search_users_container").load(encodeURI(url),function(){
			set_selected_checkboxes();
		});
    }
    
    $("#add_people_button").click(function(){
    	$("#search_users_container").slideDown();
    	$("#add_people_button,#add_groups_button").hide();
    });
    
    $("#add_groups_button").click(function(){
    	$("#select_groups_container").slideDown();
    	$("#add_people_button,#add_groups_button").hide();
    });
    
    $("#search_users_container,#select_groups_container").on('click',".close_button", function(){
    	$("#search_users_container,#select_groups_container").slideUp();
    	$("#add_people_button,#add_groups_button").show();
    });
    
    
    $("#sms_form textarea").keyup(function(){
    	var chars = this.value.length;
    	var messages = Math.ceil(chars / 140);
    	$("#sms_amount").text(messages);
    	$("#sms_characters_left").text(140 - chars % 140);
    	if(messages != 0 && chars % 140 == 0){
    		$("#sms_characters_left").text(0);
    	}
    });
});
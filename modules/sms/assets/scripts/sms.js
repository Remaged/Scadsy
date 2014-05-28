$(function(){
	var lastChecked = null;
	
	$(".form_search_sms").submit(function(){
		var url = $(this).prop('action')+'/1';
		url += '/'+$(this).find("[name='page_size']").val();
		url += '/'+$(this).find("[name='search_name']").val();
		window.location = encodeURI(url);
		return false;
	});
	
    $("#search_users_container").on('click',"[type='checkbox']",function(e){
    	var $chkboxes = $("#search_users_container [type='checkbox']");
    	if(e.shiftKey && lastChecked != null) {
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(lastChecked);
            $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', lastChecked.checked);
        } 
        lastChecked = this;
        set_selected_users();   
    });
        
    function set_selected_users(){
    	$("#search_users_container [type='checkbox']:checked").each(function(){
    		if( ! $(".selected_users [value='"+this.value+"']").length){
    			$(".selected_users #add_button").before(
    				'<div><input type="hidden" name="selected[]" value="'+this.value+'" />'+
    				this.value+
    				' ('+
    				$(this).parent().children('[name=name]').val()+
    				')'+
					'<span class="remove_from_selected">x</span></div> '
				);
    		}
    	});
    	$("#search_users_container [type='checkbox']:not(:checked)").each(function(){
    		$(".selected_users [value='"+this.value+"']").parent().remove();
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
    
    $("#search_button").click(function(){
    	$("#search_users_container").html("<p>Searching...</p>");
    	$.post('search',{
    		search:  $(this).parent().find("[name='search']").val(),
    		csrf_token : $(this).closest('form').find("[name='csrf_token']").val()
    	},function(data){
    		$("#search_users_container").html(data);
    		set_selected_checkboxes();
    	});
    });
    
    $("#add_button").click(function(){
    	$("#search_and_select_users").slideDown();
    	$(this).hide();
    });
     $("#close_button").click(function(){
    	$("#search_and_select_users").slideUp();
    	$("#add_button").show();
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
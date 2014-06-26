$(function(){
	
	
	
    $("#student_list_container")
	    .on("change",".search_students_pagination [name='search_group']",function(){
	    	$(".search_students_pagination [name='page']").val('1');
	    	search_users();
	    }).on("change",".search_students_pagination [name='page_size']",function(){
	    	$(".search_users_pagination [name='page']").val('1');
	    	search_users();
	    }).on("change",".search_students_pagination [name='page']",function(){
	    	search_users();
	    }).on("change",".search_students_pagination [name]",function(){
	    	$(".search_students_pagination [name='"+$(this).prop('name')+"']").val(this.value);
	    }).on("click",".search_students_pagination .search_button",function(){
	    	search_users();
	    }).on("click","[data-username]",function(){
	    	window.location = 'edit/'+$(this).data('username');
	    });;
		
		
		
    
	function search_users(){
    	var url = 'search';
    	url += '/'+$(".search_students_pagination [name='page']").val();
    	url += '/'+$(".search_students_pagination [name='page_size']").val();
		url += '/'+$(".search_students_pagination [name='search_group']").val();
		url += '/'+$(".search_students_pagination [name='search']").val();
		$("#student_list_container").html("<p>Searching...</p>");
		$("#student_list_container").load(encodeURI(url),function(){
			//set_selected_checkboxes();
		});
    }
	
	
	
	$( ".accordion" ).accordion({ collapsible: true, heightStyle: "content", header: "h2" });
	
	
	$("#student_information #personal_information [name='last_name']").change(function(){
		var last_name = this.value;
		$("#parent_information [name='last_name']").each(function(){
			if(!this.value){
				this.value = last_name;
			}
		});
	});
	
	$("#student_information [value='Add parent/guardian'],#student_information [value='Add enrollment']").click(function(){
		var parent_info_row = $(this).closest("tr").prev().clone();
		$(parent_info_row).find("input,select").not("[type='button']").val('');
		$(parent_info_row).show();
		$(parent_info_row).find('[name="enrollment[disabled][]"],[name="guardian[disabled][]"]').remove();
		$(this).closest("tr").before(parent_info_row);
	});
	
	$("#student_information").on("click","[value='Remove']",function(){
		$(this).closest('tr').remove();;
	});
	
})
	
<h1>Manage groups</h1>

<p>
	Here, you can setup which groups there are for this school. 
</p>

<p>
	It may take some time to save groups, because groups have a powerful effect on users and permissions.
</p>

<?php echo form_open(null, array("class" => "sc-form", "id" => "manage_groups_from")); ?>
	<ul>
		<li>
			Everyone
			<input type="hidden" name="the_everyone_group" value='everyone'>
			<a href='#' class='button add_group'>+</a>
			<ul>
				<?php
				function show_group_options($groups, $parent_group = 'everyone'){
					if($groups->exists() === FALSE){
						return;
					}
					foreach($groups AS $group){
						$CI =& get_instance();
						$checked = ($CI->input->post('groups') && in_array($group->name, $CI->input->post('groups'))) ? TRUE : FALSE;
						echo "<li>"
								.form_input('groups['.$parent_group.']['.$group->name.']',$group->name)
								."
								<a href='#' class='button add_group'>+</a>
								<a href='#' class='button delete_group'>-</a>					
								<ul>";
								show_group_options($group->child_group, $group->name);
						echo 	"</ul>
							</li>";
					}
				}
				show_group_options($groups);
				?>
			</ul>
		</li>
	</ul>
	<?php echo form_submit('save','Save'); ?>
	<a href="" class="button">Cancel</a>
<?php echo form_close(); ?>


<?php /*

<script>
	$(function(){
		$(".sc-form ul ul").sortable({
			connectWith: ".sc-form ul",
			placeholder: ".ui-state-highlight",
	      	cancel: ".not_sortable",
	      	helper: "clone"
	    }).disableSelection();
	    
	    $("input[readonly]").click(function(){
	    	$(this).prop("readonly",false);
	    	$(this).closest("li").addClass("not_sortable");
	    	this.focus();
	    }).blur(function(){
	    	$(this).prop("readonly",true);
	    	$(this).closest("li").removeClass("not_sortable");
	    }).keyup(function(e){
	    	alert(e);
	    });
	    
	    $(".add_group").click(function(){
	    	$(this).prev('ul').append("<li><input type='text' name='group' /><a href='#' class='delete_group'>Delete this group</a></li>");
	    })
	    
	    $(".sc-form").on('click','.delete_group',function(){
	    	$(this).closest('li').remove();
	    });
	})
</script>

<style>
	.sc-form ul{			
		margin: 2px;
		padding: 10px;
	}
	.sc-form ul li, .ui-state-highlight{
		border: 1px solid black;
		padding: 5px;
		margin: 10px 0px;
		background: rgba(50,50,50,0.1);
		cursor: move;
		line-height: 1em;
		box-shadow: inset 1px 1px 1px 0px white;
		border-radius: 5px;
	}
	.sc-form ul li:not(.not_sortable):hover{
		border: 1px solid white;
	}
	.sc-form ul li input[readonly]{
		background: none;
		padding: 0px;
		border: 0px;
	}
</style>


<?php echo form_open(site_action_uri('save'), array("class" => "sc-form")); ?>
	<ul>
		<li>Everyone
			<ul>
				<?php
				function show_group_options($groups){
					if($groups->exists() === FALSE){
						return;
					}
					foreach($groups AS $group){
						$CI =& get_instance();
						$checked = ($CI->input->post('groups') && in_array($group->name, $CI->input->post('groups'))) ? TRUE : FALSE;
						echo "<li>".form_input('group[]',$group->name,'readonly')."<ul>";
						show_group_options($group->child_group);
						echo "</ul><a href='#' class='add_group'>Add group</a></li>";
					}
				}
				show_group_options($groups);
				?>
				<li>
					<?php echo form_input(array('name'=>'group[]','placeholder'=>'add new group')); ?>
				</li>
			</ul>
		</li>
	</ul>
<?php echo form_close(); ?>

 */ ?> 
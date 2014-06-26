<div class="search_students_pagination sc-form">	
	<div class="pagination_options" style="float:right;">
		<?php $pages = array(); for($i=1; $i <= $users->paged->total_pages; $i++){ $pages[$i] = $i; } ?>
		Page <?php echo form_dropdown('page',$pages,$users->paged->current_page); ?> of <?php echo $users->paged->total_pages; ?>
		<?php echo form_dropdown('page_size',array(10=>'10 per page', 20=>'20 per page', 50=>'50 per page', 100=>'100 per page'),$users->paged->page_size); ?>
	</div>	
	
	<?php echo form_search('search',urldecode($search_name)); ?>
	<?php echo form_dropdown('search_group',$group_dropdown_options,$group_selected_option); ?>
	
	<?php echo form_input(array('type'=>'button','value'=>'Search','class'=>'button search_button')); ?>	

	
</div>
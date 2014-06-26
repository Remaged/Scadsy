<?php echo form_open(site_action_uri("userlist"), array("class" => "sc-form form_search_user pagination")); ?>
	
	
	
	<div class="search_options">
		<?php echo form_search('search_name', $search_name,'placeholder="Search users"'); ?>
		<?php echo form_dropdown('search_group',$dropdown_options, $search_group); ?>
		<?php echo form_submit('search','Search'); ?>
	</div>
	
	<?php if($users->paged->has_previous): ?>
		<a href="<?php echo site_url(site_action_uri('userlist/1/'.$page_size.'/'.$search_group.'/'.$search_name)); ?>" class="button">&lt;&lt;</a>&nbsp;
		<a href="<?php echo site_url(site_action_uri('userlist/'.$users->paged->previous_page.'/'.$page_size.'/'.$search_group.'/'.$search_name)); ?>" class="button">&lt;</a>
	<?php endif; ?>
	&nbsp;&nbsp;
	Page <?php echo $users->paged->current_page; ?> of <?php echo $users->paged->total_pages; ?>
	&nbsp;&nbsp;
	<?php  if($users->paged->has_next): ?>
		<a href="<?php echo site_url(site_action_uri('userlist/'.$users->paged->next_page.'/'.$page_size.'/'.$search_group.'/'.$search_name)); ?>" class="button">&gt;</a>&nbsp;
		<a href="<?php echo site_url(site_action_uri('userlist/'.$users->paged->total_pages.'/'.$page_size.'/'.$search_group.'/'.$search_name)); ?>" class="button">&gt;&gt;</a>		
	<?php endif; ?>
	
	<?php echo form_dropdown('page_size',array(10=>'10 per page', 20=>'20 per page', 50=>'50 per page', 100=>'100 per page'),$page_size); ?>
	
	
<?php echo form_close(); ?>
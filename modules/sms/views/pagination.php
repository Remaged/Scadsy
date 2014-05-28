<?php echo form_open(site_action_uri("index"), array("class" => "sc-form form_search_sms pagination")); ?>

	<div class="search_options">
		<?php echo form_search('search_name', $search_name,'placeholder="Search message"'); ?>
		<?php echo form_submit('search','Search'); ?>
	</div>
	
	<?php if($smses->paged->has_previous): ?>
		<a href="<?php echo site_url(site_action_uri('sms_list/1/'.$page_size.'/'.$search_name)); ?>" class="button">&lt;&lt;</a>&nbsp;
		<a href="<?php echo site_url(site_action_uri('sms_list/'.$smses->paged->previous_page.'/'.$page_size.'/'.$search_name)); ?>" class="button">&lt;</a>
	<?php endif; ?>
	&nbsp;&nbsp;
	Page <?php echo $smses->paged->current_page; ?> of <?php echo $smses->paged->total_pages; ?>
	&nbsp;&nbsp;
	<?php  if($smses->paged->has_next): ?>
		<a href="<?php echo site_url(site_action_uri('sms_list/'.$smses->paged->next_page.'/'.$page_size.'/'.$search_name)); ?>" class="button">&gt;</a>&nbsp;
		<a href="<?php echo site_url(site_action_uri('sms_list/'.$smses->paged->total_pages.'/'.$page_size.'/'.$search_name)); ?>" class="button">&gt;&gt;</a>		
	<?php endif; ?>
	
	<?php echo form_dropdown('page_size',array(10=>'10 per page', 20=>'20 per page', 50=>'50 per page', 100=>'100 per page'),$page_size); ?>
	
<?php echo form_close(); ?>
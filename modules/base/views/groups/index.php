<h1>Manage groups</h1>

<p>
	Below, you can add, remove and rename groups for this school. Please note that all group names must be unique. 
</p>

<ul id="manage_groups_list">
	<li>
		<?php echo form_open(null,array("class" => "sc-form manage_group_form")); ?>
			<?php echo form_input('name','everyone', 'disabled'); ?>			
			<?php echo form_button(array('name'=>'add','class'=>'button'),'Add subgroup'); ?>
		<?php echo form_close(); ?>
		<?php
			$parent_group = 'everyone';
			create_group_options($groups, $parent_group);
			create_add_group_option($parent_group);
		?>
	</li>
</ul>

<?php function create_group_options($groups, $parent_group){ ?>
	<ul>
		<?php foreach($groups AS $group): ?>
			<li>
				<?php echo form_open(null, array("class" => "sc-form manage_group_form"), array('parent_group'=>$parent_group,'old_name'=>$group->name,'delete'=>0)); ?>
					<?php echo form_input('name',$group->name, 'disabled'); ?>
					<?php echo form_button(array('name'=>'edit','class'=>'button'),'Edit'); ?>
					<?php echo form_button(array('name'=>'delete','class'=>'button'),'Delete'); ?>
					<?php echo form_button(array('name'=>'add','class'=>'button'),'Add subgroup'); ?>
					<?php echo form_submit(array('name'=>'save','value'=>'Save','class'=>'button')); ?>
					<?php echo form_reset(array('name'=>'cancel','value'=>'Cancel','class'=>'button')); ?>
				<?php echo form_close(); ?>
				<?php 
					$child_groups = $group->child_group->get();
					if($child_groups->exists()){
						create_group_options($child_groups,$group->name); 
					} 
				?>
				<?php create_add_group_option($group->name); ?>
			</li>
			
		<?php endforeach; ?>
	</ul>
<?php } ?>

<?php function create_add_group_option($parent_group){ ?>
	<ul class="new_subgroup_list_holder">
		<li>
			<?php echo form_open(null, array("class" => "sc-form add_group_form"), array('parent_group'=>$parent_group)); ?>
			<?php echo form_input(array('name'=>'name','placeholder'=>'New subgroup')); ?>
			<?php echo form_submit(array('name'=>'save','value'=>'Save','class'=>'button')); ?>
			<?php echo form_reset(array('name'=>'cancel','value'=>'Cancel','class'=>'button')); ?>
			<?php echo form_close(); ?>
		</li>
	</ul>
<?php } ?>
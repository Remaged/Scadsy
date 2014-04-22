<?php echo $errors; ?>

	<h1>
		Add new user
	</h1>

<?php echo form_open(uri_string(), array("class" => "sc-form")); ?>

	<?php echo form_fieldset('Acces information'); ?>
		<?php echo form_label_input('username'); ?>
		<?php echo form_label_password('password'); ?>
		<?php echo form_label_password('password_confirm'); ?>
		<?php 
			$group_options = array(); 
			foreach($groups AS $group){
				$group_options[$group->id] = $group->name;
			}
			echo form_label_dropdown('group_id',$group_options,'User group'); 
		?>
	<?php echo form_fieldset_close(); ?>
	
	<?php echo form_fieldset('Student information',array('id'=>'fields_student_information')); ?>
		<?php echo form_label_input('alternate_id','Alternate ID'); ?>
		<?php 
			$grade_options = array(); 
			foreach($grades AS $grade){
				$grade_options[$grade->id] = $grade->name;
			}
			echo form_label_dropdown('grade_id',$grade_options,'Grade'); 
		?>
	<?php echo form_fieldset_close(); ?>
	
	<?php echo form_fieldset('Enrollment information',array('id'=>'fields_enrollment_information')); ?>
		<?php echo form_label_date('start_date'); ?>	
		<?php echo form_label_date('end_date'); ?>	
	<?php echo form_fieldset_close(); ?>
	
	<?php echo form_fieldset('Personal information'); ?>
		<?php echo form_label_input('first_name'); ?>	
		<?php echo form_label_input('middle_name'); ?>	
		<?php echo form_label_input('last_name'); ?>			
		<?php echo form_label_date('date_of_birth'); ?>	
		<?php 
			$gender_options = array('male'=>'Male','female'=>'Female'); 
			echo form_label_dropdown('gender',$gender_options); 
		?>
		<?php 
			$language_options = array(); 
			foreach($languages AS $language){
				$language_options[$language->id] = $language->name;
			}
			echo form_label_dropdown('language_id',$language_options, 'Primary Language'); 
		?>		
		<?php 
			$ethnicity_options = array(); 
			foreach($ethnicities AS $ethnicity){
				$ethnicity_options[$ethnicity->id] = $ethnicity->name;
			}
			echo form_label_dropdown('ethnicity_id',$ethnicity_options,'Ethnicity'); 
		?>
	<?php echo form_fieldset_close(); ?>
	
	<?php echo form_fieldset('Contact information'); ?>
		<?php echo form_label_email('email'); ?>
		<?php echo form_label_input('phone_number'); ?>
	<?php echo form_fieldset_close(); ?>
	
	<div>
		<?php echo form_submit('submit','Submit'); ?>
	</div>

<?php form_close(); ?>

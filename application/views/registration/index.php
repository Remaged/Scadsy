
<?php echo validation_errors(); ?>

<?php echo form_open('register'); ?>
	
	
	<fieldset>
		<legend>Acces information</legend>
		<div>
			<label>Username</label>
			<input type="text" name="username" value="<?php echo set_value('username', ''); ?>" size="50" />
		</div>
		<div>
			<label>Password</label>
			<input type="password" name="password" value="" size="50" />
		</div>
		<div>
			<label>Password Confirm</label>
			<input type="password" name="password_confirm" value="" size="50" />
		</div>
		<div>
		<label>Group</label>
			<select name="group">
				<?php foreach($groups AS $group): ?>
					<option value="<?php echo $group->name ?>" <?php echo set_select('group', $group->name); ?>><?php echo $group->name ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Student information (als group = student)</legend>
		<div>
			<label>Student ID</label>
			<input type="text" name="student_id" value="<?php echo set_value('student_id', ''); ?>" size="50" />
		</div>
		<div>
			<label>Alternate ID</label>
			<input type="text" name="alternate_id" value="<?php echo set_value('alternate_id', ''); ?>" size="50" />
		</div>
		
		<div>
			<label>Grade</label>
			<select name="grade">
				<?php foreach($grades AS $grade): ?>
					<option value="<?php echo $grade->name ?>" <?php echo set_select('grade', $grade->name); ?>><?php echo $grade->name ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Enrollment information</legend>
		<div>
			<label>Start date</label>
			<input type="date" name="start_date" value="<?php echo set_value('start_date', ''); ?>" size="50" />
		</div>
		<div>
			<label>End date</label>
			<input type="date" name="end_date" value="<?php echo set_value('end_date', ''); ?>" size="50" />
		</div>
	</fieldset>

	<fieldset>
		<legend>Personal information</legend>
		<div>
			<label>First name</label>
			<input type="text" name="first_name" value="<?php echo set_value('first_name', ''); ?>" size="50" />
		</div>
		<div>
			<label>Middle name</label>
			<input type="text" name="middle_name" value="<?php echo set_value('middle_name', ''); ?>" size="50" />
		</div>
		<div>
			<label>Last name</label>
			<input type="text" name="last_name" value="<?php echo set_value('last_name', ''); ?>" size="50" />
		</div>
		<div>
			<label>Date of birth</label>
			<input type="date" name="date_of_birth" value="<?php echo set_value('date_of_birth', ''); ?>" size="50" />
		</div>
		<div>
			<label>Gender</label>
			<select name="gender">
				<option value="male" <?php echo set_select('gender', 'male'); ?>>Male</option>
				<option value="female" <?php echo set_select('gender', 'female'); ?>>Female</option>
			</select>
		</div>
		<div>
			<label>Primary Language</label>
			<select name="language">
				<?php foreach($languages AS $language): ?>
					<option value="<?= $language->name ?>" <?php echo set_select('language', $language->name); ?>><?= $language->name ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div>
			<label>Ethnicity</label>
			<select name="ethnicity">
				<?php foreach($ethnicities AS $ethnicity): ?>
					<option value="<?= $ethnicity->name ?>" <?php echo set_select('ethnicity', $ethnicity->name); ?>><?= $ethnicity->name ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Contact information</legend>	
		
		<div>
			<label>Email</label>
			<input type="email" name="email" value="<?php echo set_value('email', ''); ?>" size="50" />
		</div>
		<div>
			<label>Phone number</label>
			<input type="text" name="phone_number" value="<?php echo set_value('phone_number', ''); ?>" size="50" />
		</div>
	</fieldset>
	
	
	<div>
		<input type="submit" value="Submit" />
	</div>
</form>


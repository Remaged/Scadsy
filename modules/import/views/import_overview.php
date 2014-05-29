<h1>Import - Overview</h1>

<p>You are about to import the following data, is this correct?</p>

<table class="sc-table">
	<thead>
		<tr>
			<th>First name</th>
			<th>Last name</th>
			<th>Date of birth</th>
			<th>Sex</th>
			<th>Grade</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>First name</th>
			<th>Last name</th>
			<th>Date of birth</th>
			<th>Sex</th>
			<th>Grade</th>
		</tr>
	</tfoot>
	<tbody>
		<?php foreach($students as $student) { ?>
			<tr>
				<td><?php echo $student->first_name; ?></td>
				<td><?php echo $student->last_name; ?></td>
				<td><?php echo date("d-m-Y", $student->date_of_birth); ?></td>
				<td><?php echo $student->sex; ?></td>
				<td><?php echo $student->grade; ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php echo form_open('import/importer/import_final',array('class'=>'sc-form','id'=>'import_form_final')); ?>
<?php echo form_hidden('data', serialize(array("main" => $main, "sub" => $sub, "students" => $students))); ?>
<?php echo form_submit('import','Import'); ?>
	
<?php echo form_close(); ?>
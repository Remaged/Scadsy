<div class="at-page">
	<?php if ($students->result_count() > 0) { ?>
	<?php echo form_open(site_action_uri('register_attendance/'.urlencode($group).'/'.$date),array('class'=>'sc-form attendance-today-form')); ?>
		<table class="sc-table">
			<thead>
				<tr>
					<th>First name</th>
					<th>Last name</th>
					<th>Attending</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>First name</th>
					<th>Last name</th>
					<th>Attending</th>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach($students as $student) { ?>
				<tr>
					<td><?php echo $student->first_name; ?></td>
					<td><?php echo $student->last_name; ?></td>
					<?php 
						$attendance = new Attendance();
						$attendance->get_where(array('user_id' => $student->id, 'date' => $date, 'attended' => TRUE));
						$result = $attendance->result_count() == 1 ? TRUE : FALSE;
					?>
					<td><?php echo form_checkbox($student->id, 'yes', $result); ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php echo form_submit('save', 'Save', "class='at-submit'"); ?>
	<?php echo form_close(); ?>
	<?php } else { ?>
		There are no students in this group.
	<?php } ?>
</div>
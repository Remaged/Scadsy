<h1>Attendance - Check <?php echo $title; ?></h1>

<p>Please choose your group below.</p>

<div class="sc-attendance">
<?php 
foreach($groups as $group) {
	$data['group'] = $group;
	$data['date'] = $date;
	$data['indent'] = -1;
	$this->load->view('overview_group', $data);
} ?>
</div>
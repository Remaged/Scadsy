<h1>Attendance - Overview</h1>

<p>Please select the date you would like to see the attendance for.</p>

<?php foreach($dates as $date) { ?>
	<?php echo anchor(site_action_uri("check/".$date->date), $date->date); ?><br/>
<?php } ?>

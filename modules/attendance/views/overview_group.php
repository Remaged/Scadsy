<?php if ($indent != -1) { ?>
<div class="row inactive" style="margin-left:<?php echo 15*$indent; ?>px;" data-url="<?php echo site_url('attendance/monitor/students/'.$group->name.'/'.$date); ?>">
	<div class="header">
		<?php echo $group->name; ?>
		<img src="<?php echo base_url('modules/attendance/assets/images/arrow_right.png'); ?>" class="arrow-right" />
	</div>
	<div class="content">
		
	</div>
</div>
<?php } ?>

<?php 
$child_groups = $group->child_group->get();
if($child_groups->exists()){
	$indent++;
	foreach($child_groups as $cgroup) {
		$data['group'] = $cgroup;
		$data['indent'] = $indent;
		$data['date'] = $date;
		$this->load->view('overview_group', $data);
	}
} 
?>
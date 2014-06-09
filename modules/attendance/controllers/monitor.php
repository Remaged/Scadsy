<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitor extends SCADSY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function check($date = NULL){
		$title = $date;
		if($date === NULL || $date === date('Y-m-d', time())) {
			$date = date('Y-m-d', time());
			$title = "Today";
		}
		
		$g = new Group();
		$g->where('name', 'student')->get();
		$g->get_child_groups();
		$data['date'] = $date;
		$data['title'] = $title;
		$data['groups'] = $g;
		
		$this->view('check', $data);
	}	
	
	public function students($group, $date) {
		$g = new Group();
		$g->where('name', urldecode($group))->get();
		$users = $g->user;
		$users->get();
		$data['students'] = $users;
		$data['date'] = $date;
		$data['group']= $group;
				
		$this->load->view('student_form', $data);
	}
	
	public function register_attendance($group, $date) {
		if($this->input->post()) {
			foreach($this->input->post(NULL, TRUE) as $name => $value) {
				$attendance = new Attendance();
				$attendance->get_where(array('user_id' => $name, 'date' => $date));
				if($attendance->result_count() == 0) {
					$attendance->user_id = $name;
					$attendance->date = $date;
					$attendance->attended = ($value === 'yes') ? TRUE : FALSE;
					$attendance->save();
				} else {
					$attendance->where(array('user_id' => $name, 'date' => $date))->update('attended', ($value === 'yes') ? TRUE : FALSE);
				}			
			}
		}
	}
	
	public function overview() {
		$attendance = new Attendance();
		$attendance->group_by("date")->order_by("date", "DESC")->get();
		$data['dates'] = $attendance;
		
		$this->view('overview', $data);
	}
	
	public function widget() {
		$attendance = new Attendance();
		$attendance->get_where(array('date' => date('Y-m-d', time()), 'attended' => FALSE));
		$data['attendances'] = $attendance;
		
		$this->load->view("widget", $data);
	}
}


/* End of file monitor.php */
/* Location: ./modules/attendance/controllers/monitor.php */
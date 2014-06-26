<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_students extends SCADSY_Controller{
	var $data = array();
	public function __construct() {
		parent::__construct();
		parent::init();
		$this->load->model('manage_students_model');
	}
	
	/**
	 * Default page will use the userlist
	 */
	public function index($page = 1, $page_size = 20, $search_group = NULL, $search_name = NULL){
		$this->search(1, 20, NULL, NULL, FALSE);
		$this->view('student_list',$this->data);
	}
	
	/**
	 * search student (and their parents) and displays the results
	 */
	public function search($page = 1, $page_size = 20, $search_group = NULL, $search_name = NULL, $load_view = TRUE){
		$this->data['users'] = $this->manage_students_model->get_students($page, $page_size, $search_group, $search_name);	
		$this->data['group_dropdown_options'] = $this->manage_students_model->get_student_group_options(TRUE);
		$this->data['group_selected_option'] = $search_group;
		$this->data['search_name'] = $search_name;
		if($load_view){
			$this->view('search_users',$this->data);
		}						
	}
	
	public function add(){
		$this->student_form();
	}
	
	public function edit($username){
		if($this->session->flashdata('save_student_message')){
			$this->notification_manager->add_notification("message", $this->session->flashdata('save_student_message')); 
		}
		$this->student_form($username);
	}
	
	private function student_form($username = NULL){
		if($this->input->post('first_name')){
			if($redirect_to = $this->manage_students_model->save()){
				redirect(site_action_uri('edit/'.$redirect_to));
			}
			
		}
		
		$this->data['student_group_options'] = $this->manage_students_model->get_student_group_options();
		$this->data['user'] = new User($username);
		$this->view('student_info',$this->data);
	}
	
	
}


/* End of file manage_students.php */
/* Location: ./modules/module/controllers/manage_students.php */
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The module-admin controller, handles the login and logout requests.
 * NOTE: this module is part of the ENTERPRISE-version and cannot be disabled.
 */
class Module extends SCADSY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('module_all_schools_model');	
	}
	
	/**
	 * Default action, resulting in the overview of all modules of all schools.
	 */
	public function index() {

		parent::init(array(
			'module' => "login",
			'action' => "index",
			'group' => array('admin','student','teacher')
			)
		);
		$data['modules_per_school'] = $this->module_all_schools_model->get_schools_modules();
		$this->load->helper(array('form', 'url'));
		$this->view('module_manager/index',$data);
	}
	
	/**
	 * Enables a single module of a single school.
	 * (used for jquery-post)
	 */
	public function enable() {
		$this->module_all_schools_model->enable_module(
			$this->input->post('module'),
			$this->input->post('school_db')
		);	
	}
	
	/**
	 * Disables a single module of a single school.
	 * (used for jquery-post)
	 */
	public function disable() {
		$this->module_all_schools_model->disable_module(
			$this->input->post('module'),
			$this->input->post('school_db')
		);	
	}
	
	/**
	 * Stores all enable/disable data of all modules of all schools.
	 * (used when javascript is not enabled)
	 */
	public function save_modules(){
		$this->module_all_schools_model->save_all_module_settings($this->input->post('status'));
		redirect('module');
	}
		
}


/* End of file Module.php */
/* Location: ./modules/enterprise/controllers/Module.php */
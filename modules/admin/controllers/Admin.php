<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The module-admin controller, handles the login and logout requests.
 * NOTE: this module is part of the ENTERPRISE-version and cannot be disabled.
 */
class Admin extends SCADSY_Controller{

	public function __construct() {
		parent::__construct();
		//$this->module_manager->add_new_modules();
		$this->load->model('admin_model');
	}
	
	/**
	 * Default action. When user not logged in this results in a login form. Otherwise a succes page will be shown.
	 */
	public function index() {
		parent::init(array(
			'module' => "login",
			'action' => "index",
			'group' => array('admin','student','teacher')
			)
		);
		$data['modules_per_school'] = $this->admin_model->get_schools_modules();
		
		$this->admin_model->setup_form_validation();
		$this->view('index',$data);
	}
	
	public function enable() {
		$this->admin_model->enable_module();		
		redirect('admin/index');
	}
	
	public function disable() {
		$this->admin_model->disable_module();		
		redirect('admin/index');
	}
		
}


/* End of file Admin.php */
/* Location: ./modules/admin/controllers/Admin.php */
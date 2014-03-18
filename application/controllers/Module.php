<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends SCADSY_Controller{

	public function __construct() {
		parent::__construct();
		$this->module_manager->add_new_modules();
	}

	public function index() {
		parent::init(array(
			'module' => "module",
			'action' => "index",
			'group' => array('admin')
			)
		);
		
		$data['modules'] = $this->module_model->get_modules();
		
		$this->view('module/list', $data);
	}
	
	public function enable($directory) {
		$this->module_model->enable_module($directory);
		
		redirect('module/index');
	}
	
	public function disable($directory) {
		$this->module_model->disable_module($directory);
		
		redirect('module/index');
	}
	
	/**
	 * Stores all enable/disable data of all modules
	 */
	public function save_modules(){
		$this->module_model->save_module_statusses($this->input->post('status'));
		redirect('module');
	}
	
	/**
	 * Manage the permissions of the modules
	 */
	 public function permissions() {
	 	$this->load->helper('form');
		
	 	parent::init(array(
			'module' => "module",
			'action' => "permissions",
			'group' => array('admin')
			)
		);

		$data['modules'] = $this->module_model->get_modules_with_permissions('enabled');
		
		$this->view('module/permissions', $data);
	 }
	 
	 /**
	  * Handle the post from the permission page
	  */
	  public function permissionEdit() {
	  	if($this->input->server('REQUEST_METHOD') == "POST") {
			$module = $this->input->post('module');
			$controller = $this->input->post('controller');
			$action = $this->input->post('action');
			$group = $this->input->post('group');
			$allowed = ($this->input->post('allowed') === FALSE) ? 0 : 1;

			if($this->permission_model->get_permission($action, $controller, $module, $group) === NULL) {
				$this->permission_model->add_permission($action, $controller, $module, $group, $allowed);
			} else {
				$this->permission_model->update_permission($action, $controller, $module, $group, $allowed);
			}
				
		}
	  }
}


/* End of file Module.php */
/* Location: ./application/controllers/Module.php */
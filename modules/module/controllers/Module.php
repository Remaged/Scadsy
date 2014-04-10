<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends SCADSY_Controller{

	public function __construct() {
		parent::__construct();
		$this->module_manager->add_new_modules();
	}

	public function index() {
		parent::init(array('admin'));		
		$this->template_manager->add_controller_script('module_list_js_script','modules/module/assets/scripts/module_list.js','module','module',TRUE);	
		$data['modules'] = $this->module_model->get_modules();
		$this->load->helper('form');
		$this->view('list', $data);
	}
	
	/**
	 * Enables a single module.
	 * (used for jquery-post)
	 */
	public function enable() {
		if($this->input->post('module') !== FALSE) {
			$this->module_model->enable_module(
				$this->input->post('module')
			);	
		}
	}
	
	/**
	 * Disables a single module.
	 * (used for jquery-post)
	 */
	public function disable() {
		if($this->input->post('module') !== FALSE) {
			$this->module_model->disable_module(
				$this->input->post('module')
			);
		}	
	}

	/**
	 * Install a single module.
	 * (used for jquery-post)
	 */
	public function install() {
		if($this->input->post('module') !== FALSE) {
			$this->module_manager->install_module($this->input->post('module'));
			$this->module_model->disable_module(
				$this->input->post('module')
			);	
		}
	}
	
	/**
	 * Uninstall a single module.
	 * (used for jquery-post)
	 */
	public function uninstall() {
		if($this->input->post('module') !== FALSE) {
			$this->module_manager->uninstall_module($this->input->post('module'));
			$this->module_model->uninstall_module(
				$this->input->post('module')
			);	
		}
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
		$this->template_manager->add_controller_script('permission_list_js_script','modules/module/assets/scripts/permission_list.js','module','module',TRUE);			
		$data['modules'] = $this->module_model->get_modules_with_permissions('enabled');
		$this->view('permissions', $data);
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
/* Location: ./modules/module/controllers/Module.php */
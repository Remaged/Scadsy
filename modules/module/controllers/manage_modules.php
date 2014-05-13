<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_modules extends SCADSY_Controller{

	public function __construct() {
		parent::__construct();
		$this->module_manager->add_new_modules();
		parent::init();
	}

	public function index() {
		$this->module_manager->check_modules();
			
		$modules = new Module();
		$modules->get();
		$data['modules'] = $modules;
		
		$this->load->helper('form'); 
		$this->view('modules/list_new', $data);
	}
	
	/**
	 * Enables a single module.
	 * (used for jquery-post)
	 */
	public function enable() {
		if($this->input->post('module') !== FALSE) {			
			$module = new Module();
			$module->get_where(array('directory'=>$this->input->post('module')),1);				
			$module->status = 'enabled';
			$module->save();	
		}
	}
	
	/**
	 * Disables a single module.
	 * (used for jquery-post)
	 */
	public function disable() {
		if($this->input->post('module') !== FALSE) {			
			$module = new Module();
			$module->get_where(array('directory'=>$this->input->post('module')),1);		
			$module->status = 'disabled';
			$module->save();	
		}
	}

	/**
	 * Install a single module.
	 * (used for jquery-post)
	 */
	public function install() {
		if($this->input->post('module') !== FALSE) {
			$this->module_manager->install_module($this->input->post('module'));
			$this->disable();
		}
	}
	
	/**
	 * Uninstall a single module.
	 * (used for jquery-post)
	 */
	public function uninstall() {
		if($this->input->post('module') !== FALSE) {
			$this->module_manager->uninstall_module($this->input->post('module'));
			$module = new Module();
			$module->uninstall($this->input->post('module'));
		}
	}
	
	/**
	 * Refresh a single module
	 * (used for jquery-post)
	 */
	 public function refresh($dir) {
	 	if($this->input->post('module') !== FALSE) {
			$this->module_manager->refresh_module($this->input->post('module'));
		}
	 }
	
	/**
	 * Stores all enable/disable data of all modules
	 */
	public function save_modules(){
		$module = new Module();
		$module->save_statusses($this->input->post('status'));
		redirect('module');
	}

}


/* End of file manage_modules.php */
/* Location: ./modules/module/controllers/manage_modules.php */
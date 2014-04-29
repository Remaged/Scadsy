<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_modules extends SCADSY_Controller{

	public function __construct() {
		parent::__construct();
		$this->module_manager->add_new_modules();
		
		parent::init();
	}

	public function index() {	
		$modules = new Module();
		$modules->get();
		$data['modules'] = $modules;
		
		$this->load->helper('form'); 
		$this->view('list_new', $data);
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
	 * Stores all enable/disable data of all modules
	 */
	public function save_modules(){
		$module = new Module();
		$module->save_statusses($this->input->post('status'));
		redirect('module');
	}
	
	/**
	 * Manage the permissions of the modules
	 */
	 public function permissions() {
	 	$this->load->helper('form');
		 
		$modules = new Module();
		$modules->get_where(array('status'=>'enabled'));
		
		foreach($modules as $module){
			$module->action->get();
			foreach($module->action AS $action){
				$group = new Group();				
				$action->group = $group->get();
				foreach($action->group AS $group){
					$group->permission->get_where(array('action_id'=>$action->id,'group_id'=>$group->id),1);
				}				
			}
		}
		$data['modules'] = $modules;
		$this->view('permissions', $data);
	 }
	 
	 /**
	  * Handle the post from the permission page
	  */
	  public function permission_edit() {
	  	if($this->input->server('REQUEST_METHOD') == "POST") {
			Database_manager::get_db()->trans_start();	

			$action = new Action($this->input->post('module'),$this->input->post('controller'),$this->input->post('action'));		
			$group = new Group($this->input->post('group'));

			$permission = new Permission();
			$permission->where_related($action)->where_related($group)->get();
			$permission->allowed = ($this->input->post('allowed') === FALSE) ? 0 : 1;			
			$permission->save(array($action,$group));
			
			Database_manager::get_db()->trans_complete();	
		}
	  }
}


/* End of file manage_modules.php */
/* Location: ./modules/module/controllers/manage_modules.php */
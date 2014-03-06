<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Controller class */
require APPPATH."third_party/MX/Controller.php";

/**
 * The main controller, every controller should inherit from this controller
 */
class SCADSY_Controller extends MX_Controller {
	
	/**
	 * Construct a new instance of the SCADSY_Controller class
	 */
	public function __construct() {
		parent::__construct();	
		
		$this->load->model('permission_model');
	}

	/**
	 * Initialize the SCADSY_Controller
	 * @param $settings
	 * 		The permission settings used for the current page
	 */
	public function init(Array $settings) {
		if(isset($settings['action']) && isset($settings['module'])) {
			$this->check_permissions($settings['action'], $settings['module'], $settings['group']);
		}	
		
		Module_manager::load_modules();
	}
		
	/**
	 * Check the permission of the current page
	 * @param $action
	 * 		The name of the current action
	 * @param $module
	 * 		The name of the current module
	 * @param $default_groups
	 * 		The default groups that are allowed to view this page. This can be either an array or a single string.
	 */	
	private function check_permissions($action, $module, $default_groups) {
		// TODO: Get user group
		$user_group = "student";
		$is_allowed = $this->check_permissions_database($action, $module, $user_group);
		
		if($is_allowed === NULL) {
			if(in_array($user_group, $default_groups)){
				$is_allowed = TRUE;
			} else {
				$is_allowed = FALSE;
			}
			
			$this->permission_model->add_permission($action, $module, $default_groups, TRUE);
		}
			
		if(!$is_allowed) {
			show_404();
			die();
		}
	}
	
	/**
	 * Check if the database hase user_permissions stored for this action. If it has, use those.
	 * @param $action
	 * 		The name of the current action
	 * @param $module
	 * 		The name of the current module
	 * @param $group
	 * 		The name of the group to check
	 * @return 
	 * 		FALSE if the current group isn't allowed to see the current action
	 * 		TRUE if the current group is allowed to see the current action
	 * 		NULL if no data could be found in the database about this action
	 */
	private function check_permissions_database($action, $module, $group) {
		$is_allowed = NULL;
		if(is_array($group)) {
			foreach($group as $item) {
				$permission = $this->permission_model->get_permission($action, $module, $item);
				if($permission !== NULL) {
					$is_allowed = $permission->allowed;
					break;
				}
			}
		} else {
			$permission = $this->permission_model->get_permission($action, $module, $group);
			if($permission !== NULL) {
				$is_allowed = $permission->allowed;
			}
		}
		return $is_allowed;
	}	
}

/* End of file SCADSY_Controller.php */
/* Location: ./application/core/SCADSY_Controller.php */
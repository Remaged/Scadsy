<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The Permission_manager class. This class manages the permissions.
 */
class Permission_manager {
	private $CI;

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('permission_model');
		$this->CI->load->model('user');
	}

	/**
	 * Request whether or not the permissions should be checked. 
	 */
	 public function should_check_permissions() {
		if(defined("ENTERPRISE")) {
			if($this->CI->user->user_logged_in()) {
				if(Database_manager::get_db()->database == ENTERPRISE){ 
					return FALSE;
				}
			} else {
				return FALSE;
			}
		}
		return TRUE;
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
	public function check_permissions($action, $controller, $module, $default_groups) {

		if ($this->should_check_permissions()){
			
			$user_group = $this->CI->user->get_group();
			$is_allowed = $this->check_permissions_database($action, $controller, $module, $user_group);
			
			if($is_allowed === NULL) {
	echo "JUP";
				if(in_array($user_group, $default_groups)){
					$is_allowed = TRUE;
				} else {
					$is_allowed = FALSE;
				}
				$this->CI->permission_model->add_permission($action, $controller, $module, $user_group, $is_allowed);
			}
				
			return $is_allowed;
		} else {
			return TRUE;
		}
	}
	
	/**
	 * Check if the database hase user_permissions stored for this action. If it has, use those.
	 * @param $action
	 * 		The name of the current action
	 * @param $controller
	 * 		The name of the controller
	 * @param $module
	 * 		The name of the current module
	 * @param $group
	 * 		The name of the group to check
	 * @return 
	 * 		FALSE if the current group isn't allowed to see the current action
	 * 		TRUE if the current group is allowed to see the current action
	 * 		NULL if no data could be found in the database about this action
	 */
	private function check_permissions_database($action, $controller, $module, $group) {
		if($group === NULL) {
			return TRUE;
		}
		
		$is_allowed = NULL;
		if(is_array($group)) {
			foreach($group as $item) {
				$permission = $this->CI->permission_model->get_permission($action, $controller, $module, $item);
				if($permission !== NULL) {
					$is_allowed = $permission->allowed;
					break;
				}
			}
		} else {
			$permission = $this->CI->permission_model->get_permission($action, $controller, $module, $group);
			if($permission !== NULL) {
				$is_allowed = $permission->allowed;
			}
		}
		return $is_allowed;
	}
	
}

/* End of file Permission_manager.php */
/* Location: ./application/libraries/Permission_manager.php */
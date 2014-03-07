<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The Permission_manager class. This class manages the permissions.
 */
class Permission_manager {

	public function __construct() {
		$CI =& get_instance();
		$CI->load->model('permission_model');
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
	public function check_permissions($action, $module, $default_groups) {
		$CI =& get_instance();
		// TODO: Get user group
		$user_group = "admin";
		$is_allowed = $this->check_permissions_database($action, $module, $user_group);
		
		if($is_allowed === NULL) {

			if(in_array($user_group, $default_groups)){
				$is_allowed = TRUE;
			} else {
				$is_allowed = FALSE;
				$CI->permission_model->add_permission($action, $module, $user_group, FALSE);
			}
			
			$CI->permission_model->add_permission($action, $module, $default_groups, TRUE);
		}
			
		return $is_allowed;
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
		$CI =& get_instance();
		$is_allowed = NULL;
		if(is_array($group)) {
			foreach($group as $item) {
				$permission = $CI->permission_model->get_permission($action, $module, $item);
				if($permission !== NULL) {
					$is_allowed = $permission->allowed;
					break;
				}
			}
		} else {
			$permission = $CI->permission_model->get_permission($action, $module, $group);
			if($permission !== NULL) {
				$is_allowed = $permission->allowed;
			}
		}
		return $is_allowed;
	}
	
}

/* End of file Permission_manager.php */
/* Location: ./application/libraries/Permission_manager.php */
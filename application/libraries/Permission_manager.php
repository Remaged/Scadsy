<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The Permission_manager class. This class manages the permissions.
 */
class Permission_manager {
	var $permission;
	var $user; 
	 
	public function __construct() {
		$this->permission = (defined("ENTERPRISE") && Database_manager::get_db()->database == ENTERPRISE) ? NULL : new Permission();
		$this->user = new User();
		
		//$this->permission = new Permission();
		//$this->user = new User();
	}

	/**
	 * Request whether or not the permissions should be checked. 
	 */
	 public function should_check_permissions() {
		if(defined("ENTERPRISE")) {
			if($this->user->is_logged_in()) {
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
	 * Check the permission of the current page.
	 * @param $action
	 * 		The name of the current action.
	 * @param $controller
	 * 		The name of the current controller.
	 * @param $module
	 * 		The name of the current module.
	 * @return
	 * 		TRUE if a permission with allow is found
	 * 		FALSE if a permission with deny is found or no permission is found.		
	 */	
	public function check_permissions($action_name, $controller, $module_name) {
		if ($this->should_check_permissions()){		
			$user_groups = $this->user->get_by_logged_in()->group->get();
			$action = new Action($module_name, $controller, $action_name);			
			return $this->group_has_permission($action, $user_groups);
		} else {
			return TRUE;
		}
	}
	
	/**
	 * Check the permission of the user against a certain group
	 * @param $group
	 * 		The group to check the user again
	 * @return bool
	 * 		Whether or not the user has permissions
	 */
	 public function has_permission($groups) {
	 	if(is_array($groups)) {
	 		return in_array($this->user->get_by_logged_in()->group->name, $groups);
	 	} else {
	 		return strtolower($this->user->get_by_logged_in()->group->name) == strtolower($groups);
	 	}	 	
	 }

	
	
	
	/**
	 * Checks if a group or a group in a set of groups has permission for a certain action. 
	 * If no permission is found, the ancesters (parent-groups) will be checked untill a permission is found or there are no further ancesters.
	 * @param $action
	 * 		action-object (datamapper) to check if the group has permission for
	 * @param $groups
	 * 		group-object (datamapper) to check if it has permission for the action. This can either be a single group or a set of groups. 
	 * @return
	 * 		TRUE if any of the groups, parent-groups or ancester-groups is allowed.
	 * 		FALSE if none of the groups, parent-groups or ancester-groups is allowed.
	 */
	public function group_has_permission($action, $groups){
		if($groups->exists() === FALSE){
			return FALSE;
		}
		foreach($groups AS $group){
			$permission = new Permission();
			$permission->where_related($action)->where_related($group)->get();
			if($permission->exists()){
				return $permission->allowed == 1;
			}
			else{
				if($this->group_has_permission($action, $group->parent_group->get()) === TRUE){
					return TRUE;
				}
			}
		}
		return FALSE;
	}
	
}

/* End of file Permission_manager.php */
/* Location: ./application/libraries/Permission_manager.php */
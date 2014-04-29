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
	 * Check the permission of the current page
	 * @param $action
	 * 		The name of the current action
	 * @param $module
	 * 		The name of the current module
	 * @param $default_groups
	 * 		The default groups that are allowed to view this page. This can be either an array or a single string.
	 */	
	public function check_permissions($action_name, $controller, $module_name, $default_groups) {

		if ($this->should_check_permissions()){
			
			$user_group = $this->user->get_by_logged_in()->group->name;
			$is_allowed = $this->check_permissions_database($action_name, $controller, $module_name, $user_group);
			
			if($is_allowed === NULL) {
				if(in_array($user_group, $default_groups)){
					$is_allowed = TRUE;
				} else {
					$is_allowed = FALSE;
				}
			
				$action = new Action();
				$action->get_by_unique($module_name, $controller, $action_name);
				
				$group = new Group();
				$group->get_where(array('name'=>$user_group),1);
				
				$this->permission->allowed = $is_allowed;

				$this->permission->save(array($action, $group));
				
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
	private function check_permissions_database($action, $controller, $module, $groups) {
		if($groups === NULL) {
			return TRUE;
		}		
		$is_allowed = NULL;
		if(is_array($groups)) {
			foreach($groups as $group) {				
				$this->permission->get_by_unique($module, $controller, $action, $group);
				if($this->permission->exists() === TRUE){
					$is_allowed = $this->permission->allowed;
					break;
				}
			}
		} else {		
			$this->permission->get_by_unique($module,$controller,$action,$groups);
			if($this->permission->exists() === TRUE){
				$is_allowed = $this->permission->allowed;
			}
		}
		return $is_allowed;
	}
	
}

/* End of file Permission_manager.php */
/* Location: ./application/libraries/Permission_manager.php */
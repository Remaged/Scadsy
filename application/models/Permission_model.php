<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The permission_model. This class is responsible for communicating with the permission table
 */
class Permission_model extends SCADSY_Model {
	
	/**
	 * Get the permission from a certain action
	 * @param $action
	 * 		The name of the action
	 * @param $module
	 * 		The name of the module
	 * @param $group
	 * 		The name of the group
	 * @return
	 * 		The found permission or NULL if no permission could be found.
	 */
	public function get_permission($action, $module, $group) {
		$query = Database_manager::get_db()->get_where('permission', array(
											'module_action_name' => $action,
											'module_action_module' => $module,
											'group_name' => $group
											));
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return NULL;
		}									
	}
	
	/**
	 * Save a permission to the database
	 * @param $action
	 * 		The name of the action
	 * @param $module
	 * 		The name of the module
	 * @param $default_groups
	 * 		The default groups. This can be an array or a single string.
	 * @param $allowed
	 * 		Whether the permissions should be to allow or to disallow
	 */
	public function add_permission($action, $module, $default_groups, $allowed) {
		if(is_array($default_groups)) {
			foreach($default_groups as $group) {
				Database_manager::get_db()->insert('permission', array(
										'module_action_name' => $action,
										'module_action_module' => $module,
										'group_name' => $group,
										'allowed' => $allowed
										));
			}
		} else {
				Database_manager::get_db()->insert('permission', array(
												'module_action_name' => $action,
												'module_action_module' => $module,
												'group_name' => $default_groups,
												'allowed' => $allowed
												));								
		}
	}
}

/* End of file Permission_model.php */
/* Location: ./application/models/Permission_model.php */
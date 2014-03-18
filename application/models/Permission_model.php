<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The permission_model. This class is responsible for communicating with the permission table
 */
class Permission_model extends SCADSY_Model {
	
	/**
	 * Get the permission from a certain action
	 * @param $action
	 * 		The name of the action
	 * @param $controller
	 * 		The name of the controller
	 * @param $module
	 * 		The name of the module
	 * @param $group
	 * 		The name of the group
	 * @return
	 * 		The found permission or NULL if no permission could be found.
	 */
	public function get_permission($action, $controller, $module, $group) {
		$query = Database_manager::get_db()->get_where('permission', array(
												'module_action_name' => $action,
												'module_action_module' => $module,
												'module_action_controller' => $controller,
												'group_name' => $group
											));
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return NULL;
		}									
	}
	
	/**
	 * Get the permissions for a certain module
	 * @param $module
	 * 		The module to get the permissions for.
	 * @return
	 * 		The found permissions or NULL if no permissions could be found.
	 */
	 public function get_module_permissions($module) {
		
		Database_manager::get_db()->select('module_action.module AS module_name');
		Database_manager::get_db()->select('module_action.name AS action_name');
		Database_manager::get_db()->select('module_action.controller AS controller_name');
		Database_manager::get_db()->select('group.name AS group_name');
		Database_manager::get_db()->select('permission.allowed AS allowed');
		Database_manager::get_db()->from('module_action');
		Database_manager::get_db()->where('module_action.module', $module);
		Database_manager::get_db()->join('group', 'group.name = group.name', 'inner');
		Database_manager::get_db()->join('permission','group.name = permission.group_name AND permission.module_action_module = module_action.module AND permission.module_action_name = module_action.name AND permission.module_action_controller = module_action.controller','left');
	 	Database_manager::get_db()->order_by('module_action.module, module_action.controller, module_action.name, group.name');
	 	$query = Database_manager::get_db()->get();

		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return NULL;
		}							 					
	 }
	
	/**
	 * Save a permission to the database
	 * @param $action
	 * 		The name of the action
	 * @param $controller
	 * 		The name of the controller
	 * @param $module
	 * 		The name of the module
	 * @param $default_groups
	 * 		The default groups. This can be an array or a single string.
	 * @param $allowed
	 * 		Whether the permissions should be to allow or to disallow
	 */
	public function add_permission($action, $controller, $module, $default_groups, $allowed) {
		if(is_array($default_groups)) {
			foreach($default_groups as $group) {
				Database_manager::get_db()->insert('permission', array(
											'module_action_name' => $action,
											'module_action_module' => $module,
											'module_action_controller' => $controller,
											'group_name' => $group,
											'allowed' => $allowed
										));
			}
		} else {
				Database_manager::get_db()->insert('permission', array(
													'module_action_name' => $action,
													'module_action_module' => $module,
													'module_action_controller' => $controller,
													'group_name' => $default_groups,
													'allowed' => $allowed
												));								
		}
	}
	
	/**
	 * Update a permission in the database
	 * @param $action
	 * 		The name of the action
	 * @param $controller
	 * 		The name of the controller
	 * @param $module
	 * 		The name of the module
	 * @param $group
	 * 		The name of the group
	 * @param $allowed
	 * 		Whether the permissions should be to allow or to disallow
	 */
	public function update_permission($action, $controller, $module, $group, $allowed) {
		Database_manager::get_db()->where('module_action_name', $action);
		Database_manager::get_db()->where('module_action_module', $module);
		Database_manager::get_db()->where('module_action_controller', $controller);
		Database_manager::get_db()->where('group_name', $group);
		Database_manager::get_db()->update('permission', array(
											'allowed' => $allowed
										));								
	}
	
}

/* End of file Permission_model.php */
/* Location: ./application/models/Permission_model.php */
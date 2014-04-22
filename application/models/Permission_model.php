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
		$query = Database_manager::get_db()
					->from('permissions')
					->join('actions','permissions.action_id=actions.id','inner')
					->join('modules','modules.id = actions.module_id','inner')
					->join('groups','groups.id = permissions.group_id','inner')
					->where('actions.name',$action)
					->where('modules.name',$module)
					->where('actions.controller',$controller)
					->where('groups.name',$group)
					->get();
		/*	
		$query = Database_manager::get_db()->get_where('permissions', array(
												'module_action_name' => $action,
												'module_action_module' => $module,
												'module_action_controller' => $controller,
												'group_name' => $group
											));
		*/
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
	 	Database_manager::get_db()
	 		->select('
	 			modules.name AS module_name,
	 			actions.name AS action_name,
	 			actions.controller AS controller_name,
	 			groups.name AS group_name,
	 			permissions.allowed AS allowed
	 		')
			->from('actions')
			->where('modules.directory', $module)
			->join('modules', 'modules.id = actions.module_id', 'inner')
			->join('groups', 'groups.name = groups.name', 'inner')
			->join('permissions','groups.id = permissions.group_id AND permissions.action_id = actions.id','left')
			->order_by('modules.name, actions.controller, actions.name, groups.name');

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
		echo $module;
		print_r(Database_manager::get_db()
						->get_where('modules',array('directory'=>$module),1)->row()); exit();
		$module_id = Database_manager::get_db()
						->get_where('modules',array('directory'=>$module),1)
						->row()
						->id;
		$action_id = Database_manager::get_db()
						->get_where('actions',array('name'=>$action,'controller'=>$controller,'module_id'=>$module_id),1)
						->row()
						->id;
		if(is_array($default_groups)) {
			foreach($default_groups as $group) {
				$group_id = Database_manager::get_db()->get_where('groups',array('name'=>$group))->row()->id;						
				Database_manager::get_db()->insert('permissions',array(
						'action_id' => $action_id,
						'group_id' => $group_id
					)
				);
				/*
				Database_manager::get_db()->insert('permission', array(
											'module_action_name' => $action,
											'module_action_module' => $module,
											'module_action_controller' => $controller,
											'group_name' => $group,
											'allowed' => $allowed
										));
				 */ 
			}
		} else {
				$group_id = Database_manager::get_db()->get_where('groups',array('name'=>$default_groups))->row()->id;	
				Database_manager::get_db()->insert('permissions',array(
						'action_id' => $action_id,
						'group_id' => $group_id
					)
				);
				/*
				Database_manager::get_db()->insert('permission', array(
													'module_action_name' => $action,
													'module_action_module' => $module,
													'module_action_controller' => $controller,
													'group_name' => $default_groups,
													'allowed' => $allowed
												));	
				 */ 							
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
		$module_id = Database_manager::get_db()->get_where('modules',array('directory'=>$module))>row()->id;
		$action_id = Database_manager::get_db()->get_where('actions',array('name'=>$action,'controller'=>$controller,'module_id'=>$module_id))->row()->id;
		$group_id = Database_manager::get_db()->get_where('groups',array('name'=>$default_groups))->row()->id;
		
		Database_manager::get_db()
			->where('action_id',$action_id)
			->where('group_id',$group_id)
			->update('permission', array(
				'allowed' => $allowed
			));	
		/*								
		Database_manager::get_db()->where('module_action_name', $action);
		Database_manager::get_db()->where('module_action_module', $module);
		Database_manager::get_db()->where('module_action_controller', $controller);
		Database_manager::get_db()->where('group_name', $group);
		Database_manager::get_db()->update('permission', array(
											'allowed' => $allowed
										));	
		 */ 							
	}
	
}

/* End of file Permission_model.php */
/* Location: ./application/models/Permission_model.php */
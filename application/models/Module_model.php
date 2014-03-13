<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The module_model. This model is responsible for communicating with the module table.
 */
class Module_model extends SCADSY_Model {
	
	/**
	 * Get the modules that have a certain status
	 * @param $status
	 * 		The status of the module. Can be 'enabled', 'disabled'or 'all'
	 * @return
	 * 		The found modules
	 */
	public function get_modules($status = 'all') {
		if($status == 'enabled' || $status == 'disabled') {
			$query = Database_manager::get_db()->get_where('module', array('status' => $status));
			return $query->result();
		} else if ($status == 'all') {
			return Database_manager::get_db()->get('module')->result();
		}
		throw new Exception("Invalid status");
	}
	
	/**
	 * Enable a module
	 * @param $directory
	 * 		The directory of the module
	 */
	 public function enable_module($directory) {
	 	Database_manager::get_db()->where('directory', $directory);
	 	Database_manager::get_db()->update('module', array('status' => 'enabled'));
	 }
	 
	/**
	 * Disable a module
	 * @param $directory
	 * 		The directory of the module
	 */
	 public function disable_module($directory) {
	 	Database_manager::get_db()->where('directory', $directory);
	 	Database_manager::get_db()->update('module', array('status' => 'disabled'));
	 }
	 
	 /**
	  * Stores status for all modules.
	  * @param $statusses
	  * 		associative array in which keynames match the module directory names
	  */
	 public function save_module_statusses($statusses){
	 	Database_manager::get_db()->trans_start();	
		Database_manager::get_db()->update('module',array('status'=>'disabled'));
		foreach($statusses AS $module => $val){
			Database_manager::get_db()->where('directory',$module)->update('module',array('status'=>'enabled'));
		}
		Database_manager::get_db()->trans_complete();
	 }
	
	/**
	 * Check if a module is active
	 * @param $directory
	 * 		The directory of the module
	 * @return 
	 * 		Whether or not the module is active
	 */
	public function is_module_active($directory) {
		$query = Database_manager::get_db()->get_where('module', array('directory' => $directory, 'status' => 'enabled'));
		
		return $query->num_rows() > 0;
	}
	
	/**
	 * Get a module
	 * @param $directory
	 * 		The directory of the module
	 * @return
	 * 		The module data or NULL if no module is found
	 */
	public function get_module($directory) {
		$query = Database_manager::get_db()->get_where('module', array('directory' => $directory));
		
		if($query->num_rows() == 1) {
		 	return $query->row();
		} else {
			return NULL;
		}
	}
	
	/**
	 * Add module
	 * @param $module_metadata
	 * 		An array with all the data to add a module
	 * @param $module_actions
	 * 		An array with all the actions of a module
	 * @param $module_permissions
	 * 		An array with the groups that are allowed to load this module
	 */
	 public function add_module($module_metadata, $module_actions, $module_permissions) {
	 	Database_manager::get_db()->trans_start();
		
	 	Database_manager::get_db()->insert('module', $module_metadata);
		
		foreach($module_actions as $action) {
	 		Database_manager::get_db()->insert('module_action', array(
																"name" => $action,
																"module" => $module_metadata['directory']
																));
	 	}
		
		foreach($module_permissions as $permission) {
			Database_manager::get_db()->insert('module_permission', array(
																		"module" => $module_metadata['directory'],
																		"group" => $permission
																		));
		}
		
		Database_manager::get_db()->trans_complete();
	 }
}

/* End of file Module_model.php */
/* Location: ./application/models/Module_model.php */
<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The module_model. This model is responsible for communicating with the module table.
 */
class Module_model extends SCADSY_Model {
	
	/**
	 * Get the modules that have a certain status
	 * @param $status
	 * 		The status of the module. Can be 'enabled' or 'disabled'
	 * @return
	 * 		The found modules
	 */
	public function get_modules($status) {
		if($status == 'enabled' || $status == 'disabled') {
			$query = Database_manager::get_db()->get_where('module', array('status' => $status));
			return $query->result();
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
	  * Add the permissions of a module to the database
	  * @param $permissions
	  * 	The permissions associated with a certain module
	  * @param $directory
	  * 	The directory the module is located
	  */
	 public function add_module_permissions($permissions, $directory) {
		foreach($permissions as $permission) {
			Database_manager::get_db()->insert('modules_permissions', array('module' => $directory, 'permission' => $permission));
		}
	}
	
	/**
	 * Check if a module is active
	 * @param $directory
	 * 		The directory of the module
	 * @return 
	 * 		Whether or not the module is active
	 */
	public function is_module_active($directory) {
		$query = Database_manager::get_db()->get_where('modules', array('directory' => $directory, 'status' => 'enabled'));
		
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
		$query = Database_manager::get_db()->get_where('modules', array('directory' => $directory));
		
		if($query->num_rows() == 1) {
		 	return $query->row();
		} else {
			return NULL;
		}
	}
}

/* End of file Module_model.php */
/* Location: ./application/models/Module_model.php */
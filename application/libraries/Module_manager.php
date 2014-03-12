<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The module_manager class. This class manages the initialising and loading of modules.
 */
class Module_manager {

	/**
	 * Load all the currently active modules
	 */
	public static function load_modules() {
		$CI =& get_instance();
		if(defined('ENTERPRISE') && $CI->user_model->user_logged_in() === FALSE){				
			$CI->config->load('enterprise');
			$modules = $CI->config->item('enterprise_modules');
		}
		else{
			$CI->load->model('module_model');			
			$modules = $CI->module_model->get_modules('enabled');
		}
		foreach($modules as $module) {
			foreach($CI->config->item('modules_locations') as $key => $value) {
				if(is_file($key.$module->directory.'\index.php')) {
					include_once($key.$module->directory.'\index.php');	
				}
			}
		}
	}
	
	/**
	 * Scan for new modules and add them to the database
	 */
	public static function add_new_modules() {
		$CI =& get_instance();
		$CI->load->model('module_model');
		
		// Get files and directories without the . and .. folders
		foreach($CI->config->item('modules_locations') as $key => $value) {
			$directories = preg_grep('/^([^.])/', scandir($key));
				
			// Scan all files/folders found
			foreach($directories as $dir) {
				// If it is a dir and has the correct file name
				if(is_dir($key.$dir) 
						&& is_file($key.$dir . '\index.php')) {
							
					$module_metadata = self::get_module_metadata($key.$dir . '\index.php', $dir);
					$module_actions = self::get_module_actions($key.$dir.'\controllers\\'.$dir.'.php', $dir);
					$module_permissions = self::get_module_permissions($key.$dir . '\index.php');
	
					if($CI->module_model->get_module($module_metadata['directory']) === NULL){
						$CI->module_model->add_module($module_metadata, $module_actions, $module_permissions);					
					}
				}
			}
		}
	}
	
	/**
	 * Get the meta data from a module
	 * @param $filepath
	 * 		The complete filepath to the index.php
	 * @param $directory
	 * 		The directory where the module is located
	 * @return
	 * 		The meta data extracted from the module
	 */
	private static function get_module_metadata($filepath, $directory) {
		// Load the class		
		$module_data = file_get_contents($filepath);
		
		// Get the meta data
		preg_match ( '|Module Name:(.*)$|mi', $module_data, $name );
		preg_match ( '|Module URI:(.*)$|mi', $module_data, $uri );
		preg_match ( '|Version:(.*)|i', $module_data, $version );
		preg_match ( '|Description:(.*)$|mi', $module_data, $description );
		preg_match ( '|Author:(.*)$|mi', $module_data, $author_name );
		preg_match ( '|Author URI:(.*)$|mi', $module_data, $author_uri );
		
		return array(
			'directory' => $directory,
			'name' => $name[1], 
			'uri' => $uri[1],
			'version' => $version[1],
			'description' => $description[1],
			'author' => $author_name[1],
			'author_uri' => $author_uri[1]);	
	}
	
	/**
	 * Get the permissions from the module
	 * @param $filepath
	 * 		The complete filepath to the index.php
	 * @return 
	 * 		The permissions for the module
	 */
	private static function get_module_permissions($filepath) {
		// Load the class		
		$module_data = file_get_contents($filepath);
		
		// Get the meta data
		preg_match ( '|Module Permissions:(.*)$|mi', $module_data, $permission );
		
		$permissions = explode(',', $permission[1]);
		
		foreach($permissions as &$permission) {
			$permission = trim($permission);
		}
		
		return $permissions;	
	}
	
	/**
	 * Get the actions a certain module can perform
	 * @param $filepath
	 * 		The complete filepath to the controller file
	 * @return 
	 * 		An array with action names
	 */
	private static function get_module_actions($filepath, $directory) {							
		include_once($filepath);
		
		$reflection_class = new ReflectionClass($directory);
		$results = $reflection_class->getMethods(ReflectionMethod::IS_PUBLIC);

		$methods = array();
		foreach($results as $result) {
			if(strtolower($result->class) == strtolower($directory) && $result->name != '__construct') {
				$methods[] = $result->name;
			}
		}
		
		return $methods;
	}
}

/* End of file Module_manager.php */
/* Location: ./application/libraries/Module_manager.php */
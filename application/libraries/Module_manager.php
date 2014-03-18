<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The module_manager class. This class manages the initialising and loading of modules.
 */
class Module_manager {

	/** 
	 * Install a module 
	 **/	
	public function install_module($directory) {
		$CI =& get_instance();
		foreach(Modules::$locations as $location => $offset) {
			$file = $location.$directory.'/install.php';
			if(is_file($file)) {
				include_once($file);
				$CI->module_model->disable_module($directory);
				return;
			}
		}
	}
	
	/** 
	 * Uninstall a module 
	 **/	
	public function uninstall_module($directory) {
		$CI =& get_instance();
		foreach(Modules::$locations as $location => $offset) {
			$file = $location.$directory.'/uninstall.php';
			if(is_file($file)) {
				include_once($file);
				$CI->module_model->uninstall_module($directory);
				return;
			}
		}
	}

	/**
	 * Load all the currently active modules
	 */
	public function load_modules() {
		$CI =& get_instance();

		if(!defined('ENTERPRISE') || isset($_COOKIE['scadsy_db_cookie'])){
			$CI->load->model('module_model');			
			$modules = $CI->module_model->get_modules('enabled');
		}
		else{
			$modules = $this->get_enterprise_modules();
		}

		foreach($modules as $module) {
			$module = (array) $module;
			foreach($CI->config->item('modules_locations') as $key => $value) {
				if(is_file($key.$module['directory'].'\index.php')) {
					include_once($key.$module['directory'].'\index.php');	
				}
			}
		}
	}
	
	/**
	 * Scan for new modules and add them to the database
	 */
	public function add_new_modules() {
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
							
					$module_metadata = $this->get_module_metadata($key.$dir . '\index.php', $dir);
					$module_actions = $this->get_module_actions($key.$dir.'\controllers\\');
					$module_permissions = $this->get_module_permissions($key.$dir . '\index.php');
	
					if($CI->module_model->get_module($module_metadata['directory']) === NULL){
						$CI->module_model->add_module($module_metadata, $module_actions, $module_permissions);					
					}
				}
			}
		}
	}
	
	
	/**
	 * Scan for all enterprise modules, retrieving their metadata.
	 * @return
	 * 		array with the metadata of each enterprise module.
	 */
	private function get_enterprise_modules(){
		$modules_data = array();
		$CI =& get_instance();
		$enterprise_locations = array_keys($CI->config->item('enterprise_locations'));
		foreach($enterprise_locations AS $enterprise_location){					
			$module_dirs = scandir(getcwd().'/'.$enterprise_location);					
			foreach($module_dirs AS $module_dir){
				if(is_dir($module_dir) && $module_dir != '.' && $module_dir != '..'){
					$dirpath = getcwd().'/'.$enterprise_location.$module_dir;
					$index_filepath = $dirpath.'/index.php';
					if(is_file($index_filepath)){
						$modules_data[] = $this->get_module_metadata($index_filepath,$dirpath);
					}
				}
			}
		}
		return $modules_data;
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
	private function get_module_metadata($filepath, $directory) {
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
	private function get_module_permissions($filepath) {
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
	 * @param $directory
	 * 		The controllers directory
	 * @return 
	 * 		An array with action names
	 */
	private function get_module_actions($directory) {		
		$directories = preg_grep('/^([^.])/', scandir($directory));		
		$module_actions = array();

		foreach($directories as $file) {
			if(strpos($file, ".php") !== FALSE) {
				$classname = str_replace(".php", "", $file);
				include_once($directory.$file);
		
				$reflection_class = new ReflectionClass($classname);
				$results = $reflection_class->getMethods(ReflectionMethod::IS_PUBLIC);
		
				$methods = array();
				foreach($results as $result) {
					if(strtolower($result->class) == strtolower($classname) && $result->name != '__construct') {
						$module_actions[] = array("controller" => strtolower($result->class), "action" => $result->name);
					}
				}
			}
		}
		
		return $module_actions;
	}
}

/* End of file Module_manager.php */
/* Location: ./application/libraries/Module_manager.php */
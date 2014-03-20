<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin-module model
 */
class Module_all_schools_model extends SCADSY_Model {
	
	public function __construct() {				
		parent::__construct();
		$this->load->model('module_model');
	}
	
	/**
	 * Gets connection-info of all school-databases.
	 * @return
	 * 		array of objects containing connection-data
	 */
	public function get_databases(){
		return Database_manager::get_db(TRUE)->get('database')->result();
	}
	
	/**
	 * retrieves information of all modules of all school-databases.
	 * @return
	 * 		associative array: keys match database names of schools.
	 * 		values contain array of module objects.
	 */ 
	public function get_schools_modules(){
		$modules_list = $this->module_manager->get_all_modules_from_directory();

		$modules_per_school = array();
		$school_databases = $this->get_databases();
		foreach($school_databases AS $school_db){
			if($school_db->name == ENTERPRISE){ continue; }
			Database_manager::set_db($school_db->name);			
			$this->add_missing_modules($this->module_model->get_modules(),$modules_list);
			$school_models = $this->add_missing_modules($this->module_model->get_modules(),$modules_list);
			$modules_per_school[$school_db->name] = $school_models;
		}
		Database_manager::disconnect();
		return $modules_per_school;
	}
	
	private function add_missing_modules($school_modules, $all_modules){
		$school_module_directories = array();
		foreach($school_modules AS $school_module){
			$school_module_directories[] = $school_module->directory;
		}

		foreach($all_modules AS $module){
			if(!in_array($module['directory'],$school_module_directories)){
				$module_obj = (object)$module;
				$module_obj->status = NULL;
				$school_modules[] = $module_obj;
			}
		}
		return $school_modules;
	}

	/**
	 * Enable a module
	 */
	 public function enable_module($directory,$school_db) {
	 	Database_manager::set_db($school_db);	
		$this->module_model->enable_module($directory);
		Database_manager::disconnect();
	 }
	 
	/**
	 * Disable a module
	 */
	 public function disable_module($directory,$school_db) {	 	
	 	Database_manager::set_db($school_db);	
		$this->module_model->disable_module($directory);
		Database_manager::disconnect();
	 } 
	 
	 /**
	  * Saves all enabled/disabled settings for the modules of all schools. 
	  */
	 public function save_all_module_settings($statusses){	 	
		foreach($statusses AS $school_db => $modules){
	 		Database_manager::set_db($school_db);
			$this->module_model->save_module_statusses($modules);	
			Database_manager::disconnect();		
		}
	 }
	
}


/* End of file Module_all_schools_model.php */
/* Location: ./modules/enterprise/models/Module_all_schools_model.php */
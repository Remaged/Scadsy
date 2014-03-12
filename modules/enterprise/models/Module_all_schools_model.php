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
		$modules_per_school = array();
		$school_databases = $this->get_databases();
		foreach($school_databases AS $school_db){
			Database_manager::set_db($school_db->name);			
			$modules_per_school[$school_db->name] = $this->module_model->get_modules();
		}
		Database_manager::disconnect();
		return $modules_per_school;
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
			Database_manager::get_db()->trans_start();	
			Database_manager::get_db()->update('module',array('status'=>'disabled'));
			foreach($modules AS $module => $val){
				Database_manager::get_db()->where('directory',$module)->update('module',array('status'=>'enabled'));
			}
			Database_manager::get_db()->trans_complete();	
			Database_manager::disconnect();		
		}
	 }
	
}


/* End of file Module_all_schools_model.php */
/* Location: ./modules/enterprise/models/Module_all_schools_model.php */
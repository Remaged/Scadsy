<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin-module model
 */
class Admin_model extends SCADSY_Model {
	
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
		return $modules_per_school;
	}

		/**
	 * Enable a module
	 * @param $directory
	 * 		The directory of the module
	 * @param $schooldb
	 * 		database of the school that this module has to be disabled for.
	 */
	 public function enable_module($directory,$school_db) {
	 	Database_manager::set_db($school_db);	
		$this->module_model->enable_module();
	 }
	 
	/**
	 * Disable a module
	 * @param $directory
	 * 		The directory of the module
	 * @param $school_db
	 * 		database of the school that this module has to be disabled for.
	 */
	 public function disable_module($directory,$school_db) {
	 	Database_manager::set_db($school_db);	
		$this->module_model->disable_module();
	 } 
	 
	
	/**
	 * Sets rules for the login form validation.
	 */
	public function setup_form_validation(){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}
	
}


/* End of file Admin_model.php */
/* Location: ./modules/admin/models/Admin_model.php */
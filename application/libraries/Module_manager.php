<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The module_manager class. This class manager the initialising and loading of modules.
 */
class Module_manager {

	/**
	 * Load all the currently active modules
	 */
	public static function load_modules() {
		$CI =& get_instance();
		$CI->load->model('module_model');
		
		$modules = $CI->module_model->get_modules('enabled');

		foreach($modules as $module) {
			foreach($CI->config->item('modules_locations') as $key => $value) {
				if(is_file($key.$module->directory.'\index.php')) {
					include_once($key.$module->directory.'\index.php');	
				}
			}
		}
	}
}

/* End of file Module_manager.php */
/* Location: ./application/libraries/Module_manager.php */
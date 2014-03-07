<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Controller class */
require APPPATH."third_party/MX/Controller.php";

/**
 * The main controller, every controller should inherit from this controller
 */
class SCADSY_Controller extends MX_Controller {
	
	/**
	 * Construct a new instance of the SCADSY_Controller class
	 */
	public function __construct() {
		parent::__construct();	
	}

	/**
	 * Initialize the SCADSY_Controller
	 * @param $settings
	 * 		The permission settings used for the current page
	 */
	public function init(Array $settings) {
		if(isset($settings['action']) && isset($settings['module'])) {
			$is_allowed = $this->permission_manager->check_permissions($settings['action'], $settings['module'], $settings['group']);
			
			if(!$is_allowed) {
				//show_404();\
				echo 'No permission to view this page';
				die();
			}
		}	
		
		Module_manager::load_modules();
	}
			
}

/* End of file SCADSY_Controller.php */
/* Location: ./application/core/SCADSY_Controller.php */
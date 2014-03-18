<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Router.php";

/**
 * The main router. This class is responsible for routing the url request to the correct controllers.
 */
class SCADSY_Router extends MX_Router {
	public function __construct() {
		global $CFG;
		if(!defined('ENTERPRISE') || isset($_COOKIE['scadsy_db_cookie'])){
			Modules::$locations = $CFG->item('modules_locations');
		}
		else{
			Modules::$locations = $CFG->item('enterprise_locations');
		}
		
		parent::__construct();
	}
}


/* End of file SCADSY_Router.php */
/* Location: ./application/core/SCADSY_Router.php */
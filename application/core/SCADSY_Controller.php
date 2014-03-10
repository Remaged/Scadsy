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
		$this->redirect_to_login();
	}
	
	/**
	 * Redirects users to the the login page when not logged in.
	 */
	protected function redirect_to_login(){
		if($this->user_model->user_logged_in() === FALSE && uri_string() != 'login'){
			redirect('login');
		}
	}

	/**
	 * Initialize the SCADSY_Controller
	 * @param $settings
	 * 		The permission settings used for the current page
	 */
	protected function init(Array $settings) {
		if(isset($settings['action']) && isset($settings['module'])) {
			$is_allowed = $this->permission_manager->check_permissions($settings['action'], $settings['module'], $settings['group']);
			if(!$is_allowed) {
				//show_404();\
				echo 'No permission to view this page!';
				die();
			}
		}	
		
		Module_manager::load_modules();
	}
			
	/**
	 * The view function
	 * @param $page
	 * 		The page for the view
	 * @param $data
	 * 		Optional, The data for the view
	 */		
	protected function view($page, $data = '')
	{
		$headerdata['menu'] = $this->menu_manager->get_menu();
		$headerdata['scripts'] = $this->template_manager->get_scripts();
		$headerdata['stylesheets'] = $this->template_manager->get_stylesheets();
		$this->load->view('template/header.php', $headerdata);
		
	    $this->load->view($page, $data);
		
		$footerdata['scripts'] = $this->template_manager->get_scripts(FALSE);
		$this->load->view('template/footer.php', $footerdata);
	}
}

/* End of file SCADSY_Controller.php */
/* Location: ./application/core/SCADSY_Controller.php */
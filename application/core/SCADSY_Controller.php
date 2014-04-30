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

		$this->load_managers();
		if ($this->permission_manager->should_check_permissions()){			
			$this->check_module_enabled();
		}
				
		$this->module_manager->load_modules();
	}
	
	/**
	 * Redirects users to the the login page when not logged in.
	 */
	protected function redirect_to_login(){
		if($this->user->is_logged_in() === FALSE && get_class($this) != 'Login'){
			redirect('user/login/index');
		}
	}
	
	/**
	 * Check if this controller should be loaded
	 */
	 private function check_module_enabled() {
	 	$module = $this->router->get_module();
		
	 	$query = Database_manager::get_db()->get_where('modules', array('directory' => $module, 'status' => 'enabled'));
		if($query->num_rows() == 0) {
			show_401();
			die();
		}		
	 }
	
	/**
	 * Load the managers
	 */
	 protected function load_managers() {
	 	$this->load->library('permission_manager');
	 	$this->load->library('menu_manager');
		$this->load->library('template_manager');
		$this->load->library('module_manager');
		$this->load->library('form_manager');
		$this->load->library('notification_manager');
	 }

	/**
	 * Initialize the SCADSY_Controller
	 * @param $groups
	 * 		The default groups that are allowed to view this page
	 */
	protected function init(Array $groups = array()) {
		$module = $this->router->get_module();
		$controller = $this->router->get_controller();
		$action = $this->router->get_action();
		$is_allowed = $this->permission_manager->check_permissions($action, $controller, $module, $groups);

		if(!$is_allowed) {
			show_401();
			die();
		}	
	}
			
	/**
	 * The view function
	 * @param $page
	 * 		The page for the view
	 * @param $data
	 * 		Optional, The data for the view
	 */		
	protected function view($page, $data = '', $header_template = 'template/header', $footer_template = 'template/footer')
	{
		if($this->input->is_ajax_request() === TRUE){
			$this->load->view($page, $data);
			return;
		}
		$headerdata['menu'] = $this->menu_manager->get_menu();
		$headerdata['scripts'] = $this->template_manager->get_scripts();
		$headerdata['stylesheets'] = $this->template_manager->get_stylesheets();
		$headerdata['notifications'] = $this->notification_manager->get_notifications();
		$this->load->view($header_template, $headerdata);
		
	    $this->load->view($page, $data);
		
		$footerdata['scripts'] = $this->template_manager->get_scripts(FALSE);
		$this->load->view($footer_template, $footerdata);
	}
}

/* End of file SCADSY_Controller.php */
/* Location: ./application/core/SCADSY_Controller.php */
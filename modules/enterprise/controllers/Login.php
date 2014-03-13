<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The module-login controller, handles the login and logout requests.
 */
class Login extends SCADSY_Controller{
	protected $data = array('failed_message'=>'');
	
	public function __construct() {		
		parent::__construct(); 
		//$this->module_manager->add_new_modules();
		$this->load->model('login_model');
	}
	
	/**
	 * Default action. When user not logged in this results in a login form. Otherwise a succes page will be shown.
	 */
	public function index() {
		$validate_login = $this->login_model->validate_login(); 
		if($this->user_model->user_logged_in() || $validate_login === TRUE){
			parent::init(array(
				'module' => "login",
				'action' => "index",
				'group' => array('admin','student','teacher')
				)
			);
			$this->view('login/succes');
		}		
		else{
			$this->data['failed_message'] = $validate_login;
			$this->data['schools'] = $this->login_model->get_databases();
			$this->view('login/index',$this->data,'template/header_without_menu');
		}
	}
	
	/**
	 * Logs out user
	 */
	public function logout(){
		$this->login_model->logout();
		redirect('login');
	}
		
}


/* End of file login.php */
/* Location: ./modules/enterprise/controllers/login.php */
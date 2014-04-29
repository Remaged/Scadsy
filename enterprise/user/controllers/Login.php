<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The module-login controller, handles the login and logout requests.
 */
class Login extends SCADSY_Controller{
	protected $data = array();
	
	public function __construct() {			
		parent::__construct(); 
		$this->load->model('login_model');
	}
	
	/**
	 * Default action. When user not logged in this results in a login form. Otherwise a succes page will be shown.
	 */
	public function index() {
		$validate_login = $this->login_model->validate_login(); 
		if($this->user->is_logged_in() || $validate_login === TRUE){
			//redirect('welcome/welcome/index');
			redirect(site_url());
		}		
		else{
			$this->data['failed_message'] = $validate_login;
			$this->data['schools'] = $this->login_model->get_databases();
			$this->view('login_form',$this->data,'template/header_without_menu');
		}
	}
	
	
	
	/**
	 * Login for the admin
	 */
	public function admin() {
		$validate_login = $this->login_model->validate_login(TRUE); 
		if($this->user->is_logged_in() || $validate_login === TRUE){
			//redirect('welcome/welcome/index');
			redirect(site_url());
		}		
		else{
			$this->data['failed_message'] = $validate_login;
			$this->view('login_form_admin',$this->data,'template/header_without_menu');
		}
	}
	
	
	/**
	 * Sets rules for the login form validation.
	 */
	private function _validate_login(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username','required|trim|xss_clean');				
		$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
		if($this->form_validation->run() === FALSE){
			return FALSE;
		}
		
		$u = new User();
		$u->username = $this->input->post('username');
		$u->password = $this->input->post('password');
		if($u->login() === FALSE){
			$this->data['failed_message'] = '<div id="login_failed">The username or password was not correct.</div>';
			return FALSE;
		}
		return TRUE;		
	}
	
	
	/**
	 * Logs out user
	 */
	public function logout(){
		$this->login_model->logout();
		redirect('user/login');
	}
		
}


/* End of file login.php */
/* Location: ./enterprise/user/controllers/login.php */
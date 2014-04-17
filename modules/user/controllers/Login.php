<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The login controller, handles the login and logout requests.
 */
class Login extends SCADSY_Controller{
	protected $data = array('failed_message'=>'');
	/**
	 * Default action. When user not logged in this results in a login form. Otherwise a succes page will be shown.
	 */
	public function index(){
		if($this->user->user_logged_in() || $this->_validate_login() === TRUE){
			redirect(site_url());
		}		
		else{
			$this->view('login/index',$this->data, 'template/header_without_menu');
		}		
	}
	
	/**
	 * Sets rules for the login form validation.
	 */
	private function _validate_login(){
		$this->load->helper(array('form', 'url'));
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
		$this->user->logout();
		redirect('user/login/index');
	}
		
}


/* End of file login.php */
/* Location: ./models/user/controllers/login.php */
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
		if($this->session->userdata('id') || $this->_validate_login() === TRUE){
			$this->view('login/succes');
		}		
		else{
			$this->view('login/index',$this->data);
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
		if($this->user_model->login() === FALSE){
			$this->data['failed_message'] = '<div id="login_failed">The username or password was not correct.</div>';
			return FALSE;
		}
		return TRUE;
		
	}
	
	/**
	 * Logs out user
	 */
	public function logout(){
		$this->user_model->logout();
		$this->load->view('login/logout');
	}
		
}


/* End of file login.php */
/* Location: ./application/controllers/login.php */
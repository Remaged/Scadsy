<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends SCADSY_Controller{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	function index()
	{
		if($this->session->userdata('logged_in') OR $this->validate_login() === TRUE)
		{
			$this->view('succes');
		}		
		else
		{
			$this->view();	
		}		
	}
	
	
	public function validate_login(){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username');				
		$this->form_validation->set_rules('password', 'Password', 'callback_password_check');
		return $this->form_validation->run();
	}
	
	public function password_check($str){
		if($this->user_model->login_user())
		{
			return TRUE;
		}
		$this->form_validation->set_message('password_check', 'The username or password was not correct.');
		return FALSE;
	}
	
	
	public function logout(){
		$this->user_model->logout_user();
		$this->view('logout');
	}
	
	
	public function view($page = 'index')
	{
		if ( ! file_exists('application/views/login/'.$page.'.php'))
		{
			show_404();
		}
	
		$data['title'] = ucfirst($page); // Capitalize the first letter
	
		//$this->load->view('templates/header', $data);
		$this->load->view('login/'.$page.'.php', $data);
		//$this->load->view('templates/footer', $data);
	
	}
	
}


/* End of file login.php */
/* Location: ./application/controllers/login.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends SCADSY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		parent::init(array(
			'module' => "welcome",
			'action' => "index",
			'group' => array('student','school','admin')
			)
		);
		
		/*
		//$user = new User();
		echo $this->user->get_logged_in_user()->username.' <br />';
		//exit('testexit');
		
		$u = new User(5);
		
		foreach($u AS $user){
			echo $user->username.' <br />';
		}
		
		var_dump($u->exists());

		
		exit("....exit....");
		*/
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$data['menu'] = $this->menu_manager->get_menu();
		$this->view('welcome_message', $data);
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
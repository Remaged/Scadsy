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
		
		$this->menu_manager->add_menu_item('welcome/hoi', 'HOI');
		$this->menu_manager->add_menu_item('welcome/doei', 'Doei');
		
		$data['menu'] = $this->menu_manager->get_menu();
		
		$this->load->view('welcome_message', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
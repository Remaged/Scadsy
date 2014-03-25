<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The registration controller, handles the registration form.
 */
class Registration extends SCADSY_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('registration_model');
	}
	
	/**
	 * Default action. Either results in the registration form (first load or failed submit) or a succes page.
	 */
	function index(){
		parent::init(array(
			'module' => "user",
			'controller' => "registration",
			'action' => "index",
			'group' => array('admin')
			)
		);
		
		$this->registration_model->setup_form_validation();	
		if ($this->registration_model->form_validation->run() === FALSE){
			$data['groups'] = $this->registration_model->get_groups();
			$data['ethnicities'] = $this->registration_model->get_ethnicities();		
			$data['languages'] = $this->registration_model->get_languages();	
			$data['grades'] = $this->registration_model->get_grades();		
			$this->template_manager->add_module_script('registration_form','modules/user/assets/scripts/registration_form_handler.js','user',TRUE);	
			$this->view('registration/index',$data);
		}
		else{
			$this->user_model->add_user();	
			$this->view('registration/succes');
		}
	}
	
}

/* End of file registration.php */
/* Location: ./models/user/controllers/registration.php */
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The registration controller, handles the registration form.
 */
class Registration extends SCADSY_Controller{
	
	protected $data = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('registration_model');
	}
	
	/**
	 * Default action. Either results in the registration form (first load or failed submit) or a succes page.
	 */
	public function index(){
		parent::init(array(
			'module' => "user",
			'controller' => "registration",
			'action' => "index",
			'group' => array('admin')
			)
		);
		
		$this->data['errors'] = '';
		if($this->input->post()){
			$user = $this->registration_model->add_user();
			if($user->save()){
				$this->view('registration/succes');
				return;
			}
			else{
				$this->data['errors'] = $user->error->string;
			}
		}
		
		$this->data['groups'] = $this->registration_model->get_groups();
		$this->data['ethnicities'] = $this->registration_model->get_ethnicities();		
		$this->data['languages'] = $this->registration_model->get_languages();	
		$this->data['grades'] = $this->registration_model->get_grades();		
		$this->template_manager->add_module_script('registration_form','modules/user/assets/scripts/registration_form_handler.js','user',TRUE);	
		$this->view('registration/index',$this->data);
	}

	
}

/* End of file registration.php */
/* Location: ./models/user/controllers/registration.php */
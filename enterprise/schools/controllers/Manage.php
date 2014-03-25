<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The module-login controller, handles the login and logout requests.
 */
class Manage extends SCADSY_Controller{
	public function __construct() {			
		parent::__construct(); 
		$this->load->model('school_manager_model');
	}
	
	/**
	 * Default action. When user not logged in this results in a login form. Otherwise a succes page will be shown.
	 */
	public function index() {
		$data['databases'] = $this->school_manager_model->get_databases();	
		$this->view('school_list',$data);
	}
	
	/**
	 * Logs out user
	 */
	public function add(){
		if($this->school_manager_model->submit_data() === TRUE){
			$this->view('school_save_succes');
		}
		else{
			$this->view('school_add');
		}
		
	}
		
}


/* End of file manage.php */
/* Location: ./enterprise/schools/controllers/manage.php */
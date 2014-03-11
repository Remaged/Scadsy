<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Login-module module
 */
class Login_model extends SCADSY_Model {
	
	/**
	 * Gets school-databases, returning them in an array.
	 *
	 * @return
	 * 		associative array in which the key matches the database_name 
	 * 		and the value matches the name of the school.	
	 */
	public function get_databases(){
		return array("scadsy_school_a"=>"A","scadsy_school_b"=>"B");
		$this->logout();
		$rows = Database_manager::get_db()->get('database')->result();
		$result = array();
		foreach($rows as $row){
			$result[$row->name] = $row->school;
		}
		return $result;
	}
	
	/**
	 * Logs out user and unsets the selected school-database.
	 */
	public function logout(){
		$this->user_model->logout();
		$this->load->helper('cookie');
		delete_cookie("scadsy_db_cookie");
	}
	
	/**
	 * Tries to login
	 * @return
	 * 		TRUE if succesfull
	 * 		string with error-message if failed.
	 */
	public function validate_login(){		
		$this->database_manager->set_db($this->input->post('school'));
		$this->setup_form_validation();	
		
		if($this->form_validation->run() === FALSE){
			return '';
		}
		if($this->user_model->login() === FALSE){
			return '<div id="login_failed">The username or password was not correct.</div>';
		}
		return TRUE;
	}
	
	/**
	 * Sets rules for the login form validation.
	 */
	public function setup_form_validation(){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('school', 'School', 'required|trim|xss_clean'); 
		$this->form_validation->set_rules('username', 'Username','required|trim|xss_clean');				
		$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');	
	}	
	
}


/* End of file login_model.php */
/* Location: ./modules/login/models/Login_model.php */
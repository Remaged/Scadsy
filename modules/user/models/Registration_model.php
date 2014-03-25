<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Registration_model extends SCADSY_Model {
	
	/**
	 * Gets all existing groups, returning them in an array of objects.
	 *
	 * @return
	 * 		array of all groups as objects.
	 */
	public function get_groups(){
		return Database_manager::get_db()->get('group')->result();
	}
	
	/**
	 * Gets all existing etnicities, returning them in an array of objects.
	 *
	 * @return
	 * 		array of objects
	 */
	public function get_ethnicities(){
		return Database_manager::get_db()->get('ethnicity')->result();
	}
	
	/**
	 * Gets all existing languages, returning them in an array of objects.
	 *
	 * @return
	 * 		array of objects
	 */
	public function get_languages(){
		return Database_manager::get_db()->get('language')->result();
	}
	
	/**
	 * Gets all existing grades, returning them in an array of objects.
	 *
	 * @return
	 * 		array of objects
	 */
	public function get_grades(){
		return Database_manager::get_db()->get('grade')->result();
	}
	
	/**
	 * Sets rules for the registration form validation.
	 */
	public function setup_form_validation(){
		//$query = Database_manager::get_db()->query("SELECT * FROM (`user`) WHERE `email` = 'marc@student.scadsy.co.za' LIMIT 1");
		//print_r($query); exit();
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		//required			
		$this->form_validation->set_rules('first_name', 'First name', 'required|trim|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last name', 'required|trim|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'matches[password]|trim|xss_clean');
		$this->form_validation->set_rules('group', 'Group', 'required|trim|xss_clean');
		$this->form_validation->set_rules('gender', 'Gender', 'required|trim|xss_clean');	
		$this->form_validation->set_rules('language', 'Language', 'required|trim|xss_clean');
		$this->form_validation->set_rules('ethnicity', 'Ethnicity', 'required|trim|xss_clean');
		//required and unique
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]|trim|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|trim|xss_clean');				
		//grade is only required for students
		if($this->input->post('group') == 'students'){
			$this->form_validation->set_rules('grade', 'Grade', 'required|trim|xss_clean');
		}
		//start_date is only required for students and teachers
		if(($this->input->post('group') == 'students' || $this->input->post('group') == 'teachers')){
			$this->form_validation->set_rules('start_date', 'Start date', 'required|trim|xss_clean');
		}
		//optional
		$this->form_validation->set_rules('end_date', 'End date','trim|xss_clean');
		$this->form_validation->set_rules('alternate_id', 'Alternate ID','trim|xss_clean');
		$this->form_validation->set_rules('middle_name', 'Middle name','trim|xss_clean');
		$this->form_validation->set_rules('date_of_birth', 'Date of birth','trim|xss_clean');
		$this->form_validation->set_rules('phone_number', 'Phone number','trim|xss_clean');	 
	}
	
	
}


/* End of file registration_model.php */
/* Location: ./modules/user/models/registration_model.php */
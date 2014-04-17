<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Registration_model extends SCADSY_Model {
	
	/**
	 * Gets all existing groups, returning them in an array of objects.
	 *
	 * @return
	 * 		array of all groups as objects.
	 */
	public function get_groups(){
		return Database_manager::get_db()->get('groups')->result();
	}
	
	/**
	 * Gets all existing etnicities, returning them in an array of objects.
	 *
	 * @return
	 * 		array of objects
	 */
	public function get_ethnicities(){
		return Database_manager::get_db()->get('ethnicities')->result();
	}
	
	/**
	 * Gets all existing languages, returning them in an array of objects.
	 *
	 * @return
	 * 		array of objects
	 */
	public function get_languages(){
		return Database_manager::get_db()->get('languages')->result();
	}
	
	/**
	 * Gets all existing grades, returning them in an array of objects.
	 *
	 * @return
	 * 		array of objects
	 */
	public function get_grades(){
		return Database_manager::get_db()->get('grades')->result();
	}

	/**
	 * Creates a user-object by using all post-data.
	 * 
	 * @return
	 * 		user-object.
	 */
	public function add_user(){
		$user = new User();
		$user->username = $this->input->post('username');
		$user->password = $this->input->post('password');
		$user->password_confirm = $this->input->post('password_confirm');
		$user->email = $this->input->post('email');
		$user->first_name = $this->input->post('first_name');
		$user->middle_name = $this->input->post('middle_name');
		$user->last_name = $this->input->post('last_name');
		$user->gender = $this->input->post('gender');
		$user->group_id = $this->input->post('group_id');
		$user->language_id = $this->input->post('language_id');
		$user->ethnicity_id = $this->input->post('ethnicity_id');
		$user->grade_id = $this->input->post('grade_id');
		$user->start_date = $this->input->post('start_date');
		$user->end_date = $this->input->post('end_date');
		$user->alternate_id = $this->input->post('alternate_id');
		$user->date_of_birth = $this->input->post('date_of_birth');
		$user->phone_number = $this->input->post('phone_number');
		
		return $user;
	}
	
	
}


/* End of file registration_model.php */
/* Location: ./modules/user/models/registration_model.php */
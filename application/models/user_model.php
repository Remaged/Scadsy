<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends SCADSY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}
	
	/**
	 * add_user
	 *
	 * Adds a new user into the database, using the POST-data of the registration form
	 */
	public function add_user(){
		$data = array(
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email'),
			'group_key' => $this->input->post('group'),
			'first_name' => $this->input->post('first_name'),
			'middle_name' => $this->input->post('middle_name'),
			'last_name' => $this->input->post('last_name'),
			'phone_number' => $this->input->post('phone_number'),
			'date_of_birth' => $this->input->post('date_of_birth'),
			'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
		);
		Database_manager::get_db()->trans_start();		
		Database_manager::get_db()->insert('user', $data);
		$this->add_group_user();
		Database_manager::get_db()->trans_complete();
	}
	
	/**
	 * Gets user-data of the logged in user.
	 * @return
	 * 		object containing user-data
	 * 		or NULL if user is not logged in.
	 */
	public function get_logged_in_user(){
		
		if($this->user_logged_in() === TRUE){
			return Database_manager::get_db()->get_where('user',array('id'=>$this->session->userdata('id')),1)->row();
		}
		else{
			return NULL;
		}
	}
	
	/**
	 * Gets the group the user is in.
	 * @return	
	 * 		string containing the group-name
	 * 		or NULL if user is not logged in.
	 */
	public function get_group(){
		if($this->user_logged_in() === TRUE){
			return Database_manager::get_db()->select('group_key')->get_where('user',array('id'=>$this->session->userdata('id')),1)->row()->group_key;
		}
		else{
			return NULL;
		}
	}
	
	/**
	 * checks if the user is logged in.
	 * @return
	 * 		TRUE if user is logged in (the id-session of the user is stored).
	 * 		FALSE if the user is not logged in.
	 */
	public function user_logged_in(){
		if($this->session->userdata('id')){
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Adds a group_user (student, teacher or parent) to the database.
	 */
	public function add_group_user(){
		if($this->input->post('group') == 'students'){
			$this->add_student();
		}
		elseif($this->input->post('group') == 'teachers'){
			$this->add_teacher();
		}
		elseif($this->input->post('group') == 'parents'){
			$this->add_parent();
		}
	}
	
	/**
	 * Adds a student and enrollment_information to the database for the currently added user.
	 */
	public function add_student(){				
		$user_id = Database_manager::get_db()->insert_id(); 
		$data_student = array(
			'id' => $this->input->post('student_id'),
			'alternate_id' => $this->input->post('alternate_id'),
			'user' => $user_id,
			'grade' => $this->input->post('grade')		
		);	
		Database_manager::get_db()->insert('student', $data_student);
		
		$data_enrollment = array(
			'student' => $this->input->post('student_id'),
			'start_date' => $this->input->post('start_date'),
			'end_date' => $this->input->post('end_date')		
		);	
		Database_manager::get_db()->insert('enrollment_information', $data_enrollment);
	}
	
	/**
	 * Adds a parent to the database, linked to the currently added user.
	 */
	public function add_parent(){
		$user_id = Database_manager::get_db()->insert_id(); 
		Database_manager::get_db()->insert('parent', array('user'=>$user_id));
	}
	
	/**
	 * Adds a teacher to the database, linked to the currently added user.
	 */
	public function add_teacher(){
		$user_id = Database_manager::get_db()->insert_id(); 
		$data = array(
			'user' => $user_id,
			'start_date' => $this->input->post('start_date')			
		);	
		Database_manager::get_db()->insert('teacher', $data);
	}	
	
	/**
	 * Ends session-data for the current logged in user. 
	 */
	public function logout(){
		$user_session_data = array(
			'id'=>''
    	);
		$this->session->unset_userdata($user_session_data);
		Database_manager::disconnect();
	}

	/**
	 * Tries to log in a user by using provided POST-data and validating the username/email + password
	 * returns FALSE if login unsuccesfull (no user found or password invalid).
	 * Otherwise stores user-data in sessions and return TRUE.
	 */
	public function login(){	
		$query = Database_manager::get_db()->get_where('user',array('username'=>$this->input->post('username')));
		/*
		if($query->num_rows() == 0 || $query->row()->password != $this->get_hashed_password($this->input->post('password'),$query->row()->password_salt))
		{
			return FALSE;
		}	
		 */
		if($query->num_rows() == 0 || password_verify($this->input->post('password'),$query->row()->password) === FALSE){
			return FALSE; 	
		} 	

		$newdata = array(
			'id'=>$query->row()->id
    	);
		$this->session->set_userdata($newdata);
		return TRUE;
	}	
}


/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
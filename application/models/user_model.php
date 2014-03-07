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
		$salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);	
		$hashed_password = $this->get_hashed_password($this->input->post('password'),$salt);
		
		$data = array(
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email'),
			'group_key' => $this->input->post('group'),
			'first_name' => $this->input->post('first_name'),
			'middle_name' => $this->input->post('middle_name'),
			'last_name' => $this->input->post('last_name'),
			'phone_number' => $this->input->post('phone_number'),
			'date_of_birth' => $this->input->post('date_of_birth'),
			'password' => $hashed_password,
			'password_salt' => $salt 
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
		if(user_logged_in() === TRUE){
			return Database_manager::get_db()->get_where('user',array('id'=>$this->session->userdata('id')))->row();
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
	 * Hashes a provided password, using the 'SHA512' hash and the provided salt.
	 * Returns the hashed password.
	 *
	 * @param	password
	 * 		The password to be hashed
	 * @param	salt
	 * 		salt to use in the hashing
	 * @return
	 * 		hashed password
	 */
	public function get_hashed_password($password,$salt){
		if (CRYPT_SHA512 != 1) {
			exit("The server doesn't seem to support the required hashing algorithm. Please contact the administrator");
		}
		$hashString = crypt($password, '$6$rounds=5005$'.$salt);
		$hash_explode = explode($salt,$hashString);

		return $hash_explode[1];
	}
	
	
	/**
	 * Ends session-data for the current logged in user. 
	 */
	public function logout(){
		$user_session_data = array(
			'id'=>''
    	);
		$this->session->unset_userdata($user_session_data);
	}

	/**
	 * Tries to log in a user by using provided POST-data and validating the username/email + password
	 * returns FALSE if login unsuccesfull (no user found or password invalid).
	 * Otherwise stores user-data in sessions and return TRUE.
	 */
	public function login(){
		$query = Database_manager::get_db()->get_where('user',array('username'=>$this->input->post('username')));

		if($query->num_rows() == 0 || $query->row()->password != $this->get_hashed_password($this->input->post('password'),$query->row()->password_salt))
		{
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
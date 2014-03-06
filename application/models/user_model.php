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
		$this->db->trans_start();		
		$this->db->insert('user', $data);
		$this->add_group_user();
		$this->db->trans_complete();
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
		$user_id = $this->db->insert_id(); 
		$data_student = array(
			'id' => $this->input->post('student_id'),
			'alternate_id' => $this->input->post('alternate_id'),
			'user' => $user_id,
			'grade' => $this->input->post('grade')		
		);	
		$this->db->insert('student', $data_student);
		
		$data_enrollment = array(
			'student' => $this->input->post('student_id'),
			'start_date' => $this->input->post('start_date'),
			'end_date' => $this->input->post('end_date')		
		);	
		$this->db->insert('enrollment_information', $data_enrollment);
	}
	
	/**
	 * Adds a parent to the database, linked to the currently added user.
	 */
	public function add_parent(){
		$user_id = $this->db->insert_id(); 
		$this->db->insert('parent', array('user'=>$user_id));
	}
	
	/**
	 * Adds a teacher to the database, linked to the currently added user.
	 */
	public function add_teacher(){
		$user_id = $this->db->insert_id(); 
		$data = array(
			'user' => $user_id,
			'start_date' => $this->input->post('start_date')			
		);	
		$this->db->insert('teacher', $data);
	}
		
	/**
	 * get_hashed_password
	 *
	 * Hashed a provided password, using the 'SHA512' hash and the provided salt.
	 * Returns the hashed password.
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	string
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
	 * check_email_exists
	 *
	 * checks if the provided email already exists for any users.
	 * returns TRUE if email exists, FALSE if not. 
	 *
	 * @access	public
	 * @param	string
	 * @return	boolean
	 */
	public function check_email_exists($email){
		$this->db->where("email",$email);
		if($this->db->count_all_results('user') === 0){
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * check_student_id_exists
	 *
	 * checks if the provided student id already exists for any student.
	 * returns TRUE if student id exists, FALSE if not. 
	 *
	 * @access	public
	 * @param	string
	 * @return	boolean
	 */
	public function check_student_id_exists($student_id){
		$this->db->where("id",$student_id);
		if($this->db->count_all_results('student') === 0){
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * logout_user
	 *
	 * Ends session-data for the current logged in user. 
	 *
	 * @access	public
	 * @return	void
	 */
	public function logout(){
		$user_session_data = array(
			'id'=>''
    	);
		$this->session->unset_userdata($user_session_data);
	}

	/**
	 * login_user
	 *
	 * Tries to log in a user by using provided POST-data and validating the username/email + password
	 * returns FALSE if login unsuccesfull (no user found or password invalid).
	 * Otherwise stores user-data in sessions and return TRUE.
	 *
	 * @access	public
	 * @return	boolean
	 */
	public function login(){
		$query = $this->db->get_where('user',array('username'=>$this->input->post('username')));

		if($query->num_rows() == 1 || $query->row()->password != $this->get_hashed_password($this->input->post('password'),$query->row()->password_salt))
		{
			return FALSE;
		}		
		$newdata = array(
			'id'=>$userdata->id
    	);
		$this->session->set_userdata($newdata);
		return TRUE;
	}	
}


/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
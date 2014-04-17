<?php

class User extends DataMapper {

	var $table = 'users';
	var $CI;
	
    var $has_one = array('parent','student','teacher','language','grade','group','etnicity');
	var $auto_populate_has_one = TRUE;

    var $validation = array(
        array(
        	'field' => 'username',
            'label' => 'Username',
            'rules' => array('required', 'trim', 'xss_clean', 'unique', 'alpha_dash', 'min_length' => 3, 'max_length' => 20),
        ),
        'password_confirm' => array(
            'label' => 'Confirm Password',
            'rules' => array('required', 'xss_clean', 'matches' => 'password'),
        ),
        'password' => array(
            'label' => 'Password',
            'rules' => array('required', 'xss_clean', 'min_length' => 6, 'encrypt'),
        ),       
        'email' => array(
            'label' => 'Email Address',
            'rules' => array('required', 'xss_clean', 'trim', 'valid_email')
        )
		,
        'first_name' => array(
            'label' => 'First name',
            'rules' => array('required', 'xss_clean', 'trim')
        ),
        'last_name' => array(
            'label' => 'Last name',
            'rules' => array('required', 'xss_clean', 'trim')
        ),
        'middle_name' => array(
            'label' => 'Middle name',
            'rules' => array('xss_clean', 'trim')
        ),
        'gender' => array(
            'label' => 'Gender',
            'rules' => array('required','xss_clean', 'trim')
        ),
        'group_id' => array(
            'label' => 'Group',
            'rules' => array('required','xss_clean', 'trim')
        ),
        'language_id' => array(
            'label' => 'Language',
            'rules' => array('required','xss_clean', 'trim')
        ),
        'ethnicity_id' => array(
            'label' => 'Ethnicity',
            'rules' => array('required','xss_clean', 'trim')
        ),
        'start_date' => array(
            'label' => 'Start date',
            'rules' => array('xss_clean', 'trim','required_for_student','required_for_teacher')
        ),
		'end_date' => array(
            'label' => 'End date',
            'rules' => array('xss_clean', 'trim')
        ),
		'date_of_birth' => array(
            'label' => 'Date of birth',
            'rules' => array('xss_clean', 'trim')
        ),
		'phone_number' => array(
            'label' => 'Phone number',
            'rules' => array('xss_clean', 'trim')
        )
    );
	
	function __construct($id = NULL)
    {
        parent::__construct($id);
		$this->CI =& get_instance();
		$this->CI->load->library('session');
    }

	

	// Validation function to make field required if group is student. 
	function _required_for_student($field)
	{
		$group = new Group($this->group_id);
	    if ($group->name == 'student' && empty($this->{$field}))
	    {
	    	$this->error_message($field.'_required_for_student', 'The '.$this->validation[$field]['label'].' field is required for students.');
	        return FALSE;
	    }
	    return TRUE;
	}
	// Validation function to make field required if group is teacher. 
	function _required_for_teacher($field)
	{
		$group = new Group($this->group_id);
	    if ($group->name == 'teacher' && empty($this->{$field}))
	    {
	    	$this->error_message($field.'_required_for_teacher', 'The '.$this->validation[$field]['label'].' field is required for teachers.');
	        return FALSE;
	    }
	    return TRUE;
	}
	
	/**
	 * Extends parents save-functionality. 
	 * Adds a record in students when group is student. 
	 * Adds a record in parents when group is parent.  
	 */
	function save(){
		Database_manager::get_db()->trans_start();	
		if( ! parent::save() ){
			return FALSE;
		}
		if($this->group->name == 'student'){					
			$student = new Student();
			$student->user_id = $this->id;
			$student->alternate_id = $this->alternate_id;
			$student->grade_id = $this->grade_id;
			if( !$student->save() ){
				$this->error->string .= $student->error->string;
				return FALSE;
			}
		}
		elseif($this->group->name == 'parent'){
			$parent = new Parent();
			$parent->user_id = $this->id;
			if( !$parent->save() ){
				$this->error->string .= $parent->error->string;
				return FALSE;
			}
		}
		Database_manager::get_db()->trans_complete();
		return TRUE;
	}
	
	
	/**
	 * Tries to log in a user by using provided POST-data and validating the username/email + password
	 * returns FALSE if login unsuccesfull (no user found or password invalid).
	 * Otherwise stores user-data in sessions and return TRUE.
	 */
	public function login(){
        $u = new User();
        $u->where('username', $this->username)->get();
		
		if($u->exists() === FALSE || password_verify($this->password,$u->password) === FALSE){
			return FALSE; 	
		} 		
		$newdata = array('id'=>$u->id);
		$this->CI->session->sess_destroy();
		$this->CI->session->sess_create();
		$this->CI->session->set_userdata($newdata);
		return TRUE;
	}	

    /**
	 * Validation prepping function to encrypt passwords
     * If you look at the $validation array, you will see the password field will use this function
	 */ 
    function _encrypt($field)
    {
    	$this->{$field} = password_hash($field, PASSWORD_DEFAULT);
    }
	
	/**
	 * Ends session-data for the current logged in user. 
	 */
	public function logout(){
		$user_session_data = array(
			'id'=>''
    	);
		$this->CI->session->unset_userdata($user_session_data);
		Database_manager::disconnect();
	}
	
	/**
	 * checks if the user is logged in.
	 * @return
	 * 		TRUE if user is logged in (the id-session of the user is stored).
	 * 		FALSE if the user is not logged in.
	 */
	public function user_logged_in(){
		if($this->CI->session->userdata('id')){
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Gets the group the user is in.
	 * @return	
	 * 		string containing the group-name
	 * 		or NULL if user is not logged in.
	 */
	public function get_group(){
		if($this->user_logged_in() === TRUE){
			return $this->get_logged_in_user()->group->name;
		}
		else{
			return NULL;
		}
	}
	
	/**
	 * Gets user-data of the logged in user.
	 * @return
	 * 		object containing user-data
	 * 		or NULL if user is not logged in.
	 */
	public function get_logged_in_user(){
		
		if($this->user_logged_in() === TRUE){
			$u = new User($this->CI->session->userdata('id'));
			return $u;
		}
		else{
			return NULL;
		}
	}
}

/* End of file user.php */
/* Location: ./application/models/user.php */
<?php

class User extends DataMapper {

	var $table = 'users';
	var $CI;
	
    var $has_one = array('student','language','ethnicity');
	var $auto_populate_has_one = TRUE;
	
	var $has_many = array('group');

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
        'language_id' => array(
            'label' => 'Language',
            'rules' => array('required','xss_clean', 'trim')
        ),
        'ethnicity_id' => array(
            'label' => 'Ethnicity',
            'rules' => array('required','xss_clean', 'trim')
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

	/**
	 * Overrides parent-constructor, making it possible to directly get the user-object
	 * based on it's unique-key, using it username
	 */
	public function __construct($id = NULL) {
		if(is_string($id) === TRUE){
			parent::__construct(NULL); 
			$this->get_where(array('username'=>$id),1); 
		}
		else{
			parent::__construct($id); 
		}
		$this->CI =& get_instance();
		$this->CI->load->library('session');		
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
			$this->error_message('login', 'The username or password is invalid.');
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
    	$this->$field = password_hash($this->{$field}, PASSWORD_DEFAULT);
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
	public function is_logged_in(){
		if($this->CI->session->userdata('id')){
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Gets the user that is currently logged in.
	 */
	public function get_by_logged_in(){
		if($this->is_logged_in() === TRUE){
			$this->get_where(array('id'=>$this->CI->session->userdata('id')),1);
		}
		return $this;
	}
}

/* End of file user.php */
/* Location: ./application/models/user.php */
<?php

class User extends DataMapper {

    //var $has_many = array('book');
    //var $has_one = array('country');

    var $validation = array(
        'username' => array(
            'label' => 'Username',
            'rules' => array('required', 'trim', 'unique', 'alpha_dash', 'min_length' => 3, 'max_length' => 20),
        ),
        'password' => array(
            'label' => 'Password',
            'rules' => array('required', 'min_length' => 6, 'encrypt'),
        ),
        'confirm_password' => array(
            'label' => 'Confirm Password',
            'rules' => array('required', 'encrypt', 'matches' => 'password'),
        ),
        'email' => array(
            'label' => 'Email Address',
            'rules' => array('required', 'trim', 'valid_email')
        )
    );
	
	
	/**
	 * Tries to log in a user by using provided POST-data and validating the username/email + password
	 * returns FALSE if login unsuccesfull (no user found or password invalid).
	 * Otherwise stores user-data in sessions and return TRUE.
	 */
	public function login(){
        $u = new User();
        $u->where('username', $this->username)->get();
	
		if($u->exists() === FALSE || password_verify($this->input->post('password'),$u->password) === FALSE){
			return FALSE; 	
		} 	

		$newdata = array('id'=>$u->id);
		
		$this->session->set_userdata($newdata);
		return TRUE;
	}	

    // Validation prepping function to encrypt passwords
    // If you look at the $validation array, you will see the password field will use this function
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
		$this->session->unset_userdata($user_session_data);
		Database_manager::disconnect();
	}
}

/* End of file user.php */
/* Location: ./application/models/user.php */
<?php

class Sms extends DataMapper {
	var $has_many = array(
		'user' => array(
            'class' => 'user',
            'other_field' => 'sms',           
            'join_self_as' => 'sms',
            'join_other_as' => 'user',
            'join_table' => 'sms_users'
        )
	);	
	
	var $has_one = array(
		'sender' => array(
            'class' => 'user',
            'other_field' => 'sent_sms',           
            'join_self_as' => 'sms',
            'join_other_as' => 'user',
            'join_table' => 'sms'
        )
	);

	var $validation = array(		
        'message' => array(
            'label' => 'Message',
            'rules' => array('xss_clean', 'trim','required')
        )
	);
	
	
	public function create_user_relation($user = NULL){
		$user = $user === NULL ? $this->user : $user;
		$user->has_many('sms', array(
				'class' => 'sms',
				'join_self_as' => 'user',
				'join_other_as' => 'sms',
				'join_table' => 'sms_users',
				'other_field' => 'user'
			)
		);
	}	
	
}

/* End of file sms.php */
/* Location: ./modules/sms/models/sms.php */
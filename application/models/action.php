<?php

class Action extends DataMapper {

	var $table = 'actions';

    var $has_one = array('module');
	var $has_many = array('permission');
	var $auto_populate_has_one = TRUE;

    var $validation = array(
        'name' => array(
            'label' => 'Name',
            'rules' => array('required', 'trim', 'xss_clean', 'unique'),
        ),
        'controller' => array(
            'label' => 'uri',
            'rules' => array('required', 'xss_clean', 'trim', 'unique'),
        )
    );

}

/* End of file action.php */
/* Location: ./application/models/action.php */
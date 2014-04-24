<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update extends DataMapper {

    var $table = 'updates';
	var $CI;
	
    var $has_one = array('module');
	var $auto_populate_has_one = TRUE;

    var $validation = array(
        'module_id' => array(
            'label' => 'Module',
            'rules' => array('required', 'trim', 'xss_clean', 'unique'),
        ),
        'last_checked' => array(
            'label' => 'Last Checked',
            'rules' => array('xss_clean'),
        ),
        'has_update' => array(
            'label' => 'Has Update',
            'rules' => array('required', 'xss_clean'),
        ),       
        'to_version' => array(
            'label' => 'To Version',
            'rules' => array('xss_clean', 'min_length' => 1, 'max_length' => 49)
        )
    );
	
	/**
	 * Constructor: calls parent constructor
	 */
    function __construct($id = NULL)
	{
		parent::__construct($id);
    }
}

/* End of file Update.php */
/* Location: ./modules/update/views/Update.php */
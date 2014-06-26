<?php

class Enrollment extends DataMapper {

    var $has_one = array('student','group');
	var $auto_populate_has_one = TRUE;
	
	var $validation = array(		
		'start_date' => array(
            'label' => 'Start date',
            'rules' => array('xss_clean', 'trim','required')
        ),
		'end_date' => array(
            'label' => 'End date',
            'rules' => array('xss_clean', 'trim')
        )
	);

}

/* End of file enrollment.php */
/* Location: ./application/models/enrollment.php */
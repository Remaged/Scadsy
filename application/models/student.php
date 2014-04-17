<?php

class Student extends DataMapper {

    var $has_one = array('user');
	var $auto_populate_has_one = TRUE;
	
	var $validation = array(		
        'grade_id' => array(
            'label' => 'Grade',
            'rules' => array('xss_clean', 'trim','required')
        ),
		'alternate_id' => array(
            'label' => 'Alternate ID',
            'rules' => array('xss_clean', 'trim')
        )
	);
	
}

/* End of file student.php */
/* Location: ./application/models/student.php */
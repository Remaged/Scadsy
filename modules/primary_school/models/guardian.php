<?php

class Guardian extends DataMapper {
    var $has_one = array('user');
	var $auto_populate_has_one = TRUE;
	var $has_many = array('student');	
}

/* End of file guardian.php */
/* Location: ./application/models/guardian.php */
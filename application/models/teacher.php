<?php

class Teacher extends DataMapper {

    var $has_one = array('user');
	var $auto_populate_has_one = TRUE;

}

/* End of file teacher.php */
/* Location: ./application/models/teacher.php */
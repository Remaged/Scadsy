<?php

class Parent extends DataMapper {

    var $has_one = array('user');
	var $has_many = array('student');
	var $auto_populate_has_one = TRUE;

}

/* End of file parent.php */
/* Location: ./application/models/parent.php */
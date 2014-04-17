<?php

class Group extends DataMapper {
	
	var $table = 'groups';
    var $has_many = array('user');

}

/* End of file group.php */
/* Location: ./application/models/group.php */
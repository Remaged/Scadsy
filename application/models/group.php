<?php

class Group extends DataMapper {
	
	var $table = 'groups';
    var $has_many = array('user','permission');
	
	/**
	 * Overrides parent-constructor, making it possible to directly get the object based on it's unique-key: name
	 */
	public function __construct($id = NULL) {
		if(is_string($id) === TRUE){
			parent::__construct(NULL); 
			$this->get_where(array('name'=>$id),1);   
			return;
		}
		parent::__construct($id);
	}

}

/* End of file group.php */
/* Location: ./application/models/group.php */
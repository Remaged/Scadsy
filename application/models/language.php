<?php

class Language extends DataMapper {

    var $has_many = array('user');
	
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

/* End of file language.php */
/* Location: ./application/models/language.php */
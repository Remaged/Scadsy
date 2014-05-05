<?php

class Group extends DataMapper {
	
	var $table = 'groups';
    //var $has_many = array('user','permission');
	var $join_prefix = "";
	var $has_many =array(
		'user',
		'permission', 
		'child_group' => array(
            'class' => 'group',
            'join_table' => 'groups_groups',
            'join_self_as' => 'parent_group',
            'join_other_as' => 'child_group',
            'other_field' => 'parent_group'
        ),
        'parent_group' => array(
        	'class' => 'group',
        	'join_table' => 'groups_groups',
        	'join_self_as' => 'child_group',
        	'join_other_as' => 'parent_group',
            'other_field' => 'child_group'
        )
    );
	
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
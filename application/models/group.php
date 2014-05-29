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
	
	var $validation = array(
        'name' => array(
            'label' => 'Name',
            'rules' => array('required', 'trim', 'xss_clean', 'unique'),
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
	
	 /**
	  * Gets all childgroups (including further descendants) and their permission.
	  * @param $action_id
	  * 	(optional) action-object (datamapper) to find permissions that match both (child)group and action
	  */
	 public function get_child_groups(&$action = NULL){
	 	$this->child_group->get();
		foreach($this->child_group AS $child_group){
			if($action !== NULL){
				$child_group->permission->get_where(array('action_id'=>$action->id,'group_id'=>$child_group->id),1);
			}
			$child_group->get_child_groups($action);
		}
	 }

}

/* End of file group.php */
/* Location: ./application/models/group.php */
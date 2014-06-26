<?php

class Group extends DataMapper {
	
	var $table = 'groups';
	var $join_prefix = "";
	var $has_many =array(
		'user',
		'enrollment',
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
		if(is_string($id) && !is_numeric($id)){
			parent::__construct(NULL);
			return $this->get_where(array('name'=>$id),1); 
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
	 
	 
	 
	 public function get_ancesters(){
	 	$this->ancester = $this->parent_group->get();
		foreach($this->parent_group AS $parent_group){
			$parent_group->get_ancesters();
			$this->ancester->all = array_merge($parent_group->ancester->all, $this->ancester->all);
		}
		return $this->ancester;
	 }
	 
	 public function get_descendants(){
	 	$this->descendant = $this->child_group->get();
		foreach($this->child_group AS $child_group){
			$child_group->get_descendants();
			$this->descendant->all = array_merge($child_group->descendant->all, $this->descendant->all);
		}
		return $this->descendant;
	 }

}

/* End of file group.php */
/* Location: ./application/models/group.php */
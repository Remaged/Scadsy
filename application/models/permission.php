<?php

class Permission extends DataMapper {

	var $table = 'permissions';

    var $has_one = array('action','group');
	var $auto_populate_has_one = TRUE;

    var $validation = array(
        'allowed' => array(
            'label' => 'Allowed',
            'rules' => array('integer','greater_than[0]','less_than[1]'),
        )
    );
	
	/**
	 * Overrides parent-constructor, making it possible to directly get the permission-object
	 * based on it's unique-key, using natural names only (no id's):
	 * module_directory, controller_name, action_name, group_name
	 */
	public function __construct($id = NULL) {
        parent::__construct($id); 
        $args = func_get_args(); 			
		if(count($args) == 4){
			$this->get_by_unique($args[0],$args[1],$args[2],$args[3]);
		}
	}
	
	/**
	 * get-function by using its 'natural' keys, thus using names instead of id's.
	 * @param $module_directory
	 * 		The directory-name of the module
	 * @param $action_controller
	 * 		The name of the controller the action belongs to
	 * @param $action_name
	 * 		The name of the action the permission applies to
	 * @param $group_name
	 * 		The name of the group the permission applies to	 
	 * @return 
	 * 		the current permission-object or NULL if permission doesn't exist.
	 */
	public function get_by_unique($module_directory, $controller_name, $action_name, $group_name){
		$action = new Action();
		$action->get_by_unique($module_directory, $controller_name, $action_name);
		$group = new Group();
		$group->get_where(array('name'=>$group_name),1);		
		$this->where_related($action)->where_related($group)->get();
		
		if($this->exists()){
			return $this;
		}
		return NULL;
	}
	
	/**
	 * Save
	 * 
	 * Extends the save-method of the parent. If the group of a permission has sub-groups, then the subgroups should be 
	 * saved/changed as well.
	 * Also, if a parent (or ancester) group is allowed, the current group cannot be set to deny. 
	 *
	 * @param	mixed $object Optional object to save or array of objects to save.
	 * @param	string $related_field Optional string to save the object as a specific relationship.
	 * @return	bool Success or Failure of the validation and save.
	 */
	public function save($object = '', $related_field = ''){
		Database_manager::get_db()->trans_start();	
		$succes = parent::save($object, $related_field);
		if($succes === TRUE){
			if($this->allowed == 1){
				$this->save_child_groups_permissions($this->group->child_group->get());
			}
			else{
				$CI =& get_instance();
				$parent_allowed = $CI->permission_manager->group_has_permission(
						$this->action, 
						$this->group->parent_group->get()
					);
				
				if($parent_allowed === TRUE){
					$this->error_message('parent_permission_allowed', 'Cannot deny if parent is allowed');
					Database_manager::get_db()->trans_rollback();
					return FALSE;
				}
			}
		}
		Database_manager::get_db()->trans_complete();
		return $succes;
	} 
	
	/**
	 * Loops through all child-groups to match their allowed-status with the allowed-status of the current permission.
	 * @param $child_groups
	 * 		group-object (datamapper) to set its status the same as the current permission.
	 */
	private function save_child_groups_permissions($child_groups){
		if($child_groups->exists()){
			foreach($child_groups AS $child_group){
				$permission = new Permission();
				$permission->where_related($this->action)->where_related($child_group)->get();
				$permission->allowed = $this->allowed;
				if($permission->exists()){					
					$permission->save();
				}
				else{
					$permission->save(array($this->action,$child_group));
				}
				$this->save_child_groups_permissions($child_group->child_group->get());
			}
		}
	}
	
}

/* End of file permission.php */
/* Location: ./application/models/permission.php */
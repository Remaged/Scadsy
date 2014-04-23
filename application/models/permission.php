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
	 * Get the permission from a certain action
	 * @param $module_directory
	 * 		The directory-name of the module
	 * @param $action_controller
	 * 		The name of the controller the action belongs to
	 * @param $action_name
	 * 		The name of the action
	 * @param $group_name
	 * 		The name of the group
	 * @return
	 * 		The found permission (object) or NULL if no permission could be found.
	 */
	public function get_by_module_action_group($module_directory, $action_controller, $action_name, $group_name) {
		$module = new Module();
		$module		->get_where(array('directory'=>$module_directory),1);	
		
		$action = new Action();
		$action		->where('name',$action_name)
					->where('controller',$action_controller)
					->where('module_id',$module->id)
					->get();
					
		$group = new Group();
		$group 		->get_where(array('name'=>$group_name),1);			
					
		$permission = new Permission();
		$permission	->where('action_id',$action->id)
					->where('group_id',$group->id)
					->get();
		
		if($permission->exists()){
			return $permission;
		}
		return NULL;								
	}

}

/* End of file permission.php */
/* Location: ./application/models/permission.php */
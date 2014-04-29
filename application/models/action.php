<?php

class Action extends DataMapper {

	var $table = 'actions';
    var $has_one = array('module');
	var $has_many = array('permission');
	var $auto_populate_has_one = TRUE;

    var $validation = array(
        'name' => array(
            'label' => 'Name',
            'rules' => array('trim', 'xss_clean'),
        ),
        'controller' => array(
            'label' => 'Controller',
            'rules' => array('required', 'xss_clean', 'trim'),
        )
    );
	
	/**
	 * Overrides parent-constructor, making it possible to directly get the action-object
	 * based on it's unique-key, using natural names only (no id's):
	 * module_directory, controller_name, action_name
	 */
	public function __construct($id = NULL) {
        parent::__construct($id); 
        $args = func_get_args(); 			
		if(count($args) == 3){
			if(empty($args[2])){ $args[2] = NULL; }
			$this->get_by_unique($args[0],$args[1],$args[2]);
		}
	}
	
	/**
	 * Gets an action by it's unique 'natural' key: actions are defined by a module, controller and action. 
	 * Rather than using the module_id, the unique natural key for module is used as well. 
	 * This allows getting an action by using logical names instead of id's.
	 * @param $module_directory
	 * 		the directory name of the module the action belongs to.
	 * @param $controller_name
	 * 		name of the controller the action is in.
	 * @param $action_name
	 * 		name of the action
	 * 
	 */
	public function get_by_unique($module_directory, $controller_name, $action_name){
		$module = new Module($module_directory);
		$this->get_where(array('module_id'=>$module->id,'name'=>$action_name,'controller'=>$controller_name),1);
		return $this;
	}


}

/* End of file action.php */
/* Location: ./application/models/action.php */
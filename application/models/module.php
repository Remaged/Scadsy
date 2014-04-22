<?php

class Module extends DataMapper {

	var $table = 'modules';

    var $has_many = array('action');
	//var $auto_populate_has_one = TRUE;

    var $validation = array(
        array(
        	'field' => 'directory',
            'label' => 'Directory',
            'rules' => array('required', 'trim', 'xss_clean', 'unique', 'alpha_dash'),
        ),
        'name' => array(
            'label' => 'Name',
            'rules' => array('required', 'trim', 'xss_clean', 'unique'),
        ),
        'uri' => array(
            'label' => 'uri',
            'rules' => array('xss_clean', 'trim'),
        ),       
        'description' => array(
            'label' => 'description',
            'rules' => array('xss_clean', 'trim'),
        )
		,
        'author' => array(
            'label' => 'Author',
            'rules' => array('xss_clean', 'trim'),
        ),
        'author_uri' => array(
            'label' => 'Author URI',
            'rules' => array('xss_clean', 'trim'),
        ),
        'status' => array(
            'label' => 'Status',
            'rules' => array('xss_clean', 'trim'),
        )
    );
	
	/**
	 * Get the modules that have a certain status
	 * @param $status
	 * 		The status of the module. Can be 'enabled', 'disabled'or 'all'
	 * @return
	 * 		The found modules
	 */
	public function get_by_status($status = 'all') {
		$modules = new Module();
		if($status == 'enabled' || $status == 'disabled') {
			$modules->get_where(array('status' => $status));
		} else if ($status == 'all') {
			$modules->get();
		}
		else{
			throw new Exception("Invalid status");
		}
		return $modules;
	}
	
	/**
	  * Stores status for all modules.
	  * @param $statusses
	  * 		associative array in which keynames match the module directory names
	  */
	 public function save_statusses($statusses){
	 	Database_manager::get_db()->trans_start();	
		Database_manager::get_db()->update('modules',array('status'=>'disabled'));
		foreach($statusses AS $module_directory => $val){
			$module = new Module();
			$module->get_where(array('directory' => $module_directory),1);
			$module->status = 'enabled';
			$module->save();
		}
		Database_manager::get_db()->trans_complete();
	 }
	 
	 /**
	 * Uninstall a module
	 * @param $directory
	 * 		The directory of the module
	 */
	 public function uninstall($directory) {
	 	$module = new Module();
		$module->get_where(array('directory'=>$directory),1);
		$module->status = 'not_installed';
		$module->save();
	 }
	 
	 /**
	 * Check if a module is active
	 * @param $directory
	 * 		The directory of the module
	 * @return 
	 * 		Whether or not the module is active
	 */
	public function is_active($directory) {
		$module = new Module();
		$module->get_where(array('directory'=>$directory,'status'=>'enabled'),1);		
		return $module->exists();
	}
	
	
	/**
	 * Add module
	 * @param $module_metadata
	 * 		An array with all the data to add a module
	 * @param $module_actions
	 * 		An array with all the actions of a module
	 * @param $module_permissions
	 * 		An array with the groups that are allowed to load this module
	 */
	 public function add_module($module_metadata, $module_actions, $module_permissions) {
	 	Database_manager::get_db()->trans_start();
		
		$module = new Module($module_metadata);
		$module->save();

		foreach($module_actions AS $action){
			$action = new Action();
			$action->name = $action['action'];
			$action->module_id = $module->id;
			$action->controller = $action['controller'];
			$action->save();
		}
		/*
		foreach($module_permissions AS $permission_group_name){
			$group = new Group();
			$group->get_where(array('name'=>$permission_group_name),1);
			$permission = new Permission();
			$permission->action_id = $action->id;
			$permission->group_id = $group->id;
		}
		*/
		Database_manager::get_db()->trans_complete();
	 }


}

/* End of file module.php */
/* Location: ./application/models/module.php */
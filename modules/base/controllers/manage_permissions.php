<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_permissions extends SCADSY_Controller{

	public function __construct() {
		parent::__construct();
		$this->init();
	}
	
	/**
	 * Manage the permissions of the modules
	 */
	 public function index() {
		$modules = new Module();
		$modules->get_where(array('status'=>'enabled'));
		
		foreach($modules as $module){
			$module->action->get();
						
			foreach($module->action AS $action){
				$guest_group = new Group();
				$guest_group->name = 'Everyone (visitors included)';
				$permission = new Permission();
				$guest_group->permission = $permission->get_where(array('action_id'=>$action->id,'group_id'=>NULL),1);
				$action->group = $guest_group;
				
				$user_groups = new Group();
				$action->group->child_group = $user_groups->where_related_parent_group('id IS NULL')->get();
				foreach($action->group->child_group AS $group){
					$group->permission->get_where(array('action_id'=>$action->id,'group_id'=>$group->id),1);
					$group->get_child_groups($action);
				}		
			}
		}

		$data['modules'] = $modules;
		$this->view('permissions/index', $data);
	 }
	 
	 /**
	  * Gets all childgroups (including further descendants) and their permission.
	  * @param $group
	  * 	group-object (datamapper) to retrieve descendants from
	  * @param $action_id
	  * 	id of the action to find permissions that match both (child)group and action
	  
	 private function _get_child_groups($group, $action_id){
	 	if($group->exists() === FALSE){
	 		return NULL;
	 	}
	 	$group->child_group->get();
		foreach($group->child_group AS $child_group){
			$child_group->permission->get_where(array('action_id'=>$action_id,'group_id'=>$child_group->id),1);
			$this->_get_child_groups($child_group, $action_id);
		}
	 }
	  * */
	 
	 /**
	  * Handle the post from the permission page
	  */
	  public function permission_edit() {
	  	if($this->input->server('REQUEST_METHOD') == "POST") {
			Database_manager::get_db()->trans_start();	

			$action = new Action($this->input->post('module'),$this->input->post('controller'),$this->input->post('action'));		
			$group = new Group($this->input->post('group'));

			$permission = new Permission();
			$permission->where_related($action)->where_related($group)->get();
			$permission->allowed = ($this->input->post('allowed') === FALSE) ? 0 : 1;			
			
			$permission->error_prefix = "";
			$permission->error_suffix = "";
			
			$user = new User();
			$user->get_by_logged_in();
			
			if($permission->allowed == 0){
				if($group->exists() && $user->is_related_to($group) === TRUE) {
					exit("Cannot deny your own permission");
				}
			}	
			if($permission->save(array($action,$group)) === FALSE){
				echo "Er ging iets mis, maar wat?";
				exit($permission->error->string);
			}
			
			Database_manager::get_db()->trans_complete();
		}
	  }
}


/* End of file manage_permissions.php */
/* Location: ./modules/module/controllers/manage_permissions.php */
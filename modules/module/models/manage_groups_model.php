<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Manages the groups by post-requests.
 */
class Manage_groups_model extends SCADSY_Model {
	
	/**
	 * Retrieves a hierarchical list of groups and subgroups. 
	 * @return
	 * 		group-object that consists of one or more groups.
	 */
	public function get_group_list(){
		$groups = (new Group())->where_related_parent_group('id IS NULL')->get();
		foreach($groups AS $group){
			$group->get_child_groups();
		}
		return $groups;
	}
	
	/**
	 * Handles saving a group by a post-request. 
	 * Either changes an existing group or adds a new group, based on the post-values.
	 */	
	public function save_group(){		
		Database_manager::get_db()->trans_start();	
		if($this->input->post('old_name')){
			if($this->input->post('old_name') != $this->input->post('name')){
				$this->rename_group();
			}			
		}
		elseif($this->input->post('name')){
			$this->add_group();
		}
		Database_manager::get_db()->trans_complete();
	}
	
	/**
	 * Adds a new group using post-values.
	 * @return
	 * 		TRUE if adding the group went successful.
	 * 		FALSE if something went wrong.
	 */
	private function add_group(){
		$group = new Group();
		$group->name = $this->input->post('name');
		if($group->save() === FALSE){
			$this->notification_manager->add_notification("failed", "Could not add group: ".$group->error->string);
			return FALSE;
		}
		if($this->relate_with_parent($group) === FALSE){
			return FALSE;
		}
		$this->notification_manager->add_notification("succes", $this->input->post('name')." group successfully added!");
		return TRUE;
	}
	
	/**
	 * Relates the group with the parent-group provided in the post-request. 
	 * @param $group
	 * 		the group-object to relate with the parent-group.
	 * @return
	 * 		TRUE if relating with parent was succesfull (or didn't happen, because of no need)
	 * 		FALSE if trying to relate the groups went wrong.
	 */
	private function relate_with_parent($group){		
		if($this->input->post('parent_group') == 'everyone'){
			if($this->inherit_permissions($group, NULL) === FALSE){
				return FALSE;
			}
			return TRUE;
		}
		$parent_group = new Group($this->input->post('parent_group'));
		if($parent_group->exists()){
			if($group->save_parent_group($parent_group) === FALSE){
				$this->notification_manager->add_notification("failed", "Could not add group: ".$group->error->string);
				return FALSE;
			}
			if($this->inherit_permissions($group, $parent_group->id) === FALSE){
				return FALSE;
			}
		}
		return TRUE;
	}
	
	/**
	 * Makes a group inherit the permissions of the parent-group.
	 * @param $group
	 * 		group-object that should inherit permissions
	 * @param $parent_group_id
	 * 		id of the parent group of which permissions should be inherited.
	 * @return
	 * 		TRUE if inheriting permissions went succesfully.
	 * 		FALSE if something went wrong.
	 */
	private function inherit_permissions($group, $parent_group_id){
		$permission = new Permission();
		foreach($permission->get_where(array('group_id'=>$parent_group_id,'allowed'=>1)) AS $permission){
			if($permission->get_copy()->save($group) === FALSE){
				$this->notification_manager->add_notification("failed", "Could not add group because of permissions: ".$permission_copy->error->string);
				return FALSE;
			}
		}
		return TRUE;
	}
	
	/**
	 * Change the name of an existing group.
	 * @return
	 * 		TRUE if renaming the group went successfully.
	 * 		FALSE if something went wrong. 
	 */
	private function rename_group(){
		$group = new Group($this->input->post('old_name'));
		if((new Group($this->input->post('name')))->exists()){
			$this->notification_manager->add_notification("failed", "Could not rename group: ".$this->input->post('old_name')." is already taken.");
			return FALSE; 	
		}
		$group->name = $this->input->post('name');
		if($group->save() === FALSE){
			$this->notification_manager->add_notification("failed", "Could not rename group: ".$group->error->string);
			return FALSE;
		}
		$this->notification_manager->add_notification("succes", $this->input->post('old_name')." group successfully renamed to ".$this->input->post('name')."!");
		return TRUE;
	}
	
	/**
	 * Removes a group entirely
	 * Ensures that child-groups are moved upwards and become children of the deleted group's parent-group. 
	 */
	public function delete_group(){
		$group = new Group($this->input->post('old_name'));
		$parent_group = new Group($this->input->post('parent_group'));
		foreach($group->child_group->get() AS $child_group){
			$child_group->save_parent_group($parent_group);
		}
		$group->delete();
		$this->notification_manager->add_notification("succes", $this->input->post('old_name')." group successfully removed!");
	}
	
	

}


/* End of file manage_groups_model.php */
/* Location: ./modules/module/models/manage_groups_model.php */
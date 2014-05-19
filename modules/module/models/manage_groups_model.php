<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Manage_groups_model extends SCADSY_Model {
	
	public function save(){
		Database_manager::get_db()->trans_start();	
			//Save all (new) groups and namechanges	
			if($this->save_groups($this->input->post('groups'), 'everyone')){				
				//Remove all groups that are not submitted (and thus removed)
				$this->remove_old_groups();	
				//Check all permissions to keep constraints intact (if parent-groups are allowed, then the children should be allowed as well)
				$this->check_all_permissions();
				$this->notification_manager->add_notification("succes", "Saving groups successfull!");  
			}
		Database_manager::get_db()->trans_complete();		
					
	}

	private function remove_old_groups(){
		$existing_group_names = call_user_func_array('array_merge', $this->input->post('groups'));
		$groups = new Group();
		$groups->where_not_in('name',$existing_group_names)->get();
		$groups->delete_all();
	}
	
	/**
	 * Save all (new) groups and name-changes to the database.
	 */
	private function save_groups($group_names, $group_name_parent){	
		foreach($group_names[$group_name_parent] AS $group_name_old => $group_name_new){				
			$group = new Group(is_numeric($group_name_old) ? NULL : $group_name_old);
			$group->name = $group_name_new;
			if($group->save() === FALSE){
				$this->notification_manager->add_notification("failed", "Saving groups failed because of ".$group_name_new.": ". $group->error->string); 
				Database_manager::get_db()->trans_rollback();
				return FALSE;	
			}
			$parent_group = new Group($group_name_parent);
			if($parent_group->exists()){
				if($group->save_parent_group($parent_group) === FALSE){
					$this->notification_manager->add_notification("failed", "Saving groups failed because of ".$group_name_new." relation with ".$parent_group->name.": ". $group->error->string); 
					Database_manager::get_db()->trans_rollback();
					return FALSE;	
				}
			}
			if(isset($group_names[$group_name_new])){
				if($this->save_groups($group_names, $group_name_new) === FALSE){
					return FALSE;
				}
			}
		}
		return TRUE;
	}
	
	
	/**
	 * Check all permissions for their allowed-statusses:
	 * each group that is allowed for a certain action should have their child-groups allowed as well.
	 * 
	 * This method first checks all permissions that are allowed to everyone and then sets all those groups to allowed.
	 * Afterwards it checks for the groups without parents and saves their child-group to have those inherit their allowed-permissions.
	 */
	private function check_all_permissions(){	
		$completed_actions = array(0);	
		//First, save all permissions that are allowed to everyone
		$permissions = new Permission();
		$permissions->where('allowed',1)->where_related_group('id IS NULL')->get();		
		foreach($permissions AS $permission){
			$completed_actions[] = $permission->action_id;
			$permission->save_all_groups_permissions();			
		}
		
		//Then, check the parent-most groups (groups without parent).
		$groups = new Group();
		$groups->where_related_parent_group('id IS NULL')->get();
		$this->save_child_permissions($groups, $completed_actions);
		
	}
	
	/**
	 * Save permissions of the child-groups.
	 * Don't check permissions that:
	 * - have allowed set to 0 (thus being a deny)
	 * - have their action_id not in completed_actions (and thus have been checked already)
	 * @param $groups
	 * 		The groups (datamapper-object) to match permissions with
	 * @param $completed_actions
	 * 		Array of action_id's of which their matching permissions have been set on allowed for all groups already.
	 */
	private function save_child_permissions($groups, $completed_actions){
		if($groups->exists() === FALSE){
			return;
		}
		foreach($groups AS $group){
			$completed_actions_for_this_group = $completed_actions;		
			$permissions = (new Permission())
				->where('group_id',$group->id)
				->where('allowed',1)
				->where_not_in('action_id',$completed_actions)
				->get();
			foreach($permissions AS $permission){	
				$permission->save_child_groups_permissions($group->child_group->get());
				$completed_actions_for_this_group[] = $permission->action_id;
			}
			$this->save_child_permissions($group->child_group->get(), $completed_actions_for_this_group);
		}
	}
	

}


/* End of file manage_groups_model.php */
/* Location: ./modules/module/models/manage_groups_model.php */
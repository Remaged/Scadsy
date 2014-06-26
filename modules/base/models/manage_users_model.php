<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Manage_users_model extends SCADSY_Model {
	
	/**
	 * Retrieves a list of users.
	 * @param $page
	 * 		The page to be shown.
	 * @param $page_size
	 * 		The amount of user to show on a page.
	 * @param $search_group
	 * 		The group to filter users by.
	 * @param $search_name
	 * 		Name to search users by on their username, first_name, last_name, email or phone_number
	 */
	public function get_users($page = 1, $page_size = 10, $search_group = NULL, $search_name = NULL){
		$users = new User();
		
		if(!empty($search_group) && $search_group != 'all'){
			$users->where_related(new Group(urldecode($search_group)));
		}		
	 	
		if(!empty($search_name)){
			$users->group_start()->ilike('CONCAT(first_name," ",last_name)',urldecode($search_name))
				->or_ilike('phone_number',urldecode($search_name))
				->group_end();
		}	

		return $users->get_paged($page, $page_size);
	}
	
	/**
	 * Stores user-information
	 * @param $username
	 * 		(optional) username of the user to be edited. If NULL, then a new user will be created.
	 */
	public function save_user($username = NULL){
		$user = new User($username);
		$this->set_all_user_properties($user);

		Database_manager::get_db()->trans_start();		
			if($user->save() === FALSE){
				$this->notification_manager->add_notification("error", "Saving failed: ".$user->error->string); 
				Database_manager::get_db()->trans_rollback();
				return;
			}	
			$this->save_user_groups($user);
		Database_manager::get_db()->trans_complete();
		
		$this->notification_manager->add_notification("succes", "User successfully " . ($username ? "updated!" : "added!")); 
			
		unset($_POST['password']);
		unset($_POST['password_confirm']);
	}
	
	/**
	 * Deletes all old group-relationships and adds the new relationshipts
	 */
	private function save_user_groups($user){
		$user->delete($user->group->where_not_in('name',$this->input->post('groups'))->get()->all);
		
		if(!$this->input->post('groups')){
			return;
		}
		foreach($this->input->post('groups') AS $group_key => $value){
			$group = new Group($value);
			$user->save($group);			
		}
	}
	
	/**
	 * Sets the user-properties by using the POST-information.
	 */
	private function set_all_user_properties($user){
		foreach ($this->input->post() AS $property => $value) {
			if($this->input->post($property)){
				$user->$property = $this->input->post($property);
			}
		}
		if($user->exists() && $this->input->post('password') === NULL){
			$user->password_confirm = $user->password;
		}
	}

}

/* End of file manage_user_model.php */
/* Location: ./modules/module/models/manage_user_model.php */
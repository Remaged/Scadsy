<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Manage_user_model extends SCADSY_Model {
	
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
			$users->where_related(new Group($search_group));
		}		
	 	
		if(!empty($search_name)){

			$users->group_start()->ilike('username',$search_name)
				->or_ilike('first_name',$search_name)
				->or_ilike('last_name',$search_name)
				->or_ilike('email',$search_name)
				->or_ilike('phone_number',$search_name)
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
			if($this->save_student_information($user) === FALSE){
				Database_manager::get_db()->trans_rollback();
				return;
			}
		Database_manager::get_db()->trans_complete();
		
		$this->notification_manager->add_notification("succes", "User successfully " . ($username ? "updated!" : "added!")); 
			
		unset($_POST['password']);
		unset($_POST['password_confirm']);
	}
	
	/**
	 * Deletes all old group-relationships and adds the new relationshipts
	 */
	private function save_user_groups($user){
		$user->delete($user->group->get()->all);
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
	
	/**
	 * Stores student information for the provided user.
	 * @param $user
	 * 		user-object (datamapper) to store student information for.
	 */
	private function save_student_information($user){
		$student_group = new Group('student');
		if($user->is_related_to($student_group)){
			$student = new Student();
			$student->grade_id = $this->input->post('grade_id');
			$student->alternate_id = $this->input->post('alternate_id');
			$student->user_id = $user->id;
			if($student->save() === FALSE){
				$this->notification_manager->add_notification("error", "Saving failed because of student information: ".$student->error->string); 
				return FALSE;
			}
			return $this->save_enrollment_information($student);
		}
		return TRUE;
	}
	
	/**
	 * Stores enrollment information for the provided student.
	 * @param $user
	 * 		student-object (datamapper) to store enrollment information for.
	 */
	private function save_enrollment_information($student){
		$enrollment = new Enrollment();
		$enrollment->start_date = $this->input->post('start_date');
		$enrollment->end_date = $this->input->post('end_date');
		$enrollment->student_id = $student->id;
		if($enrollment->save() === FALSE){
			$this->notification_manager->add_notification("error", "Saving failed because of enrollment information: ".$enrollment->error->string); 
			return FALSE;
		}
		return TRUE;
	}
}


/* End of file manage_user_model.php */
/* Location: ./modules/module/models/manage_user_model.php */
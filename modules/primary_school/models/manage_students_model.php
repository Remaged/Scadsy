<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Manage_students_model extends SCADSY_Model {
	
	/**
	 * Retrieves a list of student users and their parents.
	 * @param $page
	 * 		The page to be shown.
	 * @param $page_size
	 * 		The amount of user to show on a page.
	 * @param $search_group
	 * 		The group to filter users by.
	 * @param $search_name
	 * 		Name to search users by on their username, first_name, last_name, email or phone_number
	 */
	public function get_students($page = 1, $page_size = 10, $search_group = NULL, $search_name = NULL){
		$users = new User();
	
		if(!empty($search_group) && $search_group != 'all'){
			$group = new Group(urldecode($search_group));
			$group_ids = array($group->id);
			foreach($group->get_descendants() AS $descendant_group){
				$group_ids[] = $descendant_group->id;
			}
			$users->include_related('group')->where_in('group_id',$group_ids);
		}
		else{
			$group = new Group('student');
			$group_ids = array($group->id);
			foreach($group->get_descendants() AS $descendant_group){
				$group_ids[] = $descendant_group->id;
			}
			$users->include_related('group')->where_in('group_id',$group_ids);
		}	

		if(!empty($search_name)){
			$users->group_start()
				->ilike('CONCAT(first_name," ",last_name)',urldecode($search_name))
				->or_ilike('phone_number',urldecode($search_name))
				->group_end();
		}
		return $users->order_by('last_name')->group_by('users.id')->get_paged_iterated($page, $page_size);
		//return $users->order_by('last_name')->group_by('users.id')->distinct()->get_paged_iterated($page, $page_size);
	}

	/**
	 * Get group-options for students
	 * @return
	 * 		array of all descendant-groups of the student-group
	 */
	public function get_student_group_options($add_everyone_option = FALSE){
		$student_group = new Group('student');
		$student_descendant_groups = $student_group->get_descendants();

		$student_group_options = array();
		foreach($student_group->descendants AS $descendant_group){
			$student_group_options[$descendant_group->name] = ucfirst($descendant_group->name);
		}
		if($add_everyone_option){
			$student_group_options['all'] = 'All students';
		}
		return array_reverse($student_group_options);
	}
	
	
	
	/**
	 * Saves post-information
	 * @return
	 * 		TRUE or FALSE depending on wether saving went succesful or not.
	 */
	public function save(){
		Database_manager::get_db()->trans_start();	
			$user = $this->save_student_user();
			$student = $this->link_user_to_student($user);			
			$this->delete_removed_information($student);					
			$this->save_enrollment_information($user, $student);			
			$this->save_guardians($student);	
		Database_manager::get_db()->trans_complete();		
		return $this->handle_trans_status($user);
	}
	
	/**
	 * Adds a student that is linked to the user if not already existing.
	 * @return
	 * 		student-object (datamapper)
	 */
	private function link_user_to_student($user){
		if($user->student->exists()){
			return $user->student;
		}
		$student = new Student();
		$student->save($user);
		var_dump($student->exists());
		return $student;
	}
	
	/**
	 * Save user-information of the student.
	 * @return 
	 * 		user-object of the student-user that just has been added or updated.
	 */
	private function save_student_user(){
		$user = new User($this->input->post('user_id')?:NULL);					
		$this->set_properties($user, $this->input->post());		
		if($user->save() === FALSE){
			$this->notification_manager->add_notification("error", "Saving failed: ".$user->error->string); 
			return FALSE;
		}
		return $user;
	}
	
	/**
	 * Shows a notification, depending on the transaction-status.
	 */
	private function handle_trans_status($user){		
		if(Database_manager::get_db()->trans_status()){
			$this->session->set_flashdata('save_student_message',"Student successfully " . ($this->input->post('user_id') ? "updated!" : "added!"));
			return $user->username;
		}
		$this->notification_manager->add_notification("failed", "Something went wrong"); 
		return NULL;
	}
	
	/**
	 * Handles removed information (only applies for edited information)
	 */
	private function delete_removed_information($student){
		if($this->input->post('user_id')){
			$this->delete_removed_enrollments($student);	
			$this->delete_removed_guardians($student);
		}
	}
	/**
	 * Sets the user-properties by using the POST-information.
	 */
	private function set_properties($user, $propperties){
		foreach ($propperties AS $property => $value) {
			$user->$property = $value;
		}
	}
		
	/**
	 * Sets enrollment information for the student and adds student to groups, depending on the enrollment information.
	 * @param $student
	 * 	the student-object (datamapper) to be used for saving the relations with enrollment and groups
	 */
	private function save_enrollment_information($user, $student){
		$enrollment_vars_array = $this->switch_array_keys($this->input->post('enrollment'));		
		foreach($enrollment_vars_array AS $enrollment_vars){
			if(isset($enrollment_vars['disabled'])) continue; 	
			$enrollment = new Enrollment(empty($enrollment_vars['id']) ? NULL : $enrollment_vars['id']);
			$enrollment->start_date = isset($enrollment_vars['start_date']) ? $enrollment_vars['start_date'] : NULL;
			$enrollment->end_date = isset($enrollment_vars['end_date']) ? $enrollment_vars['end_date'] : NULL;
			$enrollment->save(array($student, new Group($enrollment_vars['grade'])));
			$this->save_student_to_enrollment_group($user,$enrollment_vars);
		}
		//If there are no enrollments, then add the user to the generic 'student'-group
		if($user->groups->get()->exists() === FALSE){
			$user->save(new Group('student'));
		}
	}
	
	
	/*
	 * If the enrollment has not past yet (and thus the end_date is after today or not provided), add the user to the group.	
	 * If the enrollment has past, then remove the relation between the group and user.
	 */ 	
	private function save_student_to_enrollment_group($user, $enrollment_vars){	
		if(empty($enrollment_vars['end_date']) || strtotime($enrollment_vars['end_date'] ) >= time()) {
			if($user->save(new Group($enrollment_vars['grade'])) === FALSE){
				$this->notification_manager->add_notification("error", "Saving user to '".$enrollment_vars['grade']."' group failed"); 
				return FALSE;
			}
		}
		elseif(strtotime($enrollment_vars['end_date'] ) < time()){
			$user->delete(new Group($enrollment_vars['grade']));
		}
	}	
	
	/**
	 * Switches the keys of a two-dimensional array.
	 * eg: $array['fruits'][1] would change into $array[1]['fruits]
	 */
	private function switch_array_keys($array){
		$new_array = array();
		foreach($array AS $key => $subarray){
			foreach($subarray AS $sub_key => $value){
				$new_array[$sub_key][$key] = $value;
			}
		}
		return $new_array;
	}
	
	/**
	 * Saves the guardians that were added and links them to the student.
	 */
	private function save_guardians($student){
		$guardians = $this->switch_array_keys($this->input->post('guardian'));
		foreach($guardians AS $guardian_vars){
			if(isset($guardian_vars['disabled'])) continue; 
			$guardian_user = new User(empty($guardian_vars['user_id']) ? NULL : $guardian_vars['user_id']);
			$this->set_properties($guardian_user, $guardian_vars);
			if(isset($guardian_vars['user_id'])){
				$guardian_user->id = $guardian_vars['user_id'];
			} 
			if($guardian_user->save() === FALSE){
				$this->notification_manager->add_notification("error", "Saving guardian-information failed: ".$guardian_user->error->string); 
				return FALSE;
			}
			$guardian = new Guardian(empty($guardian_vars['id']) ? NULL : $guardian_vars['id']);
			$guardian->save(array($student, $guardian_user));
		}
		return TRUE;	
	}
	
	/**
	 * Removes the enrollment that do not appear in array of id's (it is then assumed, the user has removed them)
	 */
	private function delete_removed_enrollments($student){
		$enrollments = $this->input->post('enrollment');	
		$student->enrollments->where_not_in('id',$enrollments['id'])->get();
		if($student->enrollments->exists()){
			foreach($student->enrollments AS $old_enrollment){
				$student->user->delete($student->user->group->get_where(array('group_id'=>$old_enrollment->group->id),1));
			}
			$student->enrollments->delete();
		}
	}
	
	/**
	 * Removes the link between the student and guardians that do not appear in the array of id's (it is then assumed, the user has removed them)
	 */
	private function delete_removed_guardians($student){
		$guardians = $this->input->post('guardian');
		$student->delete($student->guardians->where_not_in('id',$guardians['id'])->get());
	}
}

/* End of file manage_students_model.php */
/* Location: ./modules/manage_students/models/manage_students_model.php */
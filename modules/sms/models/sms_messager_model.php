<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Handles getting, sending and receiving SMS'
 */
class Sms_messager_model extends SCADSY_Model {
	
	/**
	 * Retrieves a set of users based on the page, page-size and (optionally) a search.
	 * Only searches for sms-es that were sent from this website. 
	 * @param $page
	 * 		the page to start at
	 * @param $page_size
	 * 		the (maximum) amount of results
	 * @param $search
	 * 		string to match message-content against. 
	 * @return $smses
	 * 		set of smses (datamapper-object) including related users and received smses.
	 */
	public function get_smses($page = 1, $page_size = 10, $search= NULL){
		$smses = new Sms();	
		$smses->where('reply_event_id IS NULL');
		$smses->ilike('message',$search);
		$smses->get_paged($page, $page_size);
		
		foreach($smses AS $sms){
			$sms->create_user_relation();
			$sms->user->get();
			$sender = new User();
			$sms->sender = $sender->get_where(array('id'=>$sms->user_id),1);
			
			$sms->reply = new Sms();
			if($sms->event_id !== NULL){				
				$sms->reply->get_where(array('reply_event_id'=>$sms->event_id));
			}
		}			
		return $smses;
	}
	
	/**
	 * Gets sms-information, including the related information.
	 * @param $id
	 * 		id of the sms to get information from.
	 * @return $sms
	 * 		sms datamapper-object containing sms-information and relational information.
	 * 
	 */
	public function get_detail_info($id){
		$sms = new Sms();
		$sms->get_where(array('id'=>$id),1);
		$sms->create_user_relation();
		$sms->user->include_join_fields();
		$sms->user->get();
		$sms->reply = new Sms();
		if($sms->event_id !== NULL){				
			$sms->reply->get_where(array('reply_event_id'=>$sms->event_id));
		}
		return $sms;
	}	

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
	public function get_users($page = 1, $page_size = 10, $search_group = NULL, $search_name = NULL){
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

		return $users->get_paged($page, $page_size);
	}
	
	/**
	 * Gets groups for students 
	 * @return
	 * 		associative array: group-name => parent-group-name
	 */
	public function get_student_group_options($group = 'student', $result = array('student'=>'0')){
		$group = new Group($group);
		if($group->exists() === FALSE){
			return $result;
		}
		foreach($group->child_group->get() AS $child_group){
			$result[$child_group->name] = $group->name;		
			$result = $this->get_student_group_options($child_group->name, $result);
		}
		return $result; 		
	}
	
	/**
	 * Gets groups for students for a dropdown list.
	 * @return
	 * 		associative array: group-name => group-name (first letter capitalised)
	 */
	public function get_student_group_dropdown_options(){
		$group_options = $this->get_student_group_options();
		array_shift($group_options);
		$dropdown_options = array('all'=>'All students/parents');
		foreach($group_options AS $group_option => $parent_name){
			$dropdown_options[$group_option] = ucfirst($group_option);
		}
		return $dropdown_options;
	}
	
	/**
	 * Stores and sends the sms.
	 */
	public function send_sms(){
		if( ! $this->input->post('message')){
			$this->notification_manager->add_notification("error", "No message is provided."); 
			return;
		}
		
		$sms = $this->save_sent_sms();
		$sms->create_user_relation();
		
		$numbers = array();
		foreach($sms->user->get() as $receiver){
			if( ! in_array($receiver->phone_number, $numbers)){
				$numbers[] = str_replace(' ','',$receiver->phone_number);
			} 
		}
		
		//return "The SMS has been (fake)sent.";
		//exit('voorkomt per ongeluk verbruiken van mobile api');
		
		$this->load->model('mobile_api');
		$sms_api_result = $this->mobile_api->sendSms(implode(",",$numbers), $sms->message);	
		if(isset($sms_api_result->eventid)){
			$sms->event_id = $sms_api_result->eventid;
		}
		$sms->save();
		
		return "The SMS has been sent.";		
	}
	
	/**
	 * Saves the sms (that is to be sent) in the database.
	 */
	private function save_sent_sms(){
		$sms = new Sms();

		$sms->message = $this->input->post('message');
		$user = new User();
		$sms->user_id = $user->get_by_logged_in()->id;
		$sms->date_time = date('Y-m-d H:i:s');
		$sms->save();

		$receivers = array();
		$selected = $this->input->post('selected');
		
		if(isset($selected['users'])){
			foreach($selected['users'] AS $username){
				$this->save_sent_sms_receiver($username, $sms);	
			}
		}
		
		if(isset($selected['groups'])){
			foreach($selected['groups'] AS $group){
				if(stristr($group,"parents_")){
					$this->save_sent_sms_receiver_group(str_replace("parents_","",$group), $sms, TRUE);
				}
				elseif(stristr($group,"students_")){
					$this->save_sent_sms_receiver_group(str_replace("students_","",$group), $sms, FALSE);
				}
			}
		}
		
		return $sms;
	}
	
	/**
	 * Saves the receivers for a whole group.
	 * @param $group_name
	 * 		name of the group of which the receivers should be saved
	 * @param $sms
	 * 		the sms that the receivers should be linked to
	 * @param $to_parents
	 * 		TRUE if the parents (guardians) of the groups should be used instead.
	 * 		FALSE (default) if the students (actual users of the group) should be used.
	 */
	private function save_sent_sms_receiver_group($group_name, $sms, $to_parents = FALSE){
		$group = new Group($group_name);
		$group->get_descendants();
		$group->descendant->all = array_merge($group->all, $group->descendant->all);	
		foreach($group->descendant AS $target_group){			
			foreach($target_group->user->get() AS $user){
				if($to_parents){
					foreach($user->student->guardian->get() AS $parent){
						$this->save_sent_sms_receiver($parent->user->username, $sms);
					}
				}
				else{
					$this->save_sent_sms_receiver($user->username, $sms);
				}
			}
		}
	}
	
	/**
	 * Saves the receiver for the sms
	 * @param $username
	 * 		username (string) of the user that is the receiver of the sms
	 * @param $sms
	 * 		sms (datamapper-object) that is received by the user.
	 */
	private function save_sent_sms_receiver($username, $sms){
		$user = new User($username);
		if(empty($user->phone_number)){
			return;
		}		
		$sms->create_user_relation($user);

		$sms->save($user);
		$sms->set_join_field($user,'used_phone_number',str_replace(" ","",$user->phone_number));
	}
	
	
	/**
	 * Handles sent_item information from the mobile API.
	 * - stores the date and time the message was received, if it was received.
	 */
	public function handle_push_sent_item(){	
		Database_manager::get_db()->insert('test_api_results',array('value'=>http_build_query($this->input->get())));	
		$sms = $this->get_sent_sms();
		foreach($sms->user->get() AS $user){
			$sms->set_join_field($user,'sent_date_time',
				DateTime::createFromFormat('d/M/Y H:i:s', $this->input->get('SentDataTime'))->format('Y-m-d H:i:s')
			);	
		}	
	}
	
	/**
	 * Handles reply information from the mobile API.
	 * Creates a new Sms-item that is linked to the EventID of the message that was sent before.
	 */
	public function handle_push_reply(){
		
		Database_manager::get_db()->insert('test_api_results',array('value'=>http_build_query($this->input->get())));
		
		$sms = new Sms();
		$sms->message = $this->input->get('IncomingData');
		$sms->date_time = DateTime::createFromFormat('d/M/Y H:i:s', $this->input->get('SentDataTime'))->format('Y-m-d H:i:s');
		$sms->reply_event_id = $this->input->get('EventID');
		
		$sms->user_id = $this->get_sent_sms()->user->id;
		
		
		$sms->save();
		
	}
	
	/**
	 * Gets the particular sms based on the EventID.
	 * Rather than just getting the sms-message, it gets the specific sms sent to a user, which also includes the relationship.
	 * 
	 * @param return
	 * 		sms and sms-user relationship contained in the sms-object.
	 */	
	private function get_sent_sms(){
		$sms = new Sms();
		$sms->get_where(array('event_id'=>$this->input->get('EventID')),1);
		$sms->create_user_relation();
		$sms->user->include_join_fields();
		$sms->user->where('used_phone_number',str_replace(' ','+',$this->input->get('Phonenumber')))
				  ->or_where('used_phone_number','+'.str_replace(' ','',$this->input->get('Phonenumber')))
				  ->get();
		return $sms;
	}


}


/* End of file sms_messager_model.php */
/* Location: ./modules/sms/models/sms_messager_model.php */
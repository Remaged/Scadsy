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
			$sender = new User($sms->user_id);
			$sms->sender = $sender->get();
			
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
		$sms->user->get();
		$sms->reply = new Sms();
		if($sms->event_id !== NULL){				
			$sms->reply->get_where(array('reply_event_id'=>$sms->event_id));
		}
		return $sms;
	}
	
	/**
	 * Searches for users by looking at their username and first- middle- and lastname.
	 * @return $users
	 * 		datamapper-object containing the first 10 results of found users.
	 */
	public function search_users(){
		$search_value = $this->input->post('search') ? $this->input->post('search') : '';
		$users = new User();

		$users	->like('username',$search_value)
				->or_like('first_name',$search_value)
				->or_like('middle_name',$search_value)
				->or_like('last_name',$search_value)
				->limit(10)
				->get();
		return $users;
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
		
		
		return "The SMS has been sent.";
		exit('voorkomt per ongeluk verbruiken van mobile api');
		
		$this->load->model('mobile_api');
		$sms_api_result = $this->mobile_api->sendSms(implode(",",$numbers), $sms->message);	
		if($sms->api_result->eventid){
			$sms->event_id = $sms->api_result->eventid;
		}
		if($sms->api_result->error){
			$sms->api_error = $sms->api_result->error;
		}
		$sms->save();
		
			
		var_dump($this->mobile_api->checkCredits());
				
	}
	
	/**
	 * Saves the sms (that is to be sent) in the database.
	 */
	private function save_sent_sms(){
		$sms = new Sms();
		
		$sms->message = $this->input->post('message');
		$sms->user_id = (new User())->get_by_logged_in()->id;
		$sms->date_time = date('Y-m-d H:i:s');
		$sms->save();

		$receivers = array();
		foreach($this->input->post('selected') AS $username){
			$this->save_sent_sms_receiver($username, $sms);	
		}
		
		return $sms;
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
			$this->notification_manager->add_notification("notice", "Message was not sent to {$username}, because no phone number was available."); 
			return;
		}		
		$sms->create_user_relation($user);
		
		$sms->set_join_field($user,'used_phone_number',str_replace(" ","",$user->phone_number));
		
		$sms->save($user);
	}
	
	
	/**
	 * Handles sent_item information from the mobile API.
	 * - stores the date and time the message was received, if it was received.
	 */
	public function handle_push_sent_item(){	
		Database_manager::get_db()->insert('test_api_results',array('value'=>http_build_query($this->input->get())));	
		$sms = $this->get_sent_sms();
			
		if($this->input->get('Flash')=='True'){
			$sms->set_join_field($sms->user,'sent_date_time',
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
		$sms->message = $this->input->get('SentData');
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
		$sms->get_where('event_id',$this->input->get('EventID'));
		$sms->create_user_relation();
		$sms->user->include_join_fields();
		$sms->user->get_where(array('used_phone_number'=>str_replace(' ','+',$this->input->get('Phonenumber'))),1);
		
		return $sms;
	}


}


/* End of file sms_messager_model.php */
/* Location: ./modules/sms/models/sms_messager_model.php */
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_users extends SCADSY_Controller{
	var $data = array();
	public function __construct() {
		parent::__construct();
		parent::init();
		$this->load->model('manage_user_model');
	}
	
	/**
	 * Default page will use the userlist
	 */
	public function index(){
		$this->userlist();
	}
	
	/**
	 * Deleting an user. A post-confirmation is required for the actual delete to be executed (to prevent CSRF and user-mistakes).
	 * @param $username
	 * 		username of the user to be deleted.
	 */
	public function delete($username){
		if($this->input->post('delete_user')){
			$user = new User($username);
			$user->delete();
			$this->view('users/user_deleted', array('username'=>$username));
		}
		else{
			$this->view('users/confirm_delete', array('username'=>$username));
		}
	}
	
	/**
	 * Display a list of users.
	 * @param $page
	 * 		The page to be shown.
	 * @param $page_size
	 * 		The amount of user to show on a page.
	 * @param $search_group
	 * 		The group to filter users by.
	 * @param $search_name
	 * 		Name to search users by on their username, first_name, last_name, email or phone_number
	 */
	 public function userlist($page = 1, $page_size = 10, $search_group = NULL, $search_name = NULL) {
	 	$this->data['search_group'] = $search_group;
		$this->data['search_name'] = $search_name;
		$this->data['page_size'] = $page_size;	
		$this->data['users'] = $this->manage_user_model->get_users($page, $page_size, $search_group, $search_name);		
		$this->data['dropdown_options'] = array('all'=>'Everyone');
		
		foreach((new Group())->get() AS $group){
			$this->data['dropdown_options'][$group->name] = ucfirst($group->name);
		}

		$this->view('users/index', $this->data);
	 }
	 
	 /**
	  * Adding a new user
	  */
	 public function add(){
	 	$this->edit();
	 }
	 
	 /**
	  * Editing user-information.
	  * @param $username
	  * 	(optional) username of the user to be edited. If no username is provided a new user will be used.
	  */
	 public function edit($username = NULL){
	 	$user = new User($username);
		$this->data['user'] = $user;
		
		$groups = (new Group())->where_related_parent_group('id IS NULL')->get();
		foreach($groups AS $group){
			$group->get_child_groups();
		}
		
		$this->data['groups'] = $groups;
		$this->data['ethnicities'] = (new Ethnicity())->get();
		$this->data['languages'] = (new Language())->get();
		$this->data['grades'] = (new Grade())->get();
		
		$this->view('users/user_info', $this->data);
	 }
	 
	 /**
	  * Save user-information.
	  */
	 public function save($username = NULL){		
		$this->manage_user_model->save_user($username);		
		$this->edit($this->input->post('username'));
	 }
	
}


/* End of file manage_users.php */
/* Location: ./modules/module/controllers/manage_users.php */
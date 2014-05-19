<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_groups extends SCADSY_Controller{
	var $data = array();
	public function __construct() {
		parent::__construct();
		parent::init();
		$this->load->model('manage_groups_model');
	}
	
	/**
	 * 
	 */
	public function index(){
		if($this->input->post('groups')){
			$this->manage_groups_model->save();
		}
		$groups = (new Group())->where_related_parent_group('id IS NULL')->get();
		foreach($groups AS $group){
			$group->get_child_groups();
		}
		$this->data['groups'] = $groups;
		$this->view('groups/index', $this->data);
	}
	
	
}


/* End of file manage_groups.php */
/* Location: ./modules/module/controllers/manage_groups.php */
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_groups extends SCADSY_Controller{
	var $data = array();
	public function __construct() {
		parent::__construct();
		parent::init();
		$this->load->model('manage_groups_model');
	}
	
	/**
	 * Default view
	 * - handles post-requests for deleting and saving group.
	 * - gets and shows the existing groups
	 */
	public function index(){
		if($this->input->post('delete') == 1){
			$this->manage_groups_model->delete_group();
		}
		elseif($this->input->post('name')){
			$this->manage_groups_model->save_group();
		}		
		
		$this->data['groups'] = $this->manage_groups_model->get_group_list();
		$this->view('groups/index', $this->data);
	}
	


	
}


/* End of file manage_groups.php */
/* Location: ./modules/module/controllers/manage_groups.php */
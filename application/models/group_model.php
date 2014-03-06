<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Group_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_groups(){
		return $this->db->get('group')->result();
	}
	
}


/* End of file group_model.php */
/* Location: ./application/models/group_model.php */
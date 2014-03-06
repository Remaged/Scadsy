<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration_model extends SCADSY_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	/**
	 * get_groups
	 *
	 * Gets all existing groups, returning them in a list of objects.
	 *
	 * @access	public
	 * @return	array
	 */
	public function get_groups(){
		return $this->db->get('group')->result();
	}
	
	/**
	 * get_ethnicities
	 *
	 * Gets all existing etnicities, returning them in a list of objects.
	 *
	 * @access	public
	 * @return	array
	 */
	public function get_ethnicities(){
		return $this->db->get('ethnicity')->result();
	}
	
	/**
	 * get_languages
	 *
	 * Gets all existing languages, returning them in a list of objects.
	 *
	 * @access	public
	 * @return	array
	 */
	public function get_languages(){
		return $this->db->get('language')->result();
	}
	
	/**
	 * get_grades
	 *
	 * Gets all existing grades, returning them in a list of objects.
	 *
	 * @access	public
	 * @return	array
	 */
	public function get_grades(){
		return $this->db->get('grade')->result();
	}
	
	
	
	
}


/* End of file registration_model.php */
/* Location: ./application/models/registration_model.php */
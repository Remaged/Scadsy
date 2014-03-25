<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 /**
 * Extension on the form_validation of the core.
 */ 
class SCADSY_Form_validation extends CI_Form_validation {

	/**
	 * Match one field to another
	 * Overwrites the parent-function. 
	 *
	 * @access	public
	 * @param	string
	 * @param	field
	 * @return	bool
	 */
	public function is_unique($str, $field)
	{
		list($table, $field)=explode('.', $field);
		$query = Database_manager::get_db()->limit(1)->get_where($table, array($field => $str));
		
		return $query->num_rows() === 0;
    }
}


/* End of file SCADSY_form_validation.php */
/* Location: ./application/libraries/SCADSY_form_validation.php */
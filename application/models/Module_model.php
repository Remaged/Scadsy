<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The module_model. This model is responible for communicating with the module table.
 */
class Module_model extends SCADSY_Model {
	
	/**
	 * Get the modules that have a certain status
	 * @param $status
	 * 		The status of the module. Can be 'enabled' or 'disabled'
	 * @return
	 * 		The found modules
	 */
	public function get_modules($status) {
		if($status == 'enabled' || $status == 'disabled') {
			$query = $this->db->get_where('module', array('status' => $status));
			return $query->result();
		}
		throw new Exception("Invalid status");
	}
	
}

/* End of file Module_model.php */
/* Location: ./application/models/Module_model.php */
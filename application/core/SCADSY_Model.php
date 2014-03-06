<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The main model. You should inherit from this class if you want to communicate with the database.
 */
class SCADSY_model extends CI_Model {

	/**
	 * Construct a new instance of the SCADSY_model class
	 */
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

}

/* End of file SCADSY_Model.php */
/* Location: ./application/core/SCADSY_Model.php */
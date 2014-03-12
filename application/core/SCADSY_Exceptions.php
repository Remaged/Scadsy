<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The main exceptions.
 */
class SCADSY_Exceptions extends CI_Exceptions {
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * 401 Unauthorized Handler
	 *
	 * @access	private
	 * @param	string	the page
	 * @param 	bool	log error yes/no
	 * @return	string
	 */
	function show_401($page = '', $log_error = TRUE)
	{
		$heading = "401 Unauthorized";
		$message = "You don't have the permissions to view this page.";

		// By default we log this, but allow a dev to skip it
		if ($log_error)
		{
			log_message('error', '401 Unauthorized --> '.$page);
		}

		echo $this->show_error($heading, $message, 'error_general', 401);
		exit;
	}
}

/* End of file SCADSY_Exceptions.php */
/* Location: ./application/core/SCADSY_Exceptions.php */
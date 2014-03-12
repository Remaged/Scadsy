<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 401 Page Handler
*
* This function is similar to the show_error() function .
* However, instead of the standard error template it displays
* 401 errors.
*
* @access	public
* @return	void
*/
if ( ! function_exists('show_401'))
{
	function show_401($page = 'error_general')
	{
		$_error =& load_class('Exceptions', 'core');
		
		$heading = "401 Not Authorized";
		$message = "You are not authorized to view this page. If you believe you are, please contact the system administrator.";

		$_error->show_error($heading, $message, 'error_general', 401);
		exit;
	}
}
// ------------------------------------------------------------------------

/* End of file Errors.php */
/* Location: ./application/helpers/Errors.php */
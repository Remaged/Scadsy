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
	function show_401($page = '', $log_error = TRUE)
	{
		$_error =& load_class('Exceptions', 'core');
		$_error->show_401($page, $log_error);
		exit;
	}
}
// ------------------------------------------------------------------------

/* End of file Errors.php */
/* Location: ./application/helpers/Errors.php */
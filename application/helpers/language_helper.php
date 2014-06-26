<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * __
 *
 * Fetches a language variable and returns it
 *
 * @access	public
 * @param	string	the language line
 * @return	string
 */
if ( ! function_exists('__'))
{
	function __($line)
	{
		$CI =& get_instance();
		$translation = $CI->lang->line($line);

		if($translation == '') {
			$translation = $line;
		}

		$args = func_get_args();
		if(count($args) == 1) {
			return $translation;
		}	
		
		$args[0] = $translation;
		return call_user_func_array('sprintf', $args);
	}
}

/* End of file Language_helper.php */
/* Location: ./application/helpers/Language_helper.php */
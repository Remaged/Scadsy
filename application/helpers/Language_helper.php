<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * __
 *
 * Fetches a language variable and outputs it
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
			return $line;
		}

		return $translation;
	}
}

/* End of file Language_helper.php */
/* Location: ./application/helpers/Language_helper.php */
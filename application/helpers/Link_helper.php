<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('post_link'))
{
	function post_link($page, $text, Array $data, $final = '')
	{
  		$CI =& get_instance();
		$crsf_hash = $CI->security->get_csrf_hash();
		$crsf_token = $CI->security->get_csrf_token_name();
		
		$post_jquery = "$.post('".site_url($page)."', {";
			$post_jquery .= $crsf_token.":"."'".$crsf_hash."',";
			foreach($data as $key => $value) {
				$post_jquery .= $key.":"."'".$value."',";
			}
		$post_jquery .= "}).done(function(data){";
			$post_jquery .= $final;
		$post_jquery .= "}); return false; ";
		
		return '<a href="#" onclick="'.$post_jquery.'">'.$text.'</a>';
	}
}
// ------------------------------------------------------------------------

/* End of file Link_helper.php */
/* Location: ./application/helpers/Link_helper.php */
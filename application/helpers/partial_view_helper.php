<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Loads and returns the uri, while making it look like an ajax-request thus resulting in a partial-view.
 * 
 */
if ( ! function_exists('partial_view')){
	function partial_view($uri){
		$reset_HTTP_X_REQUESTED_WITH = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? $_SERVER['HTTP_X_REQUESTED_WITH'] : NULL;
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';		
		$url = site_url($uri);
		$result = "<div data-partial_view='{$url}'>".modules::run($uri)."</div>";
		$_SERVER['HTTP_X_REQUESTED_WITH'] = $reset_HTTP_X_REQUESTED_WITH;
		return $result;
	}
}


/* End of file test_partial_view_helper.php */
/* Location: ./application/helpers/partial_view_helper.php */
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Gets a specific segment from the url.
 * @param $segment_number
 * 		number of the segment to be retrieved.
 * 		1 = module-segment
 * 		2 = controller-segment
 * 		3 = action-segment (note that this will not work for index when not specified in the url)
 * 		4 = some parameter like an id (if exists)
 * @return
 * 		segment-value
 * 
 */
if ( ! function_exists('get_uri_segment')){
	function get_uri_segment($segment_number){
		$segments = explode('/',uri_string());		
		return $segments[$segment_number-1];		
	}
}

/**
 * Gets a specific set of segments from the url
 * @param $number_of_segments
 * 		the number of segments to be retrieved
 * 		1 = /module
 * 		2 = /module/controller
 * 		3 = /module/controller/action (only if action exists in url)
 * 		4 = /module/controller/action/some_parameter (only if action and some_parameter exist)
 * @return
 * 		segment-string, starting with '/'.
 */
if ( ! function_exists('get_uri_segments')){
	function get_uri_segments($number_of_segments){
		$segments = explode('/',uri_string());
		if(count($segments) <= $number_of_segments){
			return uri_string();
		}
		$uri_string_segments = '';
		for($i = 0; $i < $number_of_segments; $i++){
			$uri_string_segments .= '/'.$segments[$i];
		}	
		return $uri_string_segments;	
	}
}

/**
 * Gets an uri, based on a given action
 * @param $action
 * 		the action to use in the uri.
 * return
 * 		uri string of the current page and given action: /module/controller/action
 */
if ( ! function_exists('site_action_uri')){
	function site_action_uri($action){
		return get_uri_segments(2).'/'.$action;	
	}
}



/* End of file SCADSY_url_helper.php */
/* Location: ./application/helpers/SCADSY_url_helper.php */
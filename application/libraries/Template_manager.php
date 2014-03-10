<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The Template_manager class. This class manages the template files.
 */
class Template_manager {
	private $scripts_header;
	private $scripts_footer;
	private $stylesheets;	

	/**
	 * Construct a new instance of the template_manager class.
	 */
	public function __construct() {
		$this->scripts_footer = array();
		$this->scripts_header = array();
		$this->stylesheets = array();
	}

	/**
	 * Add a script
	 * @param $url
	 * 		The relative url to the script.
	 * @param $header
	 * 		Whether or not the scripts should be placed in the header. If FALSE, the scripts is
	 * 		loaded in the footer
	 */
	public function add_script($url, $header = TRUE) {
		if($header === TRUE) {
			$scripts_header[] = $url;
		} else {
			$scripts_footer[] = $url;
		}
	}	
	
	/**
	 * Get the scripts
	 * @param $header
	 * 		Whether the header or footer scripts should be loaded.
	 * @param $as_html
	 * 		Whether the output should be html or just the list
	 */
	 public function get_scripts($header = TRUE) {
	 	
	 }
	
	/**
	 * Add stylesheet
	 * @param $url 
	 * 		The relative url to the stylesheet
	 */
	 public function add_stylesheet($url) {
	 	$stylesheets[] = $url;
	 }
}

/* End of file Template_manager.php */
/* Location: ./application/libraries/Template_manager.php */
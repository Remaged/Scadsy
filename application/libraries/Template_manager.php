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
	 * @param $identifier
	 * 		The identifier for the script. 
	 * @param $url
	 * 		The relative url to the script.
	 * @param $header
	 * 		Whether or not the scripts should be placed in the header. If FALSE, the scripts is
	 * 		loaded in the footer
	 */
	public function add_script($identifier, $url, $header = TRUE) {
		if($header === TRUE) {
			if(array_key_exists ($identifier, $this->scripts_header)) {
				die('<h1>Duplicate header script!</h1><br/> <strong>Identifier: </strong> '.$identifier.'<br/><strong>Url: </strong> '.$url);
			}
			
			$this->scripts_header[$identifier] = $url;
		} else {
			if(isset($this->scripts_footer[$identifier])) {
				die('<h1>Duplicate footer script!</h1><br/> <strong>Identifier: </strong> '.$identifier.'<br/><strong>Url: </strong> '.$url);
			}
						
			$this->scripts_footer[$identifier] = $url;
		}
	}	
	
	/**
	 * Get the scripts
	 * @param $header
	 * 		Whether the header or footer scripts should be loaded.
	 * @param $as_html
	 * 		Whether the output should be html or just the list
	 * @return The scripts html of the scripts list
	 */
	 public function get_scripts($header = TRUE, $as_html = TRUE) {
	 	if($header === TRUE && $as_html === TRUE) {
	 		Hook_manager::execute_hook('pre_scripts_header_generate', $this);
			$html = $this->get_scripts_html($this->scripts_header);
			Hook_manager::execute_hook('post_scripts_header_generate', $html);
			return $html;
	 	} else if ($header === FALSE && $as_html === TRUE) {
	 		Hook_manager::execute_hook('pre_scripts_footer_generate', $this);
			$html = $this->get_scripts_html($this->scripts_footer);
			Hook_manager::execute_hook('post_scripts_footer_generate', $html);
			return $html;
	 	} else if ($header === TRUE) {
	 		return $this->scripts_header;
	 	} else {
	 		return $this->scripts_footer;
	 	}
	 }

	/** 
	 * Get the scripts html
	 * @param $scripts
	 * 		The scripts to generate the html for
	 * @return The scripts html
	 */
	 public function get_scripts_html($scripts) {
	 	$html = '';
		
		foreach($scripts as $script) {
			$html .= '<script type="text/javascript" src="'.base_url($script).'"></script>';
		}
		
		return $html;
	 }
	
	/**
	 * Add stylesheet
	 * @param $identifier
	 * 		The unique identifier for the stylesheet
	 * @param $url 
	 * 		The relative url to the stylesheet
	 */
	 public function add_stylesheet($identifier, $url) {
	 	if(array_key_exists ($identifier, $this->stylesheets)) {
			die('<h1>Duplicate stylsheett!</h1><br/> <strong>Identifier: </strong> '.$identifier.'<br/><strong>Url: </strong> '.$url);
		}
	 	$this->stylesheets[$identifier] = $url;
	 }

	/**
	 * Get the stylesheets
	 * @param $as_html
	 * 		Whether or not to get the stylesheets as html. Default is TRUE
	 * @return The stylesheets html or the stylesheets array
	 */
	public function get_stylesheets($as_html = TRUE) {
		if($as_html === TRUE) {
			Hook_manager::execute_hook('pre_stylesheets_generate', $this);
			$html = $this->get_stylesheets_html();
			Hook_manager::execute_hook('post_stylesheets_generate', $html);
			return $html;
		} else {
			return $this->stylesheets;
		}
	}
	
	/**
	 * Get the stylesheets html
	 * @return The stylesheets html
	 */
	 private function get_stylesheets_html() {
	 	$html = '';
		
		foreach($this->stylesheets as $stylesheet) {
			$html .= '<link rel="stylesheet" type="text/css" href="'.base_url($stylesheet).'">';
		}
		
		return $html;
	 }
	 
}

/* End of file Template_manager.php */
/* Location: ./application/libraries/Template_manager.php */
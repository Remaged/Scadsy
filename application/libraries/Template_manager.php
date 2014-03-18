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
		
		$this->load_framework_assets();
	}
	
	/**
	 * Load the frameworks scripts and styles
	 */
	 private function load_framework_assets() {
	 	$CI =& get_instance();
		
		$scripts = $CI->config->item('template_scripts');
		$styles = $CI->config->item('template_styles');
		
		foreach($scripts as $identifier => $url) {
			$this->add_global_script($identifier, $CI->config->item('assets_location')['scripts'].'/'.$url);
		}
		
		foreach($styles as $identifier => $url) {
			$this->add_stylesheet($identifier, $CI->config->item('assets_location')['styles'].'/'.$url);
		}
	 }

	/**
	 * Add a script that always gets added to the header
	 * @param $identifier
	 * 		The identifier for the script. 
	 * @param $url
	 * 		The relative url to the script.
	 * @param $header
	 * 		Whether or not the scripts should be placed in the header. If FALSE, the scripts is
	 * 		loaded in the footer
	 */
	public function add_global_script($identifier, $url, $header = TRUE) {
		if($header === TRUE) {
			if(array_key_exists ($identifier, $this->scripts_header)) {
				die('<h1>Duplicate header script!</h1><br/> <strong>Identifier: </strong> '.$identifier.'<br/><strong>Url: </strong> '.$url);
			}
			
			$this->scripts_header[$identifier] = array("url" => $url, "type" => "global");
		} else {
			if(isset($this->scripts_footer[$identifier])) {
				die('<h1>Duplicate footer script!</h1><br/> <strong>Identifier: </strong> '.$identifier.'<br/><strong>Url: </strong> '.$url);
			}
						
			$this->scripts_footer[$identifier] = array("url" => $url, "type" => "global");
		}
	}	
	
	/**
	 * Add a script for a certain module
	 * @param $identifier
	 * 		The identifier for the script. 
	 * @param $url
	 * 		The relative url to the script.
	 * @param $module
	 * 		The module to load the script for.
	 * @param $header
	 * 		Whether or not the scripts should be placed in the header. If FALSE, the scripts is
	 * 		loaded in the footer
	 */
	public function add_module_script($identifier, $url, $module, $header = TRUE) {
		if($header === TRUE) {
			if(array_key_exists ($identifier, $this->scripts_header)) {
				die('<h1>Duplicate header script!</h1><br/> <strong>Identifier: </strong> '.$identifier.'<br/><strong>Url: </strong> '.$url);
			}
			
			$this->scripts_header[$identifier] = array("url" => $url, "type" => "module", "module" => $module);
		} else {
			if(isset($this->scripts_footer[$identifier])) {
				die('<h1>Duplicate footer script!</h1><br/> <strong>Identifier: </strong> '.$identifier.'<br/><strong>Url: </strong> '.$url);
			}
						
			$this->scripts_footer[$identifier] = array("url" => $url, "type" => "module", "module" => $module);;
		}
	}
	
		/**
	 * Add a script for a certain controller
	 * @param $identifier
	 * 		The identifier for the script. 
	 * @param $url
	 * 		The relative url to the script.
	 * @param $controller
	 * 		The controller to load the script for.
	 * @param $header
	 * 		Whether or not the scripts should be placed in the header. If FALSE, the scripts is
	 * 		loaded in the footer
	 */
	public function add_controller_script($identifier, $url, $module, $controller, $header = TRUE) {
		if($header === TRUE) {
			if(array_key_exists ($identifier, $this->scripts_header)) {
				die('<h1>Duplicate header script!</h1><br/> <strong>Identifier: </strong> '.$identifier.'<br/><strong>Url: </strong> '.$url);
			}
			
			$this->scripts_header[$identifier] = array("url" => $url, "type" => "controller", "module" => $module, "controller" => $controller);
		} else {
			if(isset($this->scripts_footer[$identifier])) {
				die('<h1>Duplicate footer script!</h1><br/> <strong>Identifier: </strong> '.$identifier.'<br/><strong>Url: </strong> '.$url);
			}
						
			$this->scripts_footer[$identifier] = array("url" => $url, "type" => "controller", "module" => $module, "controller" => $controller);
		}
	}
	
	/**
	 * Add a script for a certain method
	 * @param $identifier
	 * 		The identifier for the script. 
	 * @param $url
	 * 		The relative url to the script.
	 * @param $page
	 * 		The page to load the script for.
	 * @param $header
	 * 		Whether or not the scripts should be placed in the header. If FALSE, the scripts is
	 * 		loaded in the footer
	 */
	public function add_method_script($identifier, $url, $module, $controller, $method, $header = TRUE) {
		if($header === TRUE) {
			if(array_key_exists ($identifier, $this->scripts_header)) {
				die('<h1>Duplicate header script!</h1><br/> <strong>Identifier: </strong> '.$identifier.'<br/><strong>Url: </strong> '.$url);
			}
			
			$this->scripts_header[$identifier] = array("url" => $url, "type" => "method", "module" => $module, "controller" => $controller, "method" => $method);
		} else {
			if(isset($this->scripts_footer[$identifier])) {
				die('<h1>Duplicate footer script!</h1><br/> <strong>Identifier: </strong> '.$identifier.'<br/><strong>Url: </strong> '.$url);
			}
						
			$this->scripts_footer[$identifier] = array("url" => $url, "type" => "method", "module" => $module, "controller" => $controller, "method" => $method);
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
			$scripts = $this->get_load_scripts($this->scripts_header);
			$html = $this->get_scripts_html($scripts);
			Hook_manager::execute_hook('post_scripts_header_generate', $html);
			return $html;
	 	} else if ($header === FALSE && $as_html === TRUE) {
	 		Hook_manager::execute_hook('pre_scripts_footer_generate', $this);
			$scripts = $this->get_load_scripts($this->scripts_footer);
			$html = $this->get_scripts_html($scripts);
			Hook_manager::execute_hook('post_scripts_footer_generate', $html);
			return $html;
	 	} else if ($header === TRUE) {
	 		return $this->get_load_scripts($this->scripts_header);
	 	} else {
	 		return $this->get_load_scripts($this->scripts_footer);
	 	}
	 }
	 
	 /**
	  * Get the scripts that should get loaded
	  * @param $scripts
	  * 	All the scripts
	  * @return The scripts that should get loaded
	  */
	  private function get_load_scripts($scripts) {
	  	$CI =& get_instance();
	  	$load_scripts = array();
		
		foreach($scripts as $script) {
			if($script['type'] == 'global') {
				$load_scripts[] = $script;
			}
			
			if($script['type'] == 'module' && $CI->router->get_module() == $script['module']) {
				$load_scripts[] = $script;
			}
			
			if($script['type'] == 'controller' && $CI->router->get_module() == $script['module'] && $CI->router->fetch_class() == $script['controller'] ) {
				$load_scripts[] = $script;
			}
			
			if($script['type'] == 'method' && $CI->router->get_module() == $script['module'] && $CI->router->fetch_class() == $script['controller'] && $CI->router->fetch_method() == $script['method']) {
				$load_scripts[] = $script;
			}
		}
		
		return $load_scripts;
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
			$html .= '<script type="text/javascript" src="'.base_url($script['url']).'"></script>';
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
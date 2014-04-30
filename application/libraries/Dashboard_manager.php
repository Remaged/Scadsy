<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The dashboard_manager. This class is responsible for storing dashboard widgets.
 */
class Dashboard_manager {
	private $widgets;
	private $CI;
	
	/**
	 * Construct a new instance of the menu_manager class.
	 */
	public function __construct() {
		$this->widgets = array();
		$this->CI =& get_instance();
	}
	
	/**
	 * Add a new widget
	 * @param $page
	 * 		The page to load inside the widget
	 * @param $default_groups
	 * 		The default groups that have permission for this menu item
	 */
	public function add_widget($page, $default_groups) {		
		if($this->CI->permission_manager->has_permission($default_groups)) {
			$this->widgets[] = $page;
		}		
	}
	
	/**
	 * Get the widgets
	 * @param $as_html
	 * 		Whether or not the ouput should be given as HTML. Default is TRUE
	 * @return
	 * 		The widgets
	 */
	public function get_widgets($as_html = TRUE) {
		Hook_manager::execute_hook('pre_dashboard_generate', $this);
		if($as_html) {
			$html = $this->get_widgets_html();	
			Hook_manager::execute_hook('post_dashboard_generate', $html);		
			return $html;
		} else {
			return $this->widgets;
		}
	}
	
	/**
	 * Get the widgets as html
	 */
	 private function get_widgets_html() {
	 	$html = '';
		
		foreach($this->widgets as $widget) {
			$html .= '<div class="widget">'.modules::run($widget).'</div>';
		}
		
		return $html;
	 }
}

/* End of file Menu_manager.php */
/* Location: ./application/libraries/Menu_manager.php */
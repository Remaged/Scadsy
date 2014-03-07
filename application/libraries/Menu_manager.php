<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The menu_manager. This class is responsible for storing menu items and generating menu's.
 */
class Menu_manager {
	private $menu_items;
	private $submenu_items;
	
	/**
	 * Construct a new instance of the menu_manager class.
	 */
	public function __construct() {
		$this->menu_items = array();
		$this->submenu_items = array();
	}
	
	/**
	 * Add a new menu item to the menu
	 * @param $link
	 * 		The link to the page (for example: welcome/index)
	 * @param $description
	 * 		The description of the link (for example: "home")
	 * @param $default_groups
	 * 		The default groups that have permission for this menu item
	 * @param $priority
	 * 		Optional, the priority for the menu item
	 */
	public function add_menu_item($link, $description, $default_groups, $priority = 10) {
		$CI =& get_instance();
		
		$exploded = explode('/', $link);
		
		if($CI->permission_manager->check_permissions($exploded[1], $exploded[0], $default_groups)) {
			$this->menu_items[$priority][$link] = $description;
		}		
	}
	
	/**
	 * Add a new submenu item to the menu
	 * @param $parent
	 * 		The link of the parent menu item
	 * @param $link
	 * 		The link to the page (for example: welcome/index)
	 * @param $description
	 * 		The description of the link (for example: "home")
	 */
	public function add_submenu_item($parent, $link, $description, $default_groups) {
		$CI =& get_instance();
		
		$exploded = explode('/', $link);
		
		if($CI->permission_manager->check_permissions($exploded[1], $exploded[0], $default_groups)) {
			$this->submenu_items[$parent][$link] = $description;		
		}
	}
	
	/**
	 * Get the menu
	 * @param $as_html
	 * 		Whether or not the ouput should be given as HTML. Default is TRUE
	 * @return
	 * 		The menu
	 */
	public function get_menu($as_html = TRUE) {
		if($as_html) {			
			return $this->get_menu_html();
		} else {
			return $this->menu_items;
		}
	}
	
	/**
	 * Get the menu as html
	 */
	 private function get_menu_html() {
	 	$html = '<ul class="main_menu">';
		for($i = 0; $i < 11; $i++) {
			if(isset($this->menu_items[$i])) {
				foreach($this->menu_items[$i] as $key => $value) {
					$html .= '<li>';
					$html .= anchor($key, $value);
					$html .= $this->get_submenu_html($key);
					$html .= '</li>';
				}
			}
		}
		$html .= '</ul>';
		return $html;
	 }
	 
	 /**
	  * Get the submenu html for a link
	  * @param $link
	  * 		The link to find the child menu items for
	  * @param $depth
	  * 		The depth of the current submenu
	  * @return
	  * 		The generated submenu html
	  */
	 private function get_submenu_html($link, $depth = 0) {
	 	$html = '';
	 	if(isset($this->submenu_items[$link])) {
	 		$html .= '<ul class="sub_menu sub_menu_'. $depth++ .'">';
	 		foreach($this->submenu_items[$link] as $key => $value) {
	 			$html .= '<li>';
				$html .= anchor($key, $value);
				$html .= $this->get_submenu_html($key, $depth);
				$html .= '</li>';
	 		}
			$html .= '</ul>';
	 	}
		return $html;
	 }
}

/* End of file Menu_manager.php */
/* Location: ./application/libraries/Menu_manager.php */
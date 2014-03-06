<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The menu_manager. This class is responsible for storing menu items and generating menu's.
 */
class Menu_manager {
	private $menu_items;
	
	/**
	 * Construct a new instance of the menu_manager class.
	 */
	public function __construct() {
		$this->menu_items = array();
	}
	
	/**
	 * Add a new menu item to the menu
	 * @param $link
	 * 		The link to the page (for example: welcome/index)
	 * @param $description
	 * 		The description of the link (for example: "home")
	 * @param $priority
	 * 		Optional, the priority for the menu item
	 * @param $parent
	 * 		The link of the parent menu item
	 */
	public function add_menu_item($link, $description, $priority = 10, $parent = '') {
		$this->menu_items[$priority][$link] = $description;
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
			$html = '<ul class="main_menu">';
			for($i = 0; $i < 11; $i++) {
				if(isset($this->menu_items[$i])) {
					foreach($this->menu_items[$i] as $key => $value) {
						$html .= '<li>';
						$html .= anchor($key, $value);
						$html .= '</li>';
					}
				}
			}
			$html .= '</ul>';
			return $html;
		} else {
			return $this->menu_items;
		}
	}
}

/* End of file Menu_manager.php */
/* Location: ./application/libraries/Menu_manager.php */
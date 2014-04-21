<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The menu_manager. This class is responsible for storing menu items and generating menu's.
 */
class Menu_manager {
	private $menu_items;
	private $submenu_items;
	private $CI;
	
	/**
	 * Construct a new instance of the menu_manager class.
	 */
	public function __construct() {
		$this->menu_items = array();
		$this->submenu_items = array();
		$this->CI =& get_instance();
		$this->load_template_menu();
	}
	
	/**
	 * Load the template menu items
	 */
	 private function load_template_menu() {		
		foreach($this->CI->config->item('template_menu') as $item) {
			if(isset($item["parent"])) {
				$this->add_submenu_item($item['parent'], $item['link'], $item['description'], $item['default_groups']);
			} else {
				$this->add_menu_item($item['link'], $item['description'], $item['default_groups'], $item['priority']);
			}			
		}
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
		$exploded = explode('/', $link);
		
		if(count($exploded) == 2) {
			$exploded[] = $exploded[1];
			$exploded[1] = $exploded[0];
		}

		if($this->CI->permission_manager->check_permissions($exploded[2], $exploded[1], $exploded[0], $default_groups)) {
			$this->menu_items[$priority][$link] = array("description" => $description);
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
		$exploded = explode('/', $link);
		
		if(count($exploded) == 2) {
			$exploded[] = $exploded[1];
			$exploded[1] = $exploded[0];
		}

		if($this->CI->permission_manager->check_permissions($exploded[2], $exploded[1], $exploded[0], $default_groups)) {
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
		Hook_manager::execute_hook('pre_menu_generate', $this);
		if($as_html) {
			$html = $this->get_menu_html();	
			Hook_manager::execute_hook('post_menu_generate', $html);		
			return $html;
		} else {
			return $this->menu_items;
		}
	}
	
	/**
	 * Get the menu as html
	 */
	 private function get_menu_html() {
	 	$html = '<ul id="sc-main-menu">';
		for($i = 0; $i <= 11; $i++) {
			if(isset($this->menu_items[$i])) {
				foreach($this->menu_items[$i] as $key => $value) {
					$html .= '<li>';
					$style = 'side';
					$module = explode('/', $key)[0];
					
					$icon = '<img class="normal" src="'.base_url('modules/').'/'.$module.'/assets/images/icon_24.png" /><img class="hover" src="'.base_url('modules/').'/'.$module.'/assets/images/icon_24_hover.png" /><img class="active" src="'.base_url('modules/').'/'.$module.'/assets/images/icon_24_active.png" />';
					if($this->is_active($key)) {
						$html .= anchor($key, $icon.'<span>'.$value['description'].'</span>', "class='active active-main'");
						$style = 'down';
					} else if($this->has_active_child($key)) {
						$html .= anchor($key, $icon.'<span>'.$value['description'].'</span>', "class='active-child'");
						$style = 'down';
					} else {
						$html .= anchor($key, $icon.'<span>'.$value['description'].'</span>');
					}
					$html .= $this->get_submenu_html($key, $style);
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
	 private function get_submenu_html($link, $style = 'side') {
	 	$html = '';
	 	if(isset($this->submenu_items[$link])) {
	 		$html .= '<ul class="sc-sub-menu '.$style.'">';
	 		foreach($this->submenu_items[$link] as $key => $value) {
	 			$html .= '<li>';
				if($this->is_active($key)) {
					$html .= anchor($key, '<span>'.$value.'</span>', "class='active active-sub'");
				} else {
					$html .= anchor($key, '<span>'.$value.'</span>');
				}
				//$html .= $this->get_submenu_html($key, $depth);
				$html .= '</li>';
	 		}
			$html .= '</ul>';
	 	}
		return $html;
	 }
	 
	 /**
	  * Check if a certain menu_item is currently active
	  * @param $link
	  * 		The menu link to check
	  * @return 
	  * 		Whether or not the menu_item is active
	  */
	  private function is_active($link) {
		return $this->CI->router->get_module().'/'.$this->CI->router->fetch_class().'/'.$this->CI->router->fetch_method() == $link;
	  }
	  
	  	 /**
	  * Check if a child of a certain menu_item is currently active
	  * @param $link
	  * 		The menu link to check
	  * @return 
	  * 		Whether or not the menu_item is active
	  */
	  private function has_active_child($link) {
		if(!isset($this->submenu_items[$link])) {
			return false;
		}	
		
		foreach($this->submenu_items[$link] as $key => $value) {

			if($this->is_active($key)) {
				return true;
			}
		}
		
		return false;
	  }
}

/* End of file Menu_manager.php */
/* Location: ./application/libraries/Menu_manager.php */
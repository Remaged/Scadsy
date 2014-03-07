<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Hook_manager::init();

/**
 * The hook_manager class. This class is responsible for accepting and executing hooks.
 */
class Hook_manager {
	static $hooks = array();
	
	/**
	 * Init the hook manager.
	 */
	public static function init() {
		$CI =& get_instance();
		$CI->config->load('hooks');
		
		foreach($CI->config->item('system_hooks') as $tag) {
			self::set_hook($tag);
		}	
	}
	
	/**
	 * Set a hook
	 * @param $tag
	 * 		The tag for the hook
	 */
	public static function set_hook($tag) {
		self::$hooks [$tag] = '';
	}

	/**
	 * Set hooks
	 * @param $tags
	 * 		The tags for the hooks
	 */
	public static function set_hooks($tags) {
		foreach ( $tags as $tag ) {
			self::set_hook ( $tag );
		}
	}
	
	/**
	 * Unset a hook
	 * @param $tag
	 * 		The hook to unset
	 */
	public static function unset_hook($tag) {
		unset ( self::$hooks [$tag] );
	}

	/**
	 * Unset hooks
	 * @param $tags
	 * 		The hooks to unset
	 */
	public static function unset_hooks($tags) {
		foreach ( $tags as $tag ) {
			self::unset_hook ( $tag );
		}
	}
	
	/**
	 * Add a hook
	 * @param $tag
	 * 		The hook to add this functionality to
	 * @param $function
	 * 		The function to execute
	 * @param $priority
	 * 		Optional, the priority of this hook. Default is 10, max is 20
	 */
	public static function add_hook($tag, $function, $priority = 10) {
		if (! isset ( self::$hooks [$tag] )) {
			die ( "There is no such place ($tag) for hooks." );
		} else {
			self::$hooks [$tag] [$priority] [] = $function;
		}
	}
	
	/**
	 * Check whether or not a hook exists
	 * @param $tag
	 * 		The hook to check
	 * @return
	 * 		Whether or not the hook exists
	 */
	public static function hook_exist($tag) {
		return (trim ( self::$hooks [$tag] ) == "") ? FALSE : TRUE;
	}
	
	/**
	 * Execute a hook
	 * @param $tag
	 * 		The hook to execute
	 * @param $args
	 * 		Optional, The arguments required by this hook.
	 */
	public static function execute_hook($tag, &$args = '') {
		if (isset ( self::$hooks [$tag] )) {
			$these_hooks = self::$hooks [$tag];
			for($i = 0; $i <= 20; $i ++) {
				if (isset ( $these_hooks [$i] )) {
					foreach ( $these_hooks [$i] as $hook ) {
						call_user_func_array ( $hook, array(&$args) );
					}
				}
			}
		} else {
			die ( "There is no such place ($tag) for hooks." );
		}
	}
}

/* End of file Hook_manager.php */
/* Location: ./application/libraries/Hook_manager.php */
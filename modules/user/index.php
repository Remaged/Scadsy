<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: User
Module Permissions: admin
Module URI: 
Description: Handling users, like login, logout, registrating users, edititing user information.
Version: 1.0
Author: Kevin Driessen
Author URI: http://kevindriessen.nl
*/


Hook_manager::add_hook('pre_menu_generate', 'user_pre_menu_generated');
function user_pre_menu_generated($menu_manager) {
	$CI =& get_instance();
	$menu_manager->add_menu_item('user/registration/index', 'Add user', array('admin'), 10);
	//$menu_manager->add_menu_item('user/login/logout', 'Logout', array('admin', 'student', 'teacher', 'parent'));
}



/* End of file index.php */
/* Location: ./modules/user/index.php */
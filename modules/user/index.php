<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: User
Module Permissions: all groups
Module URI: 
Description: Handling users, like login, logout, registrating users, edititing user information.
Version: 1.0
Author: Kevin Driessen
Author URI: http://kevindriessen.nl
*/


Hook_manager::add_hook('pre_menu_generate', 'user_pre_menu_generated');
function user_pre_menu_generated($menu_manager) {
	$CI =& get_instance();
	$user = $CI->user_model->get_logged_in_user();	
	if($user !== NULL){
		$menu_manager->add_menu_item('user/login/index', 'Logged in: '. $user->username, array('admin'),11);
		$menu_manager->add_submenu_item('user/login/index','user/login/logout', 'Logout', array());
	}
	else{
		$menu_manager->add_menu_item('user/login/index', 'Login', array());
	}	
	$menu_manager->add_menu_item('user/registration/index', 'Add user', array('admin'),10);
}



/* End of file index.php */
/* Location: ./modules/user/index.php */
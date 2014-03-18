<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Login
Module Permissions: all groups
Module URI: 
Description: This module allows users to log in into the school
Version: 1.0
Author: 
Author 
*/


Hook_manager::add_hook('pre_menu_generate', 'logout_pre_menu_generated');
function logout_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('login/login/logout', 'Logout', NULL);
	$menu_manager->add_menu_item('login/login/index', 'Login', NULL);
}



/* End of file index.php */
/* Location: ./modules/login/index.php */
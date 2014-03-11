<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Login
Module Permissions: admin
Module URI: http://seoduct.com/login_manager/
Description: Alternate login-functionality to overwrite the existing login-functionality
Version: 1.0
Author: Kevin Driessen
Author URI: http://www.seoduct.com/
*/

Hook_manager::add_hook('pre_menu_generate', 'login_pre_menu_generated');

function login_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('login/index', 'Login', array('admin'));
}



/* End of file index.php */
/* Location: ./modules/login/index.php */
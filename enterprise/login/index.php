<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Login
Module Permissions: admin, student, teacher
Module URI: -
Description: -
Version: 1.0
Author: Kevin Driessen
Author URI: http://kevindriessen.nl
*/

Hook_manager::add_hook('pre_menu_generate', 'login_pre_menu_generated');

function login_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('login/index', 'Login', array('admin','student','teacher'));
}



/* End of file index.php */
/* Location: ./enterprise/login/index.php */
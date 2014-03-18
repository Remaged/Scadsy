<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Registration
Module Permissions: 
Module URI: 
Description: T
Version: 1.0
Author: -
Author URI: -
*/

Hook_manager::add_hook('pre_menu_generate', 'registration_pre_menu_generated');
function registration_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('registration/registration/index', 'Registration', array('admin'));
}


/* End of file index.php */
/* Location: ./modules/registration/index.php */
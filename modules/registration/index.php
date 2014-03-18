<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Registration
Module Permissions: admin
Module URI: 
Description: Allows to add users to the school.
Version: 1.0
Author: Kevin Driessen
Author URI: http://kevindriessen.nl
*/

Hook_manager::add_hook('pre_menu_generate', 'registration_pre_menu_generated');
function registration_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('registration/registration/index', 'Registration', array('admin'));
}


/* End of file index.php */
/* Location: ./modules/registration/index.php */
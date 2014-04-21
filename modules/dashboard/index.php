<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Dashboard
Module Permissions: admin
Module URI: 
Description: This module enables the dashboard system.
Version: 1.0
Author: -
Author URI: -
*/

Hook_manager::add_hook('pre_menu_generate', 'dashboard_pre_menu_generated');
function dashboard_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('dashboard/dashboard/index', 'Dashboard', array('admin'), 1);
}





/* End of file index.php */
/* Location: ./modules/dashboard/index.php */
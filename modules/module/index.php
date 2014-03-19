<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Module
Module Permissions: admin
Module URI: 
Description: This module allows the school-admin to manage the modules inside the schoolsystem.
Version: 1.0
Author: -
Author URI: -
*/

Hook_manager::add_hook('pre_menu_generate', 'module_pre_menu_generated');
function module_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('module/module/index', 'Module', array('admin'));
	$menu_manager->add_submenu_item('module/module/index','module/module/permissions', 'Permissions', array('admin', 'teacher'));
}





/* End of file index.php */
/* Location: ./modules/module/index.php */
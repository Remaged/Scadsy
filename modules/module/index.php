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
	$menu_manager->add_menu_item('module/manage_modules/index', 'Module', array('admin'));
	$menu_manager->add_submenu_item('module/manage_modules/index','module/manage_modules/index', 'Overview', array('admin', 'teacher'));
	$menu_manager->add_submenu_item('module/manage_modules/index','module/manage_modules/permissions', 'Permissions', array('admin', 'teacher'));
}


Hook_manager::add_hook('pre_scripts_header_generate', 'module_pre_scripts_header_generated');
function module_pre_scripts_header_generated($template_manager) {
	$template_manager->add_method_script('module_list_js_script','modules/module/assets/scripts/module_list.js','module','manage_modules','index');	
}

Hook_manager::add_hook('pre_scripts_header_generate', 'module_permissions_pre_scripts_header_generated');
function module_permissions_pre_scripts_header_generated($template_manager) {
	$template_manager->add_method_script('permission_list_js_script','modules/module/assets/scripts/permission_list.js','module','manage_modules','permissions',TRUE);			
}

		



/* End of file index.php */
/* Location: ./modules/module/index.php */
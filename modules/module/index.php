<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Module
Module Permissions: admin
Module URI: 
Description: This module enables school-management for modules, permissions, groups, users
Version: 1.0
Author: Kevin Driessen, Bob van den Berge
Author URI: -
*/

Hook_manager::add_hook('pre_menu_generate', 'module_pre_menu_generated');
function module_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('module/manage_modules/index', 'Manage');
	$menu_manager->add_submenu_item('module/manage_modules/index','module/manage_modules/index', 'Modules');
	$menu_manager->add_submenu_item('module/manage_modules/index','module/manage_permissions/index', 'Permissions');
	$menu_manager->add_submenu_item('module/manage_modules/index','module/manage_users/index', 'Users');
}

Hook_manager::add_hook('pre_scripts_header_generate', 'module_pre_scripts_header_generated');
function module_pre_scripts_header_generated($template_manager) {
	$template_manager->add_method_script('module_list_js_script','modules/module/assets/scripts/module_list.js','module','manage_modules','index');	
	$template_manager->add_method_script('permission_list_js_script','modules/module/assets/scripts/permission_list.js','module','manage_permissions','index');	
	$template_manager->add_controller_script('user_info_handler_js_script','modules/module/assets/scripts/user_info_handler.js','module','manage_users');	
	}

Hook_manager::add_hook('pre_stylesheets_generate', 'module_pre_stylesheets_generate');
function module_pre_stylesheets_generate($template_manager) {
	$template_manager->add_stylesheet('manage_permissions_style','modules/module/assets/styles/permission_style.css');	
	$template_manager->add_stylesheet('manage_users_style','modules/module/assets/styles/user_info_form.css');	
}


/* End of file index.php */
/* Location: ./modules/module/index.php */
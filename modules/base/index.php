<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Base
Module Permissions: admin
Module URI: 
Description: This module enables school-management for modules, permissions, groups, users
Version: 1.0
Author: Kevin Driessen, Bob van den Berge
Author URI: -
*/

Hook_manager::add_hook('pre_menu_generate', 'base_pre_menu_generate');
function base_pre_menu_generate($menu_manager) {
	$menu_manager->add_menu_item('base/manage_modules/index', 'Manage');
	$menu_manager->add_submenu_item('base/manage_modules/index','base/manage_modules/index', 'Modules');
	$menu_manager->add_submenu_item('base/manage_modules/index','base/manage_groups/index', 'Groups');
	$menu_manager->add_submenu_item('base/manage_modules/index','base/manage_permissions/index', 'Permissions');
	$menu_manager->add_submenu_item('base/manage_modules/index','base/manage_users/index', 'Users');
}

Hook_manager::add_hook('pre_scripts_header_generate', 'base_pre_scripts_header_generate');
function base_pre_scripts_header_generate($template_manager) {
	$template_manager->add_method_script('module_list_js_script','modules/base/assets/scripts/module_list.js','base','manage_modules','index');	
	$template_manager->add_method_script('permission_list_js_script','modules/base/assets/scripts/permission_list.js','base','manage_permissions','index');	
	$template_manager->add_controller_script('user_info_handler_js_script','modules/base/assets/scripts/user_info_handler.js','base','manage_users');	
	$template_manager->add_controller_script('manage_groups_js_script','modules/base/assets/scripts/manage_groups.js','base','manage_groups');	
	
}

Hook_manager::add_hook('pre_stylesheets_generate', 'base_pre_stylesheets_generate');
function base_pre_stylesheets_generate($template_manager) {
	$template_manager->add_stylesheet('manage_permissions_style','modules/base/assets/styles/permission_style.css');	
	$template_manager->add_stylesheet('manage_users_style','modules/base/assets/styles/user_info_form.css');
	$template_manager->add_stylesheet('manage_groups','modules/base/assets/styles/manage_groups.css');	
}


/* End of file index.php */
/* Location: ./modules/base/index.php */
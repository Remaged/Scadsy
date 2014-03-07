<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Module Manager
Module Permissions: admin
Module URI: http://seoduct.com/module_manager/
Description: This is a module manager.
Version: 1.0
Author: Bob van den Berge
Author URI: http://www.seoduct.com/
*/

Hook_manager::add_hook('pre_menu_generate', 'module_pre_menu_generated');

function module_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('module/index', 'Modules', array('admin'));
}

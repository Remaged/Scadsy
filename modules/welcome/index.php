<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Welcome Module
Module Permissions: student, admin
Module URI: http://seoduct.com/welcome_module/
Description: This is a welcome module.
Version: 1.0
Author: Bob van den Berge
Author URI: http://www.seoduct.com/
*/

Hook_manager::add_hook('pre_menu_generate', 'welcome_pre_menu_generated');
function welcome_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('welcome/index', 'Welcome', array('user', 'admin'));
}

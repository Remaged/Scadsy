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
	$menu_manager->add_menu_item('welcome/index', 'Welcome', array('student', 'admin'));
}

Hook_manager::add_hook('pre_scripts_header_generate', 'welcome_pre_scripts_header_generated');
function welcome_pre_scripts_header_generated($template_manager) {
	//$template_manager->add_script('welcome_test_script_header', 'modules/welcome/assets/scripts/header.js');
}

Hook_manager::add_hook('pre_scripts_footer_generate', 'welcome_pre_scripts_footer_generated');
function welcome_pre_scripts_footer_generated($template_manager) {
	//$template_manager->add_script('welcome_test_script_footer', 'modules/welcome/assets/scripts/footer.js', FALSE);
}

Hook_manager::add_hook('pre_stylesheets_generate', 'welcome_pre_stylesheets_generated');
function welcome_pre_stylesheets_generated($template_manager) {
	//$template_manager->add_stylesheet('welcome_stylesheet', 'modules/welcome/assets/style/style.css');
}
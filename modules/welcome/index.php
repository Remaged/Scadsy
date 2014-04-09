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
	$menu_manager->add_menu_item('welcome/welcome/index', 'Welcome', array('admin'),1);
}

Hook_manager::add_hook('pre_scripts_header_generate', 'welcome_pre_scripts_header_generated');
function welcome_pre_scripts_header_generated($template_manager) {
	//$template_manager->add_module_script('welcome_test_script_header', 'modules/welcome/assets/scripts/header.js', "welcome");
}

Hook_manager::add_hook('pre_scripts_footer_generate', 'welcome_pre_scripts_footer_generated');
function welcome_pre_scripts_footer_generated($template_manager) {
	//$template_manager->add_method_script('welcome_test_script_footer', 'modules/welcome/assets/scripts/footer.js', "welcome", "welcome", "index", FALSE);
}

Hook_manager::add_hook('pre_stylesheets_generate', 'welcome_pre_stylesheets_generated');
function welcome_pre_stylesheets_generated($template_manager) {
	$template_manager->add_stylesheet('welcome_stylesheet', 'modules/welcome/assets/style/style.css');
}

//Just an example for adding extra fields to a form using hooks.
Hook_manager::add_hook('pre_form_fields_generate', 'add_extra_fields_to_welcome_form');
function add_extra_fields_to_welcome_form($form_manager){
	$form_manager->add_fields('some_test_fields',array(
		form_label_input('some_test')
	),"callback_add_fields");
}

function callback_add_fields($postdata){
	echo 'result = '.$postdata['some_test'];
	exit();
}



/* End of file index.php */
/* Location: ./modules/welcome/index.php */
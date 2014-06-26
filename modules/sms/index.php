<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: SMS
Module Permissions: admin
Module URI: 
Description: Makes sms-communication between school and users possible. This modules relies on the 'primary school' module.
Version: 1.0
Author: Kevin Driessen
Author URI: http://kevindriessen.nl
*/



Hook_manager::add_hook('pre_menu_generate', 'sms_pre_menu_generated');
function sms_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('sms/sms_messager/index', 'SMS');
	$menu_manager->add_submenu_item('sms/sms_messager/index','sms/sms_messager/index', 'Overview');
	$menu_manager->add_submenu_item('sms/sms_messager/index','sms/sms_messager/new_sms', 'New SMS');
}

Hook_manager::add_hook('pre_scripts_header_generate', 'sms_pre_scripts_header_generated');
function sms_pre_scripts_header_generated($template_manager) {
	$template_manager->add_controller_script('sms_js_script','modules/sms/assets/scripts/sms.js','sms','sms_messager');	
}

Hook_manager::add_hook('pre_stylesheets_generate', 'sms_pre_stylesheets_generate');
function sms_pre_stylesheets_generate($template_manager) {
	$template_manager->add_stylesheet('sms_style','modules/sms/assets/styles/sms.css');	
}



/* End of file index.php */
/* Location: ./modules/module/index.php */
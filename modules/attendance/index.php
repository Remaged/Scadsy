<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Attendance
Module Permissions: admin, teachers
Module URI: 
Description: This module enables schools to register student attendance
Version: 1.0
Author: Bob van den Berge
Author URI: -
*/


Hook_manager::add_hook('pre_menu_generate', 'attendance_pre_menu_generated');
function attendance_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('attendance/monitor/check', 'Attendance');
	$menu_manager->add_submenu_item('attendance/monitor/check','attendance/monitor/check', 'Check');
	$menu_manager->add_submenu_item('attendance/monitor/check','attendance/monitor/overview', 'Overview');
}

Hook_manager::add_hook('pre_stylesheets_generate', 'attendance_pre_stylesheets_generate');
function attendance_pre_stylesheets_generate($template_manager) {
	$template_manager->add_stylesheet("attendance_css", "modules/attendance/assets/styles/attendance.css"); 
}

Hook_manager::add_hook('pre_scripts_header_generate', 'attendance_pre_scripts_header_generate');
function attendance_pre_scripts_header_generate($template_manager) {
	$template_manager->add_method_script("attendance_scripts", "modules/attendance/assets/scripts/attendance.js", "attendance", "monitor", "check", FALSE); 
}

Hook_manager::add_hook('pre_dashboard_generate', 'attendance_pre_dashboard_generate');
function attendance_pre_dashboard_generate($dashboard_manager) {
	$dashboard_manager->add_widget("attendance/monitor/widget");
}

/* End of file index.php */
/* Location: ./modules/attendance/index.php */
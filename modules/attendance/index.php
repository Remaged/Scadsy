<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Attendance
Module Permissions: admin, teachers
Module URI: 
Description: This module enables schools to register student attendance
Version: 1.0
Author: Kevin Driessen, Bob van den Berge
Author URI: -
*/

Hook_manager::add_hook('pre_menu_generate', 'attendance_pre_menu_generated');
function attendance_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('attendance/monitor/index', 'Attendance');
	$menu_manager->add_submenu_item('attendance/monitor/index','attendance/monitor/index', 'Check');
}


/* End of file index.php */
/* Location: ./modules/module/index.php */
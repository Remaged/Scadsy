<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Attendance monitor
Module Permissions: teacher, admin
Module URI: http://seoduct.com/attendance_monitor/
Description: This module allows teachers to monitor the attendance of students
Version: 1.0
Author: Bob van den Berge
Author URI: http://www.seoduct.com/
*/

Hook_manager::add_hook('pre_menu_generate', 'attendance_pre_menu_generated');

function attendance_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('attendance/attendance/index', 'Attendance', array('admin', 'teacher'));
	$menu_manager->add_submenu_item('attendance/attendance/index','attendance/scheme/index', 'Scheme', array('admin', 'teacher'));
	$menu_manager->add_submenu_item('attendance/attendance/index','attendance/scheme/something', 'Something', array('admin', 'teacher'));
}

/* End of file index.php */
/* Location: ./modules/attendance/index.php */
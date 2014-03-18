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

Hook_manager::add_hook('pre_menu_generate', 'module_pre_menu_generated');
function module_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('module/module/index', 'Module', array('admin'));
	$menu_manager->add_submenu_item('module/module/index','module/module/permissions', 'Permissions', array('admin', 'teacher'));
}





/* End of file index.php */
/* Location: ./modules/module/index.php */
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Primary school
Module Permissions: admin
Module URI: 
Description: This module is an alternate version for the manage_users. It enables to manage students in a more simple way. Note: the group 'student' should exist. Subgroups of student are considered as grades by this module.
Version: 1.0
Author: Kevin Driessen
Author URI: -
*/

Hook_manager::add_hook('pre_menu_generate', 'primary_school_pre_menu_generated');
function primary_school_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('primary_school/manage_students/index', 'Manage students');
	$menu_manager->add_submenu_item('primary_school/manage_students/index','primary_school/manage_students/add', 'Add student');
}

Hook_manager::add_hook('pre_scripts_header_generate', 'primary_school_pre_scripts_header_generated');
function primary_school_pre_scripts_header_generated($template_manager) {
	$template_manager->add_controller_script('primary_school_form_js_script','modules/primary_school/assets/scripts/student_form.js','primary_school','manage_students');	
	//$template_manager->add_controller_script('manage_groups_js_script','modules/module/assets/scripts/manage_groups.js','module','manage_groups');	
}

Hook_manager::add_hook('pre_stylesheets_generate', 'primary_school_pre_stylesheets_generate');
function primary_school_pre_stylesheets_generate($template_manager) {
	$template_manager->add_stylesheet('primary_school_style','modules/primary_school/assets/styles/student_list.css');
}


/* End of file primary_school.php */
/* Location: ./modules/module/primary_school.php */
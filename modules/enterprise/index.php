<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Enterprise
Module Permissions: admin, student, teacher
Module URI: -
Description: ENTERPRISE-module for the SCADSY-system. This module enables using multiple schools that can be managed by an superadmin.
Version: 1.0
Author: Kevin Driessen
Author URI: http://kevindriessen.nl
*/

Hook_manager::add_hook('pre_menu_generate', 'admin_pre_menu_generated');

function admin_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('admin/index', 'Admin', array('admin'));
}



/* End of file index.php */
/* Location: ./modules/enterprise/index.php */
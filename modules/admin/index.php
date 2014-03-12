<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Admin
Module Permissions: admin
Module URI: -
Description: Admin-module for the ENTERPRISE-version. It allows the super-admin to manage modules for all schools.
Version: 1.0
Author: Kevin Driessen
Author URI: http://kevindriessen.nl
*/

Hook_manager::add_hook('pre_menu_generate', 'admin_pre_menu_generated');

function admin_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('admin/index', 'Admin', array('admin'));
}



/* End of file index.php */
/* Location: ./modules/admin/index.php */
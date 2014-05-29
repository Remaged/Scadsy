<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Import
Module Permissions: admin
Module URI: 
Description: This module enables schools to import students from csv files
Version: 1.0
Author: Kevin Driessen, Bob van den Berge
Author URI: -
*/

Hook_manager::add_hook('pre_menu_generate', 'import_pre_menu_generated');
function import_pre_menu_generated($menu_manager) {
	$menu_manager->add_menu_item('import/importer/index', 'Import');
	$menu_manager->add_submenu_item('import/importer/index','import/importer/index', 'Import students');
}


/* End of file index.php */
/* Location: ./modules/module/index.php */
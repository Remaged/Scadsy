<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Update Module
Module Permissions: admin
Module URI: http://seoduct.com/update_module/
Description: This is the update module. This module allowes you to let SCADSY update when there is a new version available. This way you don't have to manually keep track of all the new versions. This plugin also allows plugins to be updated.
Version: 1.0
Author: Bob van den Berge
Author URI: http://www.seoduct.com/
*/

// Pre-load update class because otherwise the hook can't
// call it functions
include_once("models/update.php");

Hook_manager::add_hook('pre_notifications_generate', 'Update::check_for_updates');

Hook_manager::add_hook('pre_menu_generate', 'update_pre_menu_generated');

function update_pre_menu_generated($menu_manager) {
	$menu_manager->add_submenu_item('dashboard/dashboard/index','update/updates/index', __('Updates'), array('admin'));
}

/* End of file index.php */
/* Location: ./modules/update/index.php */
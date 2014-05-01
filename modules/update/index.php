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

Hook_manager::add_hook('pre_notifications_generate', 'UpdateCallbacks::check_for_updates');

Hook_manager::add_hook('pre_menu_generate', 'UpdateCallbacks::pre_menu_generated');

Hook_manager::add_hook('pre_dashboard_generate', 'UpdateCallbacks::pre_dashboard_generate');

/* End of file index.php */
/* Location: ./modules/update/index.php */
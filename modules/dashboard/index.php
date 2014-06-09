<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Dashboard
Module Permissions: admin
Module URI: 
Description: This module enables the dashboard system.
Version: 1.0
Author: -
Author URI: -
*/

Hook_manager::add_hook('pre_menu_generate', 'DashboardCallbacks::pre_menu_generate');


/* End of file index.php */
/* Location: ./modules/dashboard/index.php */
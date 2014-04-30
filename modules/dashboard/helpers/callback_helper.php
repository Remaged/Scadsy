<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DashboardCallbacks {
	
	public static function pre_menu_generate($menu_manager) {
		$menu_manager->add_menu_item('dashboard/dashboard/index', 'Dashboard', array('admin'), 1);
	}
	
	public static function pre_dashboard_generate($dashboard_manager) {
		$dashboard_manager->add_widget('dashboard/dashboard/exampleWidget', 'admin');
	}
}

/* End of file callback_helper.php */
/* Location: ./modules/dashboard/helpers/callback_helper.php */
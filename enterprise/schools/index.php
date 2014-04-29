<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Module Name: Schools
Module Permissions: (enterprise-)admin
Module URI: -
Description: managing of schools; view/add/edit/delete schools
Version: 1.0
Author: Kevin Driessen
Author URI: http://kevindriessen.nl
*/

Hook_manager::add_hook('pre_menu_generate', 'school_manager_pre_menu_generated');
function school_manager_pre_menu_generated($menu_manager) {
	$CI =& get_instance();
	$user = $CI->user->get_by_logged_in();	
	if($user !== NULL){
		$menu_manager->add_menu_item('schools/manage/index', 'Schools', array());
		$menu_manager->add_submenu_item('schools/manage/index','schools/manage/add', 'Add', array());
	}
	else{
		$menu_manager->add_menu_item('user/login/index', 'Login', array());
	}	
}

/* End of file index.php */
/* Location: ./enterprise/login/index.php */
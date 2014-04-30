<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
*/

$config['system_hooks'] = array(
		"pre_menu_generate", 				// Before the html menu is generated (params: $menu_manager)
		"post_menu_generate", 				// After the html is generated (params: $html)
		"pre_scripts_header_generate", 		// Before the header scripts are generated (params: $template_manager)
		"post_scripts_header_generate", 	// After the header scripts are generated (param: $html)
		"pre_scripts_footer_generate", 		// Before the header scripts are generated (params: $template_manager)
		"post_scripts_footer_generate", 	// After the header scripts are generated (param: $html)
		"pre_stylesheets_generate",			// Before the stylesheet links are generated (param: $template_manager)
		"post_stylesheets_generate", 		// After the stylesheet link are generated (param: $html)
		"modules_loaded", 					// After all modules (index files) have loaded (param: $form_manager)
		"pre_notifications_generate", 		// Before the html notifications are generated (params: $notification_manager)
		"post_notifications_generate", 		// After the html is generated (params: $html)
		"pre_dashboard_generate", 			// Before the html widgets are generated (params: $dashboard_manager)
		"post_dashboard_generate", 			// After the html is generated (params: $html)
);

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */
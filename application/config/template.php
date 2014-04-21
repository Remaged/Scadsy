<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Template files
| -------------------------------------------------------------------------
*/

$config['template_scripts'] = array(
	"jquery" => "jquery-1.11.0.min.js",
	"jquery-ui" => "jquery-ui-1.10.4.min.js",
	"jquery-switchbutton" => "jquery.switchbutton.js",
	"jquery-custom" => "jquery.custom.js"
);

$config['template_styles'] = array(
	"reset" => "reset.css",
	"open-sans" => "open-sans.css",
	"jquery-ui" => "jquery-ui-1.10.4.custom.min.css",
	"template_style" => "style.css"
);

$config['template_menu'] = array(
/*
	array(
		"link" => "module/index",
		"description" => "Modules",
		"default_groups" => array("admin"),
		"priority" => 11
	),
	array(
		"link" => "module/permissions",
		"description" => "Permissions",
		"default_groups" => array("admin"),
		"parent" => "module/index",
		"priority" => 11
	),
	array(
		"link" => "login/logout",
		"description" => "Logout",
		"default_groups" => array("student", "admin", "school"),
		"priority" => 11
	)
 * */
);

/* End of file template.php */
/* Location: ./application/config/template.php */
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Template files
| -------------------------------------------------------------------------
*/

$config['template_scripts'] = array(
	
);

$config['template_styles'] = array(
	"reset" => "reset.css",
	"open-sans" => "open-sans.css",
	"template_style" => "style.css"
);

$config['template_menu'] = array(
	array(
		"link" => "module/index",
		"description" => "Modules",
		"default_groups" => array("admin"),
		"priority" => 11
	),
	array(
		"link" => "login/logout",
		"description" => "Logout",
		"default_groups" => array("student", "admin", "school"),
		"priority" => 11
	)
);

/* End of file template.php */
/* Location: ./application/config/template.php */
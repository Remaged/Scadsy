<?php

$CI =& get_instance();
$CI->load->dbforge();
$CI->dbforge->db = Database_manager::get_db();

$CI->dbforge->drop_table('sms_users');
$CI->dbforge->drop_table('sms');


/* End of file uninstall.php */
/* Location: ./modules/sms/uninstall.php */
<?php

$CI =& get_instance();
$CI->load->dbforge();
$CI->dbforge->db = Database_manager::get_db();

$CI->dbforge->db->trans_start();

$CI->dbforge->drop_table('sms_users');
$CI->dbforge->drop_table('sms');

$CI->dbforge->db->trans_complete();

/* End of file uninstall.php */
/* Location: ./modules/sms/uninstall.php */
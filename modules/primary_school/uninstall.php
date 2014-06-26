<?php

$CI =& get_instance();
$CI->load->dbforge();
$CI->dbforge->db = Database_manager::get_db();

$CI->dbforge->db->trans_start();

$CI->dbforge->drop_table('enrollments');
$CI->dbforge->drop_table('guardians_students');
$CI->dbforge->drop_table('students');
$CI->dbforge->drop_table('guardians');

$CI->dbforge->db->trans_complete();

/* End of file uninstall.php */
/* Location: ./modules/manage_students/uninstall.php */
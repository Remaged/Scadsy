<?php

$CI =& get_instance();
$CI->load->dbforge();
$CI->dbforge->db = Database_manager::get_db();

$CI->dbforge->drop_table('attendances');


/* End of file uninstall.php */
/* Location: ./modules/attendance/uninstall.php */
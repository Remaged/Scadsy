<?php

$CI =& get_instance();
$CI->load->dbforge();
$CI->dbforge->db = Database_manager::get_db();

$fields = array(
    'user_id' => array(
	     'type' => 'INT',
	     'constraint' => 11,
	     'null' => FALSE
      ),
     'attended' => array(
	     'type' => 'BOOLEAN',
	     'null' => FALSE
      ), 
      'date' => array(
      	'type' => 'DATE',
      	'null' => FALSE
	  )	                
);
$CI->dbforge->add_field($fields); 	
$CI->dbforge->add_key('user_id', TRUE);	
$CI->dbforge->add_key('date', TRUE);	
$CI->dbforge->create_table('attendances');

/* End of file install.php */
/* Location: ./modules/sms/install.php */
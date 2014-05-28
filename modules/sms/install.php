<?php

$CI =& get_instance();
$CI->load->dbforge();
$CI->dbforge->db = Database_manager::get_db();

$fields = array(
    'id' => array(
	     'type' => 'INT',
	     'constraint' => 11, 
	     'unsigned' => FALSE,
	     'auto_increment' => TRUE
      ),
     'user_id' => array(
	     'type' => 'INT',
	     'null' => TRUE,
	     'constraint' => 11
      ), 
      'message' => array(
	     'type' => 'TEXT',
	     'null' => FALSE
      ), 
      'date_time' => array(
      	'type' => 'DATETIME',
      	'null' => FALSE
	  ),
	  'event_id' => array(
	     'type' => 'INT',
	     'null' => TRUE,
	     'constraint' => 11
      ),
      'reply_event_id' => array(
	     'type' => 'INT',
	     'null' => TRUE,
	     'constraint' => 11
      ), 
      'api_error' => array(
	     'type' => 'VARCHAR',
	     'null' => TRUE,
	     'constraint' => 100
      ),  	                
);
$CI->dbforge->add_field($fields); 	
$CI->dbforge->add_key('id', TRUE);	
$CI->dbforge->add_key('event_id');	
$CI->dbforge->create_table('sms');
$CI->dbforge->db->query('ALTER TABLE sms ADD CONSTRAINT FK_SMS_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE;'); 
$CI->dbforge->db->query('ALTER TABLE sms ADD CONSTRAINT FK_SMS_reply_event_id FOREIGN KEY(reply_event_id) REFERENCES sms(event_id) ON DELETE SET NULL ON UPDATE CASCADE;'); 



$fields = array(
    'id' => array(
	     'type' => 'INT',
	     'constraint' => 11, 
	     'unsigned' => FALSE,
	     'auto_increment' => TRUE
      ),
     'user_id' => array(
	     'type' => 'INT',
	     'null' => TRUE,
	     'constraint' => 11
      ), 
      'used_phone_number' => array(
	     'type' => 'VARCHAR',
	     'constraint' => 40
      ), 
      'sms_id' => array(
	     'type' => 'INT',
	     'null' => TRUE,
	     'constraint' => 11
      ), 
      'sent_date_time' => array(
	     'type' => 'DATETIME',
	     'null' => TRUE
      )                 
);
$CI->dbforge->add_field($fields); 	
$CI->dbforge->add_key('id', TRUE);	
$CI->dbforge->create_table('sms_users');
$CI->dbforge->db->query('ALTER TABLE sms_users ADD CONSTRAINT FK_SMS_USERS_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;'); 
$CI->dbforge->db->query('ALTER TABLE sms_users ADD CONSTRAINT FK_SMS_USERS_sms_id FOREIGN KEY(sms_id) REFERENCES `sms`(id) ON DELETE CASCADE ON UPDATE CASCADE;'); 

/* End of file install.php */
/* Location: ./modules/sms/install.php */
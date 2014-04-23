<?php

$CI =& get_instance();
$CI->load->dbforge();
$CI->dbforge->db = Database_manager::get_db();

$fields = array(
                        'id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 5, 
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'module_id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => '5',
                                                 'unsigned' => TRUE
                                          ),
                        'last_checked' => array(
                                                 'type' =>'TIMESTAMP'
                                          ),
                        'has_update' => array(
                                                 'type' => 'BOOL',
                                                 'default' => 0,
                                          ),
                        'to_version' => array(
												'type' => "VARCHAR",
												 'constraint' => '50',
												 'null' => TRUE
										  )                  
                );
$CI->dbforge->add_field($fields); 	
$CI->dbforge->add_key('id');	
$CI->dbforge->add_key('module_id', TRUE);	

$CI->dbforge->create_table('updates');


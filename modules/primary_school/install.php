<?php

$CI =& get_instance();
$CI->load->dbforge();
$CI->dbforge->db = Database_manager::get_db();

//CREATING THE TABLE 'STUDENTS'

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
      'alternate_id' => array(
	     'type' => 'INT',
	     'null' => TRUE,
	     'constraint' => 11
      )               
);
$CI->dbforge->add_field($fields); 	
$CI->dbforge->add_key('id', TRUE);	
$CI->dbforge->add_key('user_id');	
$CI->dbforge->create_table('students');
$CI->dbforge->db->query('ALTER TABLE students ADD CONSTRAINT FK_STUDENTS_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;'); 


//CREATING THE TABLE 'GUARDIANS' (parents of students)

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
      )              
);
$CI->dbforge->add_field($fields); 	
$CI->dbforge->add_key('id', TRUE);	
$CI->dbforge->add_key('user_id');	
$CI->dbforge->create_table('guardians');
$CI->dbforge->db->query('ALTER TABLE guardians ADD CONSTRAINT FK_GUARDIANS_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;'); 


//CREATING THE TABLE 'GUARDIANS_STUDENTS' (join table for guardians and students)

$fields = array(
     'student_id' => array(
	     'type' => 'INT',
	     'null' => TRUE,
	     'constraint' => 11
      ),
      'guardian_id' => array(
	     'type' => 'INT',
	     'null' => TRUE,
	     'constraint' => 11
      )            
);
$CI->dbforge->add_field($fields); 
$CI->dbforge->add_key('student_id', TRUE);	
$CI->dbforge->add_key('guardian_id', TRUE);	
$CI->dbforge->create_table('guardians_students');
$CI->dbforge->db->query('ALTER TABLE guardians_students ADD CONSTRAINT FK_GUARDIANS_STUDENTS_student_id FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE ON UPDATE CASCADE;'); 
$CI->dbforge->db->query('ALTER TABLE guardians_students ADD CONSTRAINT FK_GUARDIANS_STUDENTS_guardian_id FOREIGN KEY(guardian_id) REFERENCES guardians(id) ON DELETE CASCADE ON UPDATE CASCADE;'); 


//CREATING THE TABLE 'ENROLLMENTS'

$fields = array(
    'id' => array(
	     'type' => 'INT',
	     'constraint' => 11, 
	     'unsigned' => FALSE,
	     'auto_increment' => TRUE
      ),
      'student_id' => array(
	     'type' => 'INT',
	     'null' => TRUE,
	     'constraint' => 11
      ),
      'group_id' => array(
	     'type' => 'INT',
	     'null' => TRUE,
	     'constraint' => 11
      ),
     'start_date' => array(
	     'type' => 'DATE',
	     'null' => TRUE
      ), 
      'end_date' => array(
	     'type' => 'DATE',
	     'null' => TRUE
      )               
);
$CI->dbforge->add_field($fields); 	
$CI->dbforge->add_key('id', TRUE);	
$CI->dbforge->add_key('student_id');	
$CI->dbforge->add_key('group_id');
$CI->dbforge->create_table('enrollments');
$CI->dbforge->db->query('ALTER TABLE enrollments ADD CONSTRAINT FK_ENROLLMENT_student_id FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE ON UPDATE CASCADE;'); 
$CI->dbforge->db->query('ALTER TABLE enrollments ADD CONSTRAINT FK_ENROLLMENT_group_id FOREIGN KEY(group_id) REFERENCES groups(id) ON DELETE CASCADE ON UPDATE CASCADE;'); 


/* End of file install.php */
/* Location: ./modules/manage_students/install.php */
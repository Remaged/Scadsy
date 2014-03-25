<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Login-module module
 */
class School_manager_model extends SCADSY_Model {
	
	/**
	 * Gets connection-info of all school-databases.
	 * @return
	 * 		array of objects containing connection-data
	 */
	public function get_databases(){
		return Database_manager::get_db(TRUE)->get('database')->result();
	}
	
	
	/**
	 * Tries to submit the POST-data
	 * @return
	 * 		TRUE if succesfull
	 * 		string with error-message if failed.
	 */
	public function submit_data(){
		$this->setup_form_validation();			
		if($this->form_validation->run() === TRUE){
			Database_manager::get_db(TRUE)->trans_start();			
			$this->create_school_database($this->input->post('name'),$this->input->post('username'),$this->input->post('password'));
			$data = array(
			   'name' => $this->input->post('name') ,
			   'username' => $this->input->post('username') ,
			   'password' => $this->input->post('password') ,
			   'school' => $this->input->post('school')
			);
			Database_manager::get_db(TRUE)->insert('database',$data);
			Database_manager::get_db(TRUE)->trans_complete();
			return TRUE;
		}		
		return FALSE;
	}
	
	/**
	 * Creates a database for a school, using the 'scadsy_school_database.sql' file.
	 * Requires that user for the current database (the Enterprise-database) has the privilege to create databases.
	 * @param $db_name
	 * 		name of the new database.
	 * @param $db_user
	 * 		name of the user for the new database
	 * @param $db_pass
	 * 		password for the user in the new database.
	 */
	private function create_school_database($db_name, $db_user, $db_pass){
		$CI =& get_instance();
        $CI->load->database();
		$dbh = new PDO($CI->db->dbdriver.':host='.$CI->db->hostname.';dbname='.$CI->db->database, $CI->db->username, $CI->db->password);
		$sql = file_get_contents(getcwd().'/enterprise/schools/scadsy_school_database.sql');		
		$sql = str_replace("{DB_NAME}", $this->db_name_check($db_name), $sql);	
		$dbh->query($sql);
	}
	
	/**
	 * Extra name-escape to ensure no incorrect database-names or injections can be provided.
	 * @param $value
	 * 		value to be checked.
	 * return
	 * 		the provided value if valid or empty string if not valid. 
	 */
	private function db_name_check($value){
		//Only word-characters are allowed
		if(!preg_match("/^\w*$/", $value)){
			$value = '';
		}
		return $value;

	}
	
	/**
	 * Sets rules for the login form validation.
	 */
	public function setup_form_validation(){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Database name', 'required|trim|xss_clean|is_unique[database.name]'); 
		$this->form_validation->set_rules('username', 'Database username','required|trim|xss_clean');				
		$this->form_validation->set_rules('password', 'Database password', 'trim|xss_clean');	
		$this->form_validation->set_rules('school', 'School name', 'required|trim|xss_clean|is_unique[database.school]');	
	}
		
	
}


/* End of file school_manager_model.php */
/* Location: ./enterprise/schools/models/school_manager_model.php */
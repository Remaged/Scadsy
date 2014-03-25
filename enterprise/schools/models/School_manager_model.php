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
	 * Tries to login
	 * @return
	 * 		TRUE if succesfull
	 * 		string with error-message if failed.
	 */
	public function submit_data(){
		$this->setup_form_validation();			
		if($this->form_validation->run() === TRUE){
			Database_manager::get_db(TRUE)->trans_start();	

			$data = array(
			   'name' => $this->input->post('name') ,
			   'username' => $this->input->post('username') ,
			   'password' => $this->input->post('password') ,
			   'school' => $this->input->post('school')
			);
			Database_manager::get_db(TRUE)->insert('database',$data);		
			$this->create_school_database($this->input->post('name'),$this->input->post('username'),$this->input->post('password'));
			
			Database_manager::get_db()->trans_complete();
			return TRUE;
		}		
		return FALSE;
	}
	
	private function create_school_database($db_name, $db_user, $db_pass){
		$CI =& get_instance();
        $CI->load->database();
		Database_manager::get_db(TRUE)->query("CREATE DATABASE IF NOT EXISTS ".$this->db_name_escape($db_name));		
		$dbh = new PDO($CI->db->dbdriver.':host='.$CI->db->hostname.';dbname='.$db_name, $db_user, $db_pass);
		$sql = file_get_contents(BASEPATH.'../install/script.sql');
		$dbh->query($sql);
	}
	
	private function db_name_escape($value){
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
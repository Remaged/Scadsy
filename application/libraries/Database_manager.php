<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Database_manager::init();

/**
 * The database manager. This class is responsible for handling the database object.
 */
class Database_manager {
	private static $DB = NULL;
	private static $CI = NULL;
	
	/**
	 * Initialize the Database_manager.
	 */
	public static function init() {
		self::$CI =& get_instance();
		
		$db_name = self::$CI->input->cookie('scadsy_db_cookie', TRUE);
		if($db_name !== FALSE)
		{
			self::connect($db_name);
		}
	}
	
	/**
	 * Set a new database
	 * @param $db_name
	 * 		The name of the new database
	 */
	public static function set_db($db_name) {	
		self::connect($db_name);
	}
	
	/**
	 * Get the currently active database
	 * @param $ci_db
	 * 		Whether or not to get the main db or the set db. Default is FALSE
	 * @return
	 * 		The currently active database object
	 */ 
	public static function get_db($ci_db = FALSE) {
		if($ci_db === FALSE) {
			if(self::$DB === NULL) {
				$db_name = self::$CI->input->cookie('scadsy_db_cookie', TRUE);
				if($db_name !== FALSE) {
					return self::$DB;
				} else {
					return self::$CI->db;
				}
			} else {
				return self::$DB;
			}			
		} else {
			return self::$CI->db;
		}
	}	

	/**
	 * Connect to a database
	 * @param $db_name
	 * 		The database to connect to
	 */
	private static function connect($db_name) {
		if(empty($CI->db)){
			self::$CI->load->database();
		}
		$query = self::$CI->db->get_where('databases', array('name' => $db_name));
	
		if($query->num_rows() == 1) {

			$row = $query->row();
			
			$config['hostname'] = 'localhost';
			$config['username'] = $row->username;
			$config['password'] = $row->password;
			$config['database'] = $row->name;
			$config['dbdriver'] = 'mysql';

			self::$DB = &self::$CI->load->database($config, TRUE);
			
			$cookie = array(
			    'name'   => 'scadsy_db_cookie',
			    'value'  => $db_name,
			    'expire' => 0
			);			
			self::$CI->input->set_cookie($cookie,TRUE);
		}
	}
	
	/**
	 * Disconnect from the currently active database
	 */
	public static function disconnect() {
		self::$DB = NULL;
		$cookie = array(
		    'name'   => 'scadsy_db_cookie',
		    'value'  => FALSE
		);			
		self::$CI->input->set_cookie($cookie);
	}
}

/* End of file Database_manager.php */
/* Location: ./application/libraries/Database_manager.php */
<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The Form_manager class. This class manages extra form fields.
 */
class Form_manager {
	private $CI;
	private $fields;
	private $hook_executed;

	/**
	 * Construct a new instance of the template_manager class.
	 */
	public function __construct() {
		$this->CI =& get_instance();
		$this->fields = array();			
	}
	
	/**
	 * Adds new fields
	 * @param identifier
	 * 		to identify a set (array) of fields
	 * @param field_data
	 * 		contains information for creating a field. Must either be an array or single field.
	 * @param callback
	 * 		function to be called when post is commited.
	 */
	public function add_fields($identifier, $field_data, $callback = NULL){
		if( ! key_exists($identifier, $this->fields)){
			$this->fields[$identifier] = array();
			$this->fields[$identifier]['data'] = array();
			$this->fields[$identifier]['data'][] = "<input type='hidden' name='extra_fields_identifier' value='$identifier' />";
		}
 
		if(is_array($field_data)){	
			$this->fields[$identifier]['data'] = array_merge($this->fields[$identifier]['data'],$field_data);
		}
		else{
			$this->fields[$identifier]['data'][] = $field_data;
		} 

		if($callback !== NULL && $this->CI->input->post('extra_fields_identifier') == $identifier){
			$callback($this->CI->input->post(NULL,TRUE));
		} 
	}
	  	
	/**
	 * Gets extra fields for specified identifier
	 * @param $identifier
	 * 		identifier to match key from extra_fields
	 * return
	 * 		array containing code for making fields.
	 */
	public function get_fields($identifier){		
		if( ! key_exists($identifier,$this->fields)){
			return array();
		}
		return $this->fields[$identifier]['data'];
	}
	 
}

/* End of file Form_manager.php */
/* Location: ./application/libraries/Form_manager.php */
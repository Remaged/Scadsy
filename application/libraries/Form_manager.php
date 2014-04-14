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
		$this->hook_executed = false;
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
		if(!$this->hook_executed) {
			Hook_manager::execute_hook('pre_form_fields_generate', $this);	
			$this->hook_executed = true;
		}	
		if( ! key_exists($identifier,$this->fields)){
			return array();
		}
		return $this->fields[$identifier]['data'];
	}
	
	
	/**
	 * Adds fields (input,select,option,etc) to an array 
	 * which can later be used in a form, 
	 * allowing a more dynamic use of forms.
	 * @param $identifier
	 * 		identifier for the array the field(s) will be added.
	 * @param $scripts
	 * 		either HTML-code or executable PHP-code for creating the fields.
	 * 		(preferrably use form helper functions)
	 
	public function add_extra_fields($identifier, $scripts){
		if( ! key_exists($identifier, $this->extra_fields)){
			$this->extra_fields[$identifier] = array();
		}
		if(is_array($scripts)){			
			$this->extra_fields[$identifier]= array_merge($this->extra_fields[$identifier],$scripts);
		}
		else{
			$this->extra_fields[$identifier][] = $scripts;
		}
	}
	
	/**
	 * Gets extra fields for specified identifier
	 * @param $identifier
	 * 		identifier to match key from extra_fields
	 * return
	 * 		array containing code for making fields.
	 
	public function get_extra_fields($identifier){
		Hook_manager::execute_hook('pre_form_fields_generate', $this);
		
		if( ! key_exists($identifier,$this->extra_fields)){
			return array();
		}
		return $this->extra_fields[$identifier];
	}
	 */
	 
}

/* End of file Form_manager.php */
/* Location: ./application/libraries/Form_manager.php */
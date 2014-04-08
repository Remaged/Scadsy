<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The Form_manager class. This class manages extra form fields.
 */
class Form_manager {
	private $extra_fields;

	/**
	 * Construct a new instance of the template_manager class.
	 */
	public function __construct() {
		$this->extra_fields = array();
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
	 */
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
	 */
	public function get_extra_fields($identifier){
		Hook_manager::execute_hook('pre_form_fields_generate', $this);
		
		if( ! key_exists($identifier,$this->extra_fields)){
			return array();
		}
		return $this->extra_fields[$identifier];
	}
	 
}

/* End of file Form_manager.php */
/* Location: ./application/libraries/Form_manager.php */
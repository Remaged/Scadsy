<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * model example for extra forms
 */
class Extra_forms_example_model extends SCADSY_Model {

	public function load_extra_forms(){
		$this->load->helper('form');			
		$this->form_manager->add_extra_fields('some_test_fields',array(
			"<div><label>using html</label><input type='text' name='just_some_custom_form' value='Hello!' /></div>",
			form_label_input('just_some_form_helper_input_field','using form_helper'),
			form_label_password('somepassword')
		));		
	}  
	
}


/* End of file Extra_forms_example_model.php */
/* Location: ./modules/welcome/models/Extra_forms_example_model.php */
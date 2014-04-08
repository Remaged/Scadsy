<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Form Extra
 * 
 * Selects a specific part of the extra_fields array (using the identifier) and outputs that array as a string.
 *
 * @access	public
 * @param	string
 * @return	string
 */

if ( ! function_exists('form_extra')){
	function form_extra($identifier){
		$html_output = "";	
		$CI =& get_instance();
		$CI->load->library('form_manager');
		$form_extras = $CI->form_manager->get_extra_fields($identifier);
		foreach($form_extras AS $form_helper_function){
			$html_output .= $form_helper_function;
		}
		return $html_output;
	}
}


// ------------------------------------------------------------------------

/**
 * Date Field
 *
 * Identical to the input function but adds the "date" type
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_date')){
	function form_date($data = '', $value = '', $extra = ''){
		if ( ! is_array($data)){
			$data = array('name' => $data);
		}

		$data['type'] = 'date';
		return form_input($data, $value, $extra);
	}
}

// ------------------------------------------------------------------------

/**
 * Email Field
 *
 * Identical to the input function but adds the "email" type
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_email')){
	function form_email($data = '', $value = '', $extra = ''){
		if ( ! is_array($data)){
			$data = array('name' => $data);
		}

		$data['type'] = 'email';
		return form_input($data, $value, $extra);
	}
}

// ------------------------------------------------------------------------

/**
 * Label and input
 *
 * creates a set of label and input inside a div
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_label_input')){
	function form_label_input($data = '', $human_name = NULL, $default_value = '', $extra = ''){
		$name = $data;		
		if(is_array($data)){
			$name = $data['name'];
		}
		$human_name = $human_name === NULL ? ucfirst(str_replace('_',' ',$name)) : $human_name;		
		return
			'<div>'.
				form_label($human_name, $name).
				form_input($data, set_value($name,$default_value), $extra).
			'</div>';
	}
}

/* Same as form_label_input, except it has a type-parameter for using different input-types  */
if ( ! function_exists('form_label_any_time')){
	function form_label_any_time($data = '', $human_name = NULL, $default_value = '', $extra = '', $type = 'text'){
		if(!is_array($data)){
			$data = array('name'=>$data);
		}	
		$data['type'] = $type;
		return form_label_input($data, $human_name, $default_value, $extra);
	}
}

/* Same as form_label_input, except it uses 'password' in type-attribute. */
if ( ! function_exists('form_label_password')){
	function form_label_password($data = '', $human_name = NULL, $default_value = '', $extra = ''){
		return form_label_any_time($data, $human_name, $default_value, $extra, 'password');
	}
}

/* Same as form_label_input, except it uses 'email' in type-attribute. */
if ( ! function_exists('form_label_email')){
	function form_label_email($data = '', $human_name = NULL, $default_value = '', $extra = ''){
		return form_label_any_time($data, $human_name, $default_value, $extra, 'email');
	}
}

/* Same as form_label_input, except it uses 'date' in type-attribute. */
if ( ! function_exists('form_label_date')){
	function form_label_date($data = '', $human_name = NULL, $default_value = '', $extra = ''){
		return form_label_any_time($data, $human_name, $default_value, $extra, 'date');
	}
}


/**
 * Label and select
 *
 * creates a set of label and select inside a div
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	string
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_label_dropdown')){
	function form_label_dropdown($name = '', $options = '', $human_name = NULL, $default_value = '', $extra = ''){
		$human_name = $human_name === NULL ? ucfirst(str_replace('_',' ',$name)) : $human_name;		
		return
			'<div>'.
				form_label($human_name, $name).
				form_dropdown($name, $options, set_value($name,$default_value), $extra).
			'</div>';
	}
}



/* End of file form_helper.php */
/* Location: ./application/helpers/SCADSY_form_helper.php */
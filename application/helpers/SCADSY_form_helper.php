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
		$form_extras = $CI->form_manager->get_fields($identifier);
		foreach($form_extras AS $form_helper_function){
			$html_output .= $form_helper_function;
		}
		return $html_output;
	}
}


// ------------------------------------------------------------------------


/**
 * Form any input type
 *
 * same is form_input, with an aditional parameter to overwrite the type, allowing to use different type other than 'text'.
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
 if ( ! function_exists('form_any_input_type')){
	function form_any_input_type($data = '', $value = '', $extra = '', $type = 'text'){
		if ( ! is_array($data)){
			$data = array('name' => $data);
		}
		$data['type'] = $type;
		return form_input($data, $value, $extra);
	}
}

/* Same as form_input, except it uses 'date' in type-attribute. */
if ( ! function_exists('form_date')){
	function form_date($data = '', $value = '', $extra = ''){
		return form_any_input_type($data, $value, $extra, 'date');
	}
}

/* Same as form_input, except it uses 'email' in type-attribute. */
if ( ! function_exists('form_email')){
	function form_email($data = '', $value = '', $extra = ''){
		return form_any_input_type($data, $value, $extra, 'email');
	}
}

/* Same as form_input, except it uses 'search' in type-attribute. */
if ( ! function_exists('form_search')){
	function form_search($data = '', $value = '', $extra = ''){
		return form_any_input_type($data, $value, $extra, 'search');
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
if ( ! function_exists('form_label_any_type')){
	function form_label_any_type($data = '', $human_name = NULL, $default_value = '', $extra = '', $type = 'text'){
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
		return form_label_any_type($data, $human_name, $default_value, $extra, 'password');
	}
}

/* Same as form_label_input, except it uses 'email' in type-attribute. */
if ( ! function_exists('form_label_email')){
	function form_label_email($data = '', $human_name = NULL, $default_value = '', $extra = ''){
		return form_label_any_type($data, $human_name, $default_value, $extra, 'email');
	}
}

/* Same as form_label_input, except it uses 'date' in type-attribute. */
if ( ! function_exists('form_label_date')){
	function form_label_date($data = '', $human_name = NULL, $default_value = '', $extra = ''){
		return form_label_any_type($data, $human_name, $default_value, $extra, 'date');
	}
}

/* Same as form_label_input, except it uses 'search' in type-attribute. */
if ( ! function_exists('form_label_search')){
	function form_label_search($data = '', $human_name = NULL, $default_value = '', $extra = ''){
		return form_label_any_type($data, $human_name, $default_value, $extra, 'search');
	}
}

/**
 * Label and textarea
 *
 * creates a set of label and textarea inside a div
 *
 * @access	public
 * @param	string or array
 * @param	string
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_label_textarea')){
	function form_label_textarea($data = '', $human_name = NULL, $default_value = '', $extra = ''){
		$name = $data;		
		if(is_array($data)){
			$name = $data['name'];
		}
		$human_name = $human_name === NULL ? ucfirst(str_replace('_',' ',$name)) : $human_name;		
		return
			'<div>'.
				form_label($human_name, $name).
				form_textarea($data, set_value($name,$default_value), $extra).
			'</div>';
	}
}

/**
 * Label and multiselect
 *
 * creates a set of label and multiselect inside a div
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	string
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_label_multiselect')){
	function form_label_multiselect($name = '', $options = '', $human_name = NULL, $default_value = '', $extra = ''){
		$human_name = $human_name === NULL ? ucfirst(str_replace('_',' ',$name)) : $human_name;		
		return
			'<div>'.
				form_label($human_name, $name).
				form_multiselect($name, $options, set_value($name,$default_value), $extra).
			'</div>';
	}
}

/**
 * Label and select/dropdown
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
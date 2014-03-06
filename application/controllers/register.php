<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends SCADSY_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('registration_model');
	}
	
	
	function index()
	{
		$this->setup_form_validation();	
		if ($this->form_validation->run() == FALSE)
		{
			$data['groups'] = $this->registration_model->get_groups();
			$data['ethnicities'] = $this->registration_model->get_ethnicities();		
			$data['languages'] = $this->registration_model->get_languages();	
			$data['grades'] = $this->registration_model->get_grades();				
			$this->view('index',$data);
		}
		else
		{
			$this->user_model->add_user();			
			$this->view('succes');
		}
	}
	
	
	
	/**
	 * setup_form_validation
	 *
	 * Sets rules for the registration form validation.
	 *
	 * @access	public
	 * @return	void
	 */
	public function setup_form_validation(){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		//required fields
		$this->form_validation->set_rules('username', 'Username', 'required');		
		$this->form_validation->set_rules('first_name', 'First name', 'required');
		$this->form_validation->set_rules('last_name', 'Last name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('group', 'Group', 'required');
		$this->form_validation->set_rules('gender', 'Gender', 'required');	
		$this->form_validation->set_rules('language', 'Language', 'required');
		$this->form_validation->set_rules('ethnicity', 'Ethnicity', 'required');
		//fields with special rules						
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'callback_check_password_confirm');
		$this->form_validation->set_rules('email', 'Email', 'callback_check_email');
		
		$this->form_validation->set_rules('student_id', 'Student ID', 'callback_check_student_id');
		$this->form_validation->set_rules('grade', 'Grade', 'callback_check_grade');
		$this->form_validation->set_rules('start_date', 'Start date', 'callback_check_start_date');
		//optional fields
		$this->form_validation->set_rules('end_date', 'End date');
		$this->form_validation->set_rules('alternate_id', 'Alternate ID');
		$this->form_validation->set_rules('middle_name', 'Middle name');
		$this->form_validation->set_rules('date_of_birth', 'Date of birth');
		$this->form_validation->set_rules('phone_number', 'Phone number');
	}
	
	
	/**
	 * check_grade
	 * requierd for students
	 *
	 * @access	public
	 * @param 	string
	 * @return	void
	 */
	public function check_grade($str){
		if($this->input->post('group') == 'students' && empty($str))
		{
			$this->form_validation->set_message('check_grade', 'The %s field is required for students.');
			return FALSE;
		}
		return TRUE;
	}
	
	
	/**
	 * check_start_date
	 * required for students and teachers
	 *
	 * @access	public
	 * @param 	string
	 * @return	void
	 */
	public function check_start_date($str){
		if(($this->input->post('group') == 'students' OR $this->input->post('group') == 'teachers') && empty($str))
		{
			$this->form_validation->set_message('check_start_date', 'The %s field is required for '.$this->input->post('group').'.');
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * check_student_id
	 * - required for students only.
	 * - must not exist already. 
	 *
	 * @access	public
	 * @param 	string
	 * @return	void
	 */
	public function check_student_id($str){
		if($this->input->post('group') == 'students' && empty($str))
		{
			$this->form_validation->set_message('check_student_id', 'The %s field is required for students.');
			return FALSE;
		}
		elseif($this->user_model->check_student_id_exists($str)){
			$this->form_validation->set_message('check_student_id', $str.' in the %s field is already in use.');
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * check_email
	 *
	 * callback for a set_rule to check wether an email already exist or not.
	 *
	 * @access	public
	 * @param 	string
	 * @return	void
	 */
	public function check_email($email){
		$email_exists = $this->user_model->check_email_exists($this->input->post('email'));
		if($email_exists)
		{
			$this->form_validation->set_message('check_email', 'The %s is already taken.');
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * check_password_confirm
	 *
	 * callback for a set_rule to check if the confirmation password matches.
	 * returns FALSE if passwords do not match, TRUE if they do.
	 *
	 * @access	public
	 * @param 	string
	 * @return	boolean
	 */
	public function check_password_confirm($password_confirmation){
		if($this->input->post('password') != $password_confirmation)
		{
			$this->form_validation->set_message('check_password_confirm', 'The %s field does not match the password field.');
			return FALSE;
		}
		return TRUE;
	}
	
	
	
	public function view($page = 'index', $data = NULL)
	{
		if ( ! file_exists('application/views/registration/'.$page.'.php'))
		{
			show_404();
		}
	
		$data['title'] = ucfirst($page); // Capitalize the first letter
		//$this->load->view('templates/header', $data);
		$this->load->view('registration/'.$page.'.php', $data);
		//$this->load->view('templates/footer', $data);
	
	}
	
}

/* End of file register.php */
/* Location: ./application/controllers/register.php */
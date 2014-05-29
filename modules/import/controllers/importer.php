<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Importer extends SCADSY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model("manage_imports_model");
	}

	public function index(){
		$this->view('import');
	}	
	
	public function import() {
		$this->load->library('upload', array('allowed_types' => 'txt', 'upload_path' => 'temp'));
		if($this->upload->do_upload('import_csv')) {
			$upload_data = $this->upload->data();			
			$data = $this->manage_imports_model->get_data_from_import_file($upload_data['full_path']);		
			unlink($upload_data['full_path']);
			
			$this->view('import_overview', $data);
		} else {
			$data = array('error' => $this->upload->display_errors());
			$this->view('import_error', $data);
		}
	}
	
	public function import_final() {
		if($this->input->post('data')) {
			$incoming = unserialize($this->input->post('data'));
			$data['records'] = $this->manage_imports_model->save_import_data($incoming);
			$this->view('import_done', $data);
		}
	}
}


/* End of file importer.php */
/* Location: ./modules/import/controllers/importer.php */
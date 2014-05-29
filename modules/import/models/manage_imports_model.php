<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_imports_model extends SCADSY_Model {
	
	public function get_data_from_import_file($file_location) {
		$handle = fopen($file_location, "r");
		
		$group = '';
		$groups = Array();
		$students = Array();			
		
		 while (($data = fgetcsv($handle)) !== FALSE) {
		 	$item_count = count($data);
		 	if($item_count == 10) {
		 		$group = $data['3'];
		 	} else if ($item_count == 16) {
		 		$obj = new stdClass();
				$obj->first_name = ucfirst(strtolower(trim($data[4])));
				$obj->last_name = ucfirst(strtolower(trim($data[3])));
				$obj->date_of_birth = strtotime($data[5]);
				$obj->sex = trim($data[8]);
				$obj->grade = trim($data[11]);
				$students[] = $obj;
				
				if(!in_array($obj->grade, $groups)) {
					$groups[] = $obj->grade;
				}
		 	}
		 }

		fclose($handle);
		
		return array("main" => $group, "sub" => $groups, "students" => $students);
	} 
	
	
	public function save_import_data($data) {
		$this->save_group($data['main']);
		$this->save_group($data['sub']);
	}
	
	private function save_group($group) {
		if(is_array($group)) {
			foreach($group as $item) {
				$this->save_group($item);
			}
			return;
		}
		
		$g = new Group();
		$g->where('name', $group)->get();
		if($g->result_count() == 0) {
			$ng = new Group();
			$ng->name = $group;
			$ng->save();
		}				
	}
}

/* End of file manage_imports_model.php */
/* Location: ./modules/import/models/manage_imports_model.php */
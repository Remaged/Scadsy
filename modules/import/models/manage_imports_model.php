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
		$parent = $this->save_group($data['main']);
		$this->save_group($data['sub'], $parent);
		return $this->save_students($data['students']);
	}
	
	private function save_group($group, $parent = null) {
		if(is_array($group)) {
			$groups = array();
			foreach($group as $item) {
				 $groups[] = $this->save_group($item, $parent);
			}
			return $groups;
		}
				
		$g = new Group();
		$g->where('name', $group)->get();
		if($g->result_count() == 0) {
			$g->name = $group;
			$g->save();
			if($parent != null) {
				$g->save_parent_group($parent);
			}		
		}	
		return $g;	
	}
	
	private function save_students($students) {
		$failed_students = array();
		
		foreach($students as $student) {
			$user = new User();
			$user->title = ($student->sex == "F") ? "Ms" : "Mr";
			$user->first_name = $student->first_name;
			$user->last_name = $student->last_name;
			$user->username = str_replace(" ", "", $student->first_name.$student->last_name);
			$user->password = $student->first_name.date("Y-m-d", $student->date_of_birth);
			$user->password_confirm = $student->first_name.date("Y-m-d", $student->date_of_birth);
			$user->date_of_birth = date("Y-m-d", $student->date_of_birth);
			$user->gender = ($student->sex == "F") ? "female" : "male";
			$user->status = 'disabled';
			
			if(!$user->save()) {
				$failed_students[] = array("student" => $student, "error" => $user->error->string);
			} else {							
				$group = new Group();
				$group->where('name', $student->grade)->get();
				
				if($group->result_count() == 0) {
					$group = $this->save_group($student->grade);
				}
							
				$group->save($user);
			}
		}
		
		return $failed_students;	
	}
}

/* End of file manage_imports_model.php */
/* Location: ./modules/import/models/manage_imports_model.php */
<?php

class Action extends DataMapper {

	var $table = 'actions';

    var $has_one = array('module');
	var $has_many = array('permission');
	var $auto_populate_has_one = TRUE;

    var $validation = array(
        'name' => array(
            'label' => 'Name',
            'rules' => array('required', 'trim', 'xss_clean'),
        ),
        'controller' => array(
            'label' => 'Controller',
            'rules' => array('required', 'xss_clean', 'trim'),
        )
    );
	
	public function get_by_unique($module_directory, $controller_name, $action_name){
		$module = new Module();
		$module->get_where(array('directory'=>$module_directory),1);
		$this->get_where(array('module_id'=>$module->id,'name'=>$action_name,'controller'=>$controller_name),1);
		return $this;
	}


}

/* End of file action.php */
/* Location: ./application/models/action.php */
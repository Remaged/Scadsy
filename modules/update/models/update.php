<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update extends DataMapper {

    var $table = 'updates';
	var $CI;
	
    var $has_one = array('module');
	var $auto_populate_has_one = TRUE;

    var $validation = array(
        'module_id' => array(
            'label' => 'Module',
            'rules' => array('required', 'trim', 'xss_clean', 'unique'),
        ),
        'last_checked' => array(
            'label' => 'Last Checked',
            'rules' => array('xss_clean'),
        ),
        'has_update' => array(
            'label' => 'Has Update',
            'rules' => array('required', 'xss_clean'),
        ),       
        'to_version' => array(
            'label' => 'To Version',
            'rules' => array('xss_clean', 'min_length' => 1, 'max_length' => 49)
        )
    );
	
	/**
	 * Constructor: calls parent constructor
	 */
    function __construct($id = NULL)
	{
		parent::__construct($id);
    }
	
	/************************/
	/* STATIC FUNCTIONALITY */
	/************************/
	public static function check_for_updates($notification_manager){
		// Update the existing relationship	
		$m = new Module();
		$m->has_one('update');
		
		// Get a list of modules we aren't monitoring yet
		$m->get();
		foreach($m as $module) {
			if($module->update == NULL) {
				$u = new Update();
				$u->has_update = 0;
				$u->module_id = $module->id;
				$u->save();
			}
		}		

		// check for updates for the modules we should check for
		$u = new Update();
		$u->where("module_id != 0 AND has_update = 0 AND DATEDIFF(last_checked, now()) < 0")->get();

		foreach($u as $update) {
			// Check if we can check for updates
			$module = new Module($update->module_id);
			if(filter_var(trim($module->uri), FILTER_VALIDATE_URL) !== FALSE) {
				// So we can check for updates, lets do it!
				$lastest_version = file_get_contents(trim($module->uri).'?type=version');
				if($lastest_version > $module->version) {
					$update->has_update = 1;
					$update->to_version = $lastest_version;
				} else {
					$update->has_update = 0;
				}
			}
			$date = new DateTime();
			$update->last_checked = date('Y-m-d H:i:s',$date->getTimestamp());
			$update->save();
		}

		// Check if the SCADSY row is already in the db-table
		$scadsy_count = new Update();
		$count = $scadsy_count->where('module_id = 0')->count();

		if($count == 0) {
			$scadsy_update = new Update();
			$scadsy_update->has_update = 0;
			$scadsy_update->module_id = 0;
			$scadsy_update->save();
		}
		
		// Check if SCADSY has updates
		$scadsy = new Update();
		$scadsy->where('module_id = 0 AND DATEDIFF(last_checked, now()) < 0')
				->limit(1)
				->get();
		if($scadsy->result_count() == 1) {
			$lastest_version = file_get_contents(trim(UPDATE_URL).'?type=version');
			if($lastest_version > VERSION) {
				$scadsy->has_update = 1;
				$scadsy->to_version = $lastest_version;						
			} 			
			$date = new DateTime();
			$scadsy->last_checked = date('Y-m-d H:i:s',$date->getTimestamp());			
			$scadsy->save();
		}		
		
		// Show update notice if it is required
		$scadsy->where('module_id = 0')->get();
		if($scadsy->has_update == 1) {
			$notification_manager->add_notification("update", 'SCADSY v' . $scadsy->to_version . ' is out! <a href="'.site_url('update/updates/index').'">Click here to update!</a>');
		}
	}

	public static function install_update($update_id) {
		try {
			$m = new Module();
			$m->has_one('update');
			
			$update = new Update($update_id);
			
			$module;
			// Get the correct update url to download the file
			if($update->module_id == 0) {
				$url = UPDATE_URL.'?type=file';
			} else {
				$module = new Module($update->module_id);
				$url = $module->uri.'?type=file';
			}
	
			// Download the zip to the temp folder
			if(!is_dir('temp/updates')){
				mkdir('temp/updates');
			}
			
			if(file_put_contents('temp/updates/'.$update_id.".zip", fopen($url, 'r')) === FALSE) {
				throw new Exception();
			}
			
			$zip = new ZipArchive();
			if($zip->open('temp/updates/'.$update_id.".zip") === TRUE) {
				
				if($update->module_id == 0) {
					$zip->extractTo('.');
				} else {
					$zip->extractTo('modules/'.$module->directory.'/');
					$module->version = $update->to_version;
					$module->save();
				}
				
				$update->has_update = 0;
				$update->to_version = NULL;
				$update->save();
				
				$zip->close();
			} else {
				throw new Exception();
			}
			
			unlink('temp/updates/'.$update_id.".zip");
			return TRUE;
		}
		catch (Exception $e) {
			return FALSE;
		}
	}
}

/* End of file Update.php */
/* Location: ./modules/update/views/Update.php */
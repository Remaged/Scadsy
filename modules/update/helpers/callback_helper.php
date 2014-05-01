<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UpdateCallbacks {
	
	private function __construct() {}
	
	public static function pre_menu_generated($menu_manager) {
		$count = (new Update())->where('has_update = 1')->count();	
		if($count > 0) {
			$menu_manager->add_submenu_item('dashboard/dashboard/index','update/updates/index', __('Updates').'<span class="update-count"><span class="count">'.$count.'</span></span>', array('admin'));		
		} else {
			$menu_manager->add_submenu_item('dashboard/dashboard/index','update/updates/index', __('Updates'), array('admin'));		
		}
	}	
	
	public static function check_for_updates($notification_manager){
		self::update_existing_relationships();
		self::update_update_list();
		self::check_updates_modules();	
		self::check_updates_core();
		self::show_notification($notification_manager);
	}
	
	public static function update_existing_relationships() {
		$m = new Module();
		$m->has_one('update');
	}
	
	private static function update_update_list() {
		// Add missing modules
		$m = new Module();
		$m->get();
		foreach($m as $module) {
			if($module->update == NULL) {
				$u = new Update();
				$u->has_update = 0;
				$u->module_id = $module->id;
				$u->save();
			}
		}
		
		// Add SCADSY if it is not present yet
		$scadsy_count = new Update();
		$count = $scadsy_count->where('module_id = 0')->count();

		if($count == 0) {
			$scadsy_update = new Update();
			$scadsy_update->has_update = 0;
			$scadsy_update->module_id = 0;
			$scadsy_update->save();
		}
	}
	
	private static function check_updates_modules() {
		$u = new Update();
		$u->where("module_id != 0 AND has_update = 0 AND DATEDIFF(last_checked, now()) < 0")->get();

		foreach($u as $update) {
			// See if we can check for updates
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
	}
	
	private static function check_updates_core() {
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
	}
	
	private static function show_notification($notification_manager) {
		$scadsy = new Update();
		$scadsy->where('module_id = 0')->get();
		if($scadsy->has_update == 1) {
			$notification_manager->add_notification("update", __('%s is out!', 'SCADSY v' . $scadsy->to_version).' <a href="'.site_url('update/updates/index').'">'.__('Click here to update!').'</a>');
		}
	}

	public static function install_update($update_id) {
		try {
			self::update_existing_relationships();
			
			$update = new Update($update_id);
			$module = new Module($update->module_id);
			$url = self::get_update_url($update, $module);

			self::download_zip($update, $url);
			self::extract_zip($update, $module);
		
			unlink('temp/updates/'.$update_id.".zip");
			return TRUE;
		}
		catch (Exception $e) {
			return FALSE;
		}
	}	

	private static function get_update_url($update, $module) {		
		if($update->module_id == 0) {
			return UPDATE_URL.'?type=file';
		} else {
			return $module->uri.'?type=file';
		}
	}

	private static function download_zip($update, $url) {
		if(!is_dir('temp/updates')){
			mkdir('temp/updates');
		}
		
		if(file_put_contents('temp/updates/'.$update->id.".zip", fopen($url, 'r')) === FALSE) {
			throw new Exception();
		}
	}

	private static function extract_zip($update, $module) {
		$zip = new ZipArchive();
		if($zip->open('temp/updates/'.$update->id.".zip") === TRUE) {
			
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
	}
	
	public static function pre_dashboard_generate($dashboard_manager) {
		$count = (new Update())->where('has_update = 1')->count();
		if($count > 0) {
			self::update_existing_relationships();
			$dashboard_manager->add_widget('update/updates/widget', 'admin');
		}
	}
}

/* End of file callback_helper.php */
/* Location: ./modules/update/helpers/callback_helper.php */
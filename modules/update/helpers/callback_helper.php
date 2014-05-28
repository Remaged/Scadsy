<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UpdateCallbacks {
	
	private function __construct() {}
	
	public static function pre_menu_generated($menu_manager) {
		$update = new Update();
		$count = $update->where('has_update = 1')->count();	
		if($count > 0) {
			$menu_manager->add_submenu_item('dashboard/dashboard/index','update/updates/index', __('Updates').'<span class="update-count"><span class="count">'.$count.'</span></span>', array('admin'));		
		} else {
			$menu_manager->add_submenu_item('dashboard/dashboard/index','update/updates/index', __('Updates'), array('admin'));		
		}
	}	
	
	public static function check_for_updates(){
		self::check_update_list();
		self::check_updates();
	}
	
	private static function check_update_list() {
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
	
	private static function check_updates() {
		$u = new Update();
		$u->where("has_update = 0 AND DATEDIFF(last_checked, now()) < 0")->get();

		foreach($u as $update) {
			// See if we can check for updates
			$module = (new Module());
			$module->where("id", $update->module_id)->get();
			
			$version = ($update->module_id == 0) ? VERSION : $module->version;
			$url = ($update->module_id == 0) ? UPDATE_URL : $module->uri;

			if(filter_var(trim($url), FILTER_VALIDATE_URL) !== FALSE) {				
				// So we can check for updates, lets do it!
				$query = array(
					'version'           => VERSION,
					'module'			=> trim($version),
					'php'               => phpversion()
				);			

				$http_url = trim($url) . '?' . http_build_query( $query, null, '&' );
				$http_data = @file_get_contents($http_url);
				$data = json_decode($http_data);
				
				if($data->has_update === TRUE) {
					$update->has_update = 1;
					$update->to_version = $data->module;
					$update->file_location = $data->file_location;
					$update->change_log = $data->change_log;
				} else {
					$update->has_update = 0;
				}
			}
			$date = new DateTime();
			$update->last_checked = date('Y-m-d H:i:s',$date->getTimestamp());
			$update->save();
		}
	}
	
	public static function show_notification($notification_manager) {
		$scadsy = new Update();
		$scadsy->where('module_id = 0')->get();
		if($scadsy->has_update == 1) {
			$notification_manager->add_notification("update", __('%s is out!', 'SCADSY v' . $scadsy->to_version).' <a href="'.site_url('update/updates/index').'">'.__('Click here to update!').'</a>');
		}
	}

	public static function install_update($update_id) {
		try {
			$update = new Update($update_id);
			$module = new Module($update->module_id);
			$file = 'temp/updates/'.$update->id.'.zip';

			self::download_zip($file, $update, $update->file_location);
			
			if(self::zip_has_settings($file)) {
				self::handle_settings($file, $update, $module);
			}
			
			self::zip_extract($file, $update, $module);
		
			unlink('temp/updates/'.$update_id.".zip");
			return TRUE;
		}
		catch (Exception $e) {
			return FALSE;
		}
	}	

	private static function download_zip($file, $update, $url) {		
		if(!is_dir('temp/updates')){
			mkdir('temp/updates');
		}
		
		if(file_put_contents($file, fopen($url, 'r')) === FALSE) {
			throw new Exception();
		}
	}

	private static function zip_has_settings($file) {
		$zip = new ZipArchive();
		if($zip->open($file) === TRUE) {
			if($zip->getFromName('settings.xml') !== FALSE) {
				return TRUE;
			}
		}
		return FALSE;
	}

	private static function zip_extract($file, $update, $module) {
		$zip = new ZipArchive();
		if($zip->open($file) === TRUE) {
			
			if($update->module_id == 0) {
				$zip->extractTo('.');
				if(is_file('settings.xml')) {
					unlink('settings.xml');
				}
			} else {
				$zip->extractTo('modules/'.$module->directory.'/');
				if(is_file('modules/'.$module->directory.'/'.'settings.xml')) {
					unlink('modules/'.$module->directory.'/'.'settings.xml');
				}
				$module->version = $update->to_version;
				$module->save();
			}
			
			$update->has_update = 0;
			$update->to_version = NULL;
			$update->file_location = NULL;
			$update->change_log = NULL;
			$update->save();
			
			$zip->close();
		} else {
			throw new Exception();
		}
	}
	
	private static function handle_settings($file, $update, $module) {
		$zip = new ZipArchive();
		if($zip->open($file) === TRUE) {
			
			$settings = $zip->getFromName('settings.xml');
			$xml = simplexml_load_string($settings);
			$base_url = ($update->module_id == 0) ? './' : 'modules/'.$module->directory.'/';
			
			foreach($xml->actions as $action) {
				// Delete
				if(isset($action->delete)) {
					foreach($action->delete->file as $file) {
						unlink($base_url.$file);
					}
				}
				
				// Move
				if(isset($action->move)) {
					foreach($action->move->data as $data) {
						$from = $base_url . $data->from;
						$to = $base_url . $data->to;
						rename($from, $to);
					}
				}
				
				// Database
				if(isset($action->database)) {
					foreach($action->database->file as $file) {
						$sql = file_get_contents($base_url.$file);
						Database_manager::get_db()->query($sql);
					}
				}
			}

			$zip->close();			
		} else {
			throw new Exception();
		}
	}
	
	public static function pre_dashboard_generate($dashboard_manager) {
		$count = new Update();
		if($count->where('has_update = 1')->count() > 0) {
			$dashboard_manager->add_widget('update/updates/widget', 'admin');
		}
	}
}

/* End of file callback_helper.php */
/* Location: ./modules/update/helpers/callback_helper.php */
<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * The Notification_manager class. This class manages the notifications.
 */
class Notification_manager {
	private $CI;
	private $notifications;

	public function __construct() {
		$this->CI =& get_instance();
		$this->notifications = array();
		$this->CI->load->library('session');
	}
	
	/**
	 * Add a notification
	 * @param $type
	 * 		The type of the notification. Currently only "error", "update" or "succes" types are implemented.
	 * @param $text
	 * 		The text inside the notification
	 */
	public function add_notification($type, $text) {
		$this->notifications[] = array("type" => $type, "text" => $text);
	}
	
	/**
	 * Get the notifications
	 * @param $as_html
	 * 		Whether or not the ouput should be given as HTML. Default is TRUE
	 * @return
	 * 		The notificaitons
	 */
	public function get_notifications($as_html = TRUE) {
		if($as_html === FALSE) {
			return $this->notifications;
		}
		
		Hook_manager::execute_hook('pre_notifications_generate', $this);		
		$html = $this->get_notifications_html();
		Hook_manager::execute_hook('post_notifications_generate', $html);
		
		return $html;
	}
	
	/**
	 * Get the notifications as html
	 * @return
	 * 		The notifications as html
	 */
	private function get_notifications_html() {
		$html = '';
		
		foreach($this->notifications as $notification){
			$html .= '<div class="sc-msg sc-msg-'.$notification['type'].'">';
				$html .= $notification['text'];
			$html .= '</div>';
		}
		
		return $html;
	}
}

/* End of file Notification_manager.php */
/* Location: ./application/libraries/Notification_manager.php */
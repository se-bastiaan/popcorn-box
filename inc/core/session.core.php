<?php if(!class_exists('Config')) exit('No direct script access allowed');

session_start();

class Session {

	public static function init() {		
		$has_session = false;

		$db = new Database();

		$over_time = $db->get('sessions');
		$over_time = $over_time->fetchAll();
		foreach ($over_time as $key => $value) {
			if(time() > intval($value['time'])) $db->delete('sessions', array('id'=>$value['id']));
		}


		if(isset($_SESSION['id'])) {
			$browser_data = array(
				'session' => $_SESSION['id'],
				'useragent' => Routing::get_useragent(),
				'ip' => Routing::get_ip()
			);
			$get = $db->get('sessions', $browser_data);
			$value = $get->fetch();
			if(!empty($value) && $value['time'] > time()) {
				$has_session = true;
			}
		}

		if(!$has_session) {
			$session_id = md5(uniqid(rand(), true).date('His').Routing::get_ip().Routing::get_useragent());
			$_SESSION['id'] = $session_id;
			$db->insert('sessions',
				array(
					'session' => $session_id,
					'time' => (time()+(60*60)),
					'useragent' => Routing::get_useragent(),
					'ip' => Routing::get_ip(),
					'userdata' => json_encode(array())
				)
			);
		} else {
			$db->update('sessions',
				array(
					'time' => (time()+(60*60))
				),
				$browser_data
			);
		}


	}

	public static function set_userdata($param, $value = null) {
		$browser_data = array(
			'session' => $_SESSION['id'],
			'useragent' => Routing::get_useragent(),
			'ip' => Routing::get_ip()
		);
		$db = new Database();
		$get = $db->get('sessions', $browser_data);
		$values = $get->fetch();
		$userdata = (array) json_decode($values['userdata']);
		if(!is_array($userdata)) $userdata = array();
		if(is_array($param)) {
			foreach($param as $key => $value) {
				$userdata[$key] = $value;
			}
		} else {
			$userdata[$param] = $value;
		}	
		$userdata = json_encode($userdata);
		$db->update('sessions', array(
			'userdata' => $userdata
			),
			$browser_data
		);
	}

	public static function get_userdata($key = null) {
		$browser_data = array(
			'session' => $_SESSION['id'],
			'useragent' => Routing::get_useragent(),
			'ip' => Routing::get_ip()
		);
		$db = new Database();
		$get = $db->get('sessions', $browser_data);
		$values = $get->fetch();
		$userdata = json_decode($values['userdata'], true);
		if(!is_null($key)) {
			return (isset($userdata[$key]) ? $userdata[$key] : false);
		}
		return $userdata;
	}

	public static function unset_userdata($key) {
		$browser_data = array(
			'session' => $_SESSION['id'],
			'useragent' => Routing::get_useragent(),
			'ip' => Routing::get_ip()
		);
		$db = new Database();
		$get = $db->get('sessions', $browser_data);
		$values = $get->fetch();
		$userdata = (array) json_decode($values['userdata']);
		unset($userdata[$key]);
		$userdata = json_encode($userdata);	
		$db->update('sessions',
			array(
				'userdata' => $userdata
			),
			$browser_data
		);
	}

	public static function reset() {
		$browser_data = array(
			'session' => $_SESSION['id'],
			'useragent' => Routing::get_useragent(),
			'ip' => Routing::get_ip()
		);
		$db = new Database();
		$db->delete('sessions', $browser_data);
		session_destroy();
	}

}
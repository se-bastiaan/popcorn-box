<?php if(!class_exists('Config')) exit('No direct script access allowed');

if(!class_exists('Session')) throw new Exception("Auth: Missing Session class");

class Auth {

	public static function is_loggedin() {
		return (Session::get_userdata('loggedin') ? true : false);
	}

	public static function is_admin() {
		return (Session::get_userdata('level') >= 1 ? false : true);
	}

	public static function get_user($id = null) {
		$db = new Database();
	
		$values = array();
		if($id !== null) {
			$id = intval($id);
			$values = array(
				"id" => $id
			);
		}
	
		$users = $db->get('users',
			$values
		);
		
		$users = $users->fetchAll();
		
		if($id !== null) {
			$users = $users[0];
		}
		
		return $users;
	}

	public static function create_user($username, $password, $level = 1) {
		$db = new Database();
		
		if(count($db->get('users', array('username'=>$username))->fetchAll()) == 0) {
			return $db->insert('users',
				array(
					"username" => $username,
					"password" => self::hash($password),
					"level" => $level, //0 = admin
					"last_login" => null
				)
			);
		} else {
			return 'User exists';
		}		
	}
	
	public static function update_user_login($id) {
		$db = new Database();
		
		return $db->update('users',
			array(
				"last_login" => date("d-m-Y H:i:s")
			),
			array(
				"id" => $id
			)
		);
	}

	public static function update_user($id, $password = null, $level = null) {
		$db = new Database();
		$update = array();
		
		if(!empty($password)) $update['password'] = self::hash($password);
		if(!is_null($level) && !empty($level)) $update['level'] = intval($level);
		
		return $db->update('users',
			$update,
			array(
				"id" => $id
			)
		);
	}

	public static function delete_user($id) {
		$db = new Database();
		$id = intval($id);
		return $db->delete('users', array('id' => $id));
	}

	public static function check($username = null, $password = null) {
		$db = new Database();
	
		if(Session::get_userdata('loggedin')) {
			$return = true;
		} else {
			$user = $db->get('users', 
				array(
					"username" => $username,
					"password" => self::hash($password)
				)
			);
			$values = $user->fetchAll();		
			$return = (count($values) == 1 ? true : false);
			if($return) {
				$user = $values[0];
				unset($user['password']);
				$user['loggedin'] = true;
				Session::set_userdata($user);
			}
		}
		return $return;
	}

	public static function logout() {
		Session::reset();
	}

	private static function hash($password) {
		$config = new Config();
		return hash_hmac('SHA512', $password, Config::get("config", "server_encryption_key"));
	}

}
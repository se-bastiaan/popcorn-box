<?php

class Couchpotato {
	
	private static function get_data($cmd, $nojson = false) {
		$data = file_get_contents("http://localhost:5050/api/8b9e7db6abd545c7aa2a64ffa433f855/" . $cmd);
		
		if($nojson) return $data;
		return json_decode($data, true);
	}
	
	public static function get_medialist($only_done = false) {
		if($only_done) {
			return self::get_data("media.list/?status=downloaded,done");
		} else {
			return self::get_data("media.list");
		}
	}
	
	public static function get_media($id) {
		return self::get_data("media.get?id=" . $id);
	}
	
	public static function get_wanted() {
		return self::get_data("media.list/?status=wanted,active");
	}
	
}
<?php

class Sickbeard {
	
	private static function get_data($cmd, $nojson = false) {
		$data = file_get_contents("http://localhost:5151/api/b9e0f3f20420bd28eb622cc99e5ca557/" . "?cmd=" . $cmd);
		
		if($nojson) return $data;
		return json_decode($data, true);
	}
	
	public static function get_shows() {
		return self::get_data("shows");
	}
	
	public static function get_show($tvdbid) {
		return self::get_data("show&tvdbid=" . $tvdbid);
	}
	
	public static function refresh_show($tvdbid) {
		return self::get_data("show.refresh&tvdbid=" . $tvdbid);
	}
	
	public static function get_show_poster($tvdbid) {
		return self::get_data("show.getposter&tvdbid=" . $tvdbid, true);
	}
	
	public static function get_show_banner($tvdbid) {
		return self::get_data("show.getbanner&tvdbid=" . $tvdbid, true);
	}
	
	public static function get_show_seasons($tvdbid, $season = false) {
		if($season === false) {
			return self::get_data("show.seasons&tvdbid=" . $tvdbid . "&season=" . $season);
		} else {
			return self::get_data("show.seasons&tvdbid=" . $tvdbid);
		}
	}
	
	public static function get_show_episode($tvdbid, $season, $episode) {
		return self::get_data("episode&tvdbid=" . $tvdbid . "&season=" . $season . "&episode=" . $episode . "&full_path=1");
	}
	
	public static function search_show_episode($tvdbid, $season, $episode) {
		return self::get_data("episode.search&tvdbid=" . $tvdbid . "&season=" . $season . "&episode=" .$episode);
	}
	
	public static function get_history() {
		return self::get_data("history");
	}
	
}
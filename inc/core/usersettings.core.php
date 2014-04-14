<?php if(!class_exists('Config')) exit('No direct script access allowed');

class UserSettings {

	private $filedata;
	private $filename;

	public function __construct() {
		$this->filename = Routing::root_dir('database') . 'settings.db';
	
		if(file_exists($this->filename)) {
			$this->filedata = json_decode(file_get_contents($this->filename), true);
		} else {
			$this->filedata = array();
		}
	}
	
	private function save() {		
		file_put_contents($this->filename, json_encode($this->filedata));
	}
	
	public function set($key, $value) {
		$this->filedata[$key] = $value;
		$this->save();
	}

	public function get($key) {
		if(isset($this->filedata[$key])) {
			return $this->filedata[$key];
		}
		return null;
	}

}
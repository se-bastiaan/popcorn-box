<?php

	class Config {

		private $data = array();
		private $current_directory;

		public static function get($file, $key) {
			$current_directory = str_replace("/core", "", dirname(__FILE__));
			if(file_exists($current_directory . '/config/' . $file . '.php')) {
				require($current_directory . '/config/' . $file . '.php');
				if(is_array($config) && array_key_exists($key, $config)) {
					return $config[$key];
				}
			}
			return false;
		}

	}
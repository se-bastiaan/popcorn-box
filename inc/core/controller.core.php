<?php

	class Controller {

		public $config;
		public $routing;
		public $settings;
		protected $output;
		protected $page_data = array();

		private $inside_view = false;

		public function __construct() {
			$this->config = new Config();
			$this->routing = new Routing();
			$this->settings = new UserSettings();
			
			Session::init();
			
			$this->page_data['header_data']['menu_data'] = array(
				array(
					'title' => 'Home',
					'url' => 'index',
					'active' => false
					),
				array(
					'title' => 'TV Shows',
					'url' => 'shows',
					'active' => false
					),
				array(
					'title' => 'Movies',
					'url' => 'movies',
					'active' => false
					),
				array(
					'title' => 'Downloads',
					'url' => 'downloads',
					'active' => false
					)
			);
			
			$this->page_data['template'] = '';
			$this->page_data['template_data'] = array();
			$this->page_data['header_data']['error_message'] = null;
			$this->page_data['header_data']['tabs'] = array();

			foreach($this->page_data['header_data']['menu_data'] as $k => $menu_item) {
				if($menu_item['url'] == Routing::get_segment(0)) {
					$this->page_data['header_data']['menu_data'][$k]['active'] = true;
				}
			}
			
			if(!Auth::is_loggedin() && Routing::get_segment(0) != "auth") {
				Routing::redirect("auth");
			}
		}
		
		protected function add_tab($url, $title, $class) {
			$data = array(
				"url" => $url,
				"title" => $title,
				"class" => $class
				);
			array_push($this->page_data['header_data']['tabs'], $data);
		}
		
		protected function set_errormessage($type = "info", $title = "", $message = "") {
			$this->page_data['header_data']['error_message'] = array($type, $title, $message);
		}

		protected function load_view($view, $params = null) {
			$path = Routing::base_uri(str_replace("/core", "", dirname(__FILE__)).'/views/'.$view.'.view.php');
			if(!file_exists($path)) return;
			if($this->inside_view) {
				if($params != null)
				extract($params, EXTR_OVERWRITE);
				include($path);
			} else {
				$this->inside_view = true;
				ob_start();
				if($params != null)
				extract($params, EXTR_OVERWRITE);				
				include($path);
				if(Config::get('config', 'debug')) {
					echo "<pre style=\"margin-top: 20px;\">"; var_dump($_POST); echo "</pre>";
					echo "<pre>"; var_dump($_SERVER); echo "</pre>";
					echo "<pre>"; var_dump($params); echo "</pre>";
				}
				$buffer = ob_get_contents();
				ob_end_clean();
				$this->output .= $buffer;
				$this->inside_view = false;
			}
		}

		public function do_output() {
			echo $this->output;
		}

		public function _404($method) {
			echo '404';
		}

	}
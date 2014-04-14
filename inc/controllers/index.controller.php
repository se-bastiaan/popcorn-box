<?php

	class Index_Controller extends Controller {

		public function __construct() {
			parent::__construct();
		}

		public function get_index() {
			$this->page_data['header_data']['page_title'] = 'Home';
			$this->page_data['template'] = 'index';
			$this->load_view('main', $this->page_data);
		}

	}
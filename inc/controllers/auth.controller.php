<?php

	class Auth_Controller extends Controller {

		public function __construct() {
			parent::__construct();
			//if(Auth::is_loggedin() && Routing::get_segment(1) !== "signout") Routing::redirect("");
		}

		public function get_index() {
			Routing::redirect("auth/signin");
		}
		
		public function get_signin() {
			$this->page_data['crsf'] = NoCRSF::generate('keycode');			
			$this->load_view('login', $this->page_data);
		}
		
		public function post_signin() {			
			if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['keycode']) && NoCRSF::check('keycode', $_POST)) {
				$user = Auth::check($_POST['username'], $_POST['password']);
				if($user) {
					Auth::update_user_login(Session::get_userdata('id'));
					Routing::redirect("");
				}
			}
			$this->page_data['login_error'] = true;
		
			$this->get_signin();
		}
		
		public function get_signout() {
			Auth::logout();
			Routing::redirect("");
		}

	}
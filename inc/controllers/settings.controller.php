<?php

class Settings_Controller extends Controller {
	
	public function get_index() {
		if(!Auth::is_admin()) Routing::redirect("settings/profile");
		$this->page_data['header_data']['page_title'] = 'Settings - General';
		$this->page_data['template'] = 'settings/main';
		
		$this->load_view('main', $this->page_data);
	}
	
	public function post_index() {
		if(!Auth::is_admin()) Routing::redirect("settings");
		
		$this->set_errormessage("success", "", "Your data has been saved.");
		
		$this->get_index();
	}
	
	public function get_profile() {
		$this->page_data['header_data']['page_title'] = 'Settings - Profile';
		$this->page_data['template'] = 'settings/profile';
		$this->page_data['template_data']['username'] = Session::get_userdata('username');
		$this->load_view('main', $this->page_data);

	}
	
	public function post_profile() {
		$this->set_errormessage("danger", "Error!", "Something went wrong. Your credentials didn't change. Check your input.");
		
		if(isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] == $_POST['password2']) {
			Auth::update_user(Session::get_userdata('id'), $_POST['password']);
			$this->set_errormessage("success", "", "Your credentials have been saved successfully.");
		}	
			
		$this->get_profile();
	}
	
	public function get_users($main = false) {
		if(!Auth::is_admin()) Routing::redirect("settings");
		
		$this->page_data['header_data']['page_title'] = 'Settings - Users';
	
		if(Routing::get_segment(2) == "edit" && !$main) {
			if(!Routing::get_segment(3)) Routing::redirect(Routing::get_segment(0) . "/" . Routing::get_segment(1));
			$this->get_users_edit(Routing::get_segment(3));
		} else if(Routing::get_segment(2) == "add" && !$main) {
			$this->get_users_add();
		} else if(Routing::get_segment(2) == "delete" && !$main) {
			if(!Routing::get_segment(3)) Routing::redirect(Routing::get_segment(0) . "/" . Routing::get_segment(1));
			$this->get_users_delete(Routing::get_segment(3));
		} else {
			$this->page_data['template'] = 'settings/users';
			$this->page_data['template_data']['users'] = Auth::get_user();
			$this->load_view('main', $this->page_data);
		}
	}
	
	public function post_users() {
		if(!Auth::is_admin()) Routing::redirect("settings");
		
		$this->page_data['header_data']['page_title'] = 'Settings - Users';
	
		if(Routing::get_segment(2) == "edit") {
			if(!Routing::get_segment(3)) Routing::redirect(Routing::get_segment(0) . "/" . Routing::get_segment(1));
			$this->post_users_edit(Routing::get_segment(3));
		} else if(Routing::get_segment(2) == "add") {
			$this->post_users_add();
		} else {	
			$this->get_users();
		}
	}
	
	private function get_users_edit($id) {
		$user = Auth::get_user($id);
		
		if(Routing::get_segment(4) == "new") {
			$this->set_errormessage("success", "", "The new user has been created.");
		}
		
		$this->page_data['template'] = 'settings/users.edit';
		$this->page_data['template_data']['username'] = $user['username'];
		$this->page_data['template_data']['level'] = $user['level'];

		$this->load_view('main', $this->page_data);
	}
	
	private function post_users_edit($id) {
		$this->set_errormessage("danger", "Error!", "Something went wrong. The credentials didn't change. Check your input.");
		
		if(isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] == $_POST['password2']) {
			Auth::update_user($id, $_POST['password'], intval($_POST['level']));
			$this->set_errormessage("success", "", "The credentials have been saved successfully.");
		}
	}
	
	private function get_users_add() {
		$this->page_data['template'] = 'settings/users.edit';
		$this->load_view('main', $this->page_data);
	}
	
	private function post_users_add() {
		$this->set_errormessage("danger", "Error!", "Something went wrong. The system couldn't create a new users. Check your input.");
		
		if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] == $_POST['password2']) {
			$r = Auth::create_user($_POST['username'], $_POST['password'], intval($_POST['level']));
			if($r == "User exists") {
				$this->set_errormessage("danger", "", "This username is already in use.");
			} else {
				Routing::redirect("settings/users/edit/".$r."/new");
			}
		}
		
		$this->get_users_add();
	}
	
	private function get_users_delete($id) {
		$user = Auth::get_user($id);
		Auth::delete_user($id);
		$this->set_errormessage("success", "", "The user with username '" . $user['username'] . "' has been deleted.");
		$this->get_users(true);
	}
	
}
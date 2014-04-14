<?php

class Movies_Controller extends Controller {

	public function __construct() {
		parent::__construct();
		$this->add_tab("movies/available", "Downloaded", (Routing::get_segment(1) == "available" ? "active" : ""));
		$this->add_tab("movies/wanted", "Wanted", (Routing::get_segment(1) == "wanted" ? "active" : ""));
	}
	
	public function get_index() {
		Routing::redirect("movies/available");
	}
	
	public function get_available() {
		$this->page_data['header_data']['page_title'] = 'Movies - Available';
		$this->page_data['template'] = 'movies/main';
	
		$movies = Couchpotato::get_medialist(true);
		if($movies["success"]) {
			$this->page_data['template_data']['movies'] = $movies['movies'];
		} else {
			$this->page_data['template_data']['movies'] = array();
			$this->set_errormessage("danger", "Something went wrong. The system couldn't load the movies.");
		}
		
		$this->load_view('main', $this->page_data);
	}
	
	public function get_wanted() {
		$this->page_data['header_data']['page_title'] = 'Movies - Wanted';
		$this->page_data['template'] = 'movies/main';
	
		$movies = Couchpotato::get_wanted();
		if($movies["success"]) {
			$this->page_data['template_data']['movies'] = $movies['movies'];
		} else {
			$this->page_data['template_data']['movies'] = array();
			$this->set_errormessage("danger", "Something went wrong. The system couldn't load the movies.");
		}
		
		$this->load_view('main', $this->page_data);
	}
	
	public function get_movie() {
		if(!Routing::get_segment(2)) {
			Routing::redirect("shows");
		} else {
			$movie = Couchpotato::get_media(Routing::get_segment(2));
			if($movie["success"]) {
				//unset($show['data']['season_list'][array_search(0, $show['media']['season_list'])]);
				$this->page_data['template_data']['movie'] = $movie['media'];
				$this->page_data['header_data']['page_title'] = 'Movies - ' . $movie['media']['library']['info']['original_title'];
			} else {
				$this->page_data['header_data']['page_title'] = 'Movies - Unknown name';
				$this->page_data['template_data']['shows'] = array();
				$this->set_errormessage("danger", "Something went wrong. The system couldn't load the show.");
			}
		
			$this->page_data['template'] = 'movies/movie';
			$this->load_view('main', $this->page_data);
		}
	}
		
}
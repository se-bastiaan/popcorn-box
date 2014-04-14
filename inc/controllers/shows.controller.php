<?php

class Shows_Controller extends Controller {

	public function __construct() {
		parent::__construct();	
		if(Routing::get_segment(1) == "latest" || Routing::get_segment(1) == "all") {
			$this->add_tab("shows/latest", "Latest episodes", (Routing::get_segment(1) == "latest" ? "active" : ""));
			$this->add_tab("shows/all", "All shows", (Routing::get_segment(1) == "all" ? "active" : ""));
		}
	}
	
	public function get_index() {
		Routing::redirect('shows/latest');
	}
	
	public function get_all() {
		$this->page_data['header_data']['page_title'] = 'Shows';
		$this->page_data['template'] = 'shows/main';
		
		if(Routing::get_segment(2) == null) {
			Routing::redirect(Routing::get_segment(0) . '/' . Routing::get_segment(1) . '/1');
		}
		
		$page = Routing::get_segment(2);
	
		$shows = Sickbeard::get_shows();
		if($shows["result"] == "success") {
			$show_data = $shows['data'];
			
			$page_offset = ($page - 1) * 8;
			
			$show_data = array_slice($show_data, $page_offset, 8);
		
			$this->page_data['template_data']['all_shows'] = $shows['data'];
			$this->page_data['template_data']['shows'] = $show_data;
		} else {
			$this->page_data['template_data']['shows'] = array();
			$this->set_errormessage("danger", "Something went wrong. The system couldn't load the shows.");
		}
		
		$this->load_view('main', $this->page_data);
	}
	
	public function get_latest() {
		$this->page_data['header_data']['page_title'] = 'Shows';
		$this->page_data['template'] = 'shows/latest';
	
		$shows = Sickbeard::get_history();
		if($shows["result"] == "success") {
			$show_data = array();
			
			foreach($shows['data'] as $show) {
				if($show['status'] == "Downloaded")
					$show_data[] = $show;
			}
			
			$show_data = array_slice($show_data, 0, 12);
		
			$this->page_data['template_data']['shows'] = $show_data;
		} else {
			$this->page_data['template_data']['shows'] = array();
			$this->set_errormessage("danger", "Something went wrong. The system couldn't load the shows.");
		}
		
		$this->load_view('main', $this->page_data);
	}
	
	public function get_show() {
		if(!Routing::get_segment(2)) {
			Routing::redirect("shows");
		} else {
			$show = Sickbeard::get_show(Routing::get_segment(2));
			if($show["result"] == "success") {
				unset($show['data']['season_list'][array_search(0, $show['data']['season_list'])]);
				$this->page_data['template_data']['show'] = $show['data'];
			} else {
				$this->page_data['template_data']['shows'] = array();
				$this->set_errormessage("danger", "Something went wrong. The system couldn't load the show.");
			}
			
			$seasons = Sickbeard::get_show_seasons(Routing::get_segment(2));
			if($seasons["result"] == "success") {
				unset($seasons['data'][0]);
				$this->page_data['template_data']['seasons'] = $seasons['data'];
				$this->page_data['header_data']['page_title'] = 'Shows - ' . $show['data']['show_name'];
			} else {
				$this->page_data['header_data']['page_title'] = 'Shows - Unknown show';
				$this->page_data['template_data']['seasons'] = array();
				$this->set_errormessage("danger", "Something went wrong. The system couldn't load the show's episodes.");
			}
		
			$this->page_data['template'] = 'shows/show';
			$this->load_view('main', $this->page_data);
		}
	}
	
	public function get_episode() {
		if(!Routing::get_segment(2) || !Routing::get_segment(3) || !Routing::get_segment(4)) {
			Routing::redirect("shows");
		} else {
			$show = Sickbeard::get_show(Routing::get_segment(2));
			if($show["result"] == "success") {
				unset($show['data']['season_list'][array_search(0, $show['data']['season_list'])]);
				$this->page_data['template_data']['show'] = $show['data'];
			} else {
				$this->page_data['template_data']['show'] = array();
				$this->set_errormessage("danger", "Something went wrong. The system couldn't load the show.");
			}

			$episode = Sickbeard::get_show_episode(Routing::get_segment(2), Routing::get_segment(3), Routing::get_segment(4));
			if($episode["result"] == "success") {
				$this->page_data['template_data']['episode'] = $episode['data'];
			} else {
				$this->page_data['template_data']['episode'] = array();
				$this->set_errormessage("danger", "Something went wrong. The system couldn't load the episode.");
			}
		
			if($episode["result"] == "success" && $show["result"] == "success") {
				$this->page_data['header_data']['page_title'] = 'Shows - ' . $show['data']['show_name'] . ' - ' . $episode['data']['name'];
			} else {
				$this->page_data['header_data']['page_title'] = 'Shows';
			}
			$this->page_data['template'] = 'shows/episode';
			$this->load_view('main', $this->page_data);
		}
	}
	
	public function get_search_episode() {
		if(!Routing::get_segment(2) || !Routing::get_segment(3) || !Routing::get_segment(4)) {
			Routing::redirect("shows");
		} else {
			$this->output = json_encode(Sickbeard::search_show_episode(Routing::get_segment(2), Routing::get_segment(3), Routing::get_segment(4)));
		}
	}
	
	public function get_refresh_show() {
		$this->output = json_encode(Sickbeard::refresh_show(Routing::get_segment(2)));
	}
	
	public function get_poster() {
		if(!Routing::get_segment(2)) {
			Routing::redirect("shows");
		} else {
			header("Content-Type: image/png");
			header('Cache-Control: public');
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
			header('Expires: ' . gmdate('D, d M Y H:i:s', time() + (60*60*24*45)) . ' GMT');
			$segment = Routing::get_segment(2);
			$segment = str_ireplace(".img", "", $segment);
			
			$file_path = Routing::root_dir() . "cache/posters/" . $segment . ".png";
			
			if(!file_exists($file_path) || (filemtime($file_path) + (60*60*24*30) < time())) {
				$image_str = Sickbeard::get_show_poster($segment);
				
				$image = imagecreatefromstring($image_str);
				
				list($width, $height) = getimagesizefromstring($image_str);
				$new_height = 400;
				$new_width = ($new_height / $height) * $width;
				
				$new_image = imagecreatetruecolor($new_width, $new_height);
				imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				
				ob_start();
				imagepng($new_image, $file_path);
				ob_end_clean();		
			}
			Routing::redirect("cache/posters/" . $segment . ".png" );
		}
	}
	
	public function get_banner() {
		if(!Routing::get_segment(2)) {
			Routing::redirect("shows");
		} else {
			header("Content-Type: image/jpeg");
			header('Cache-Control: public');
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
			header('Expires: ' . gmdate('D, d M Y H:i:s', time() + (60*60*24*45)) . ' GMT');
			$segment = Routing::get_segment(2);
			$segment = str_ireplace(".img", "", $segment);
			$this->output = Sickbeard::get_show_banner($segment);
		}
	}
		
}
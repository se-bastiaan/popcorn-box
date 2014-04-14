<?php

class Downloads_Controller extends Controller {
	
	public function get_index() {
		$rpc = new TransmissionRPC('http://localhost:8080/transmission/rpc', 'se_bastiaan', 'Beest1q2w3e');
		$rpc->return_as_array = true;
		$result = $rpc->get(array(), array( "name", "status", "doneDate", "location", "isFinished", "leftUntilDone", "rateDownload", "totalSize", "percentDone", "secondsDownloading", "eta", "etaIdle", "downloadDir" ));
		
		$torrents = array();
		foreach($result['arguments']['torrents'] as $data) {
			if((!isset($data["isFinished"]) || !$data["isFinished"]) && $data['percentDone'] < 1 && (stristr($data['downloadDir'], "/RPiTorrents/Complete/Films") || stristr($data['downloadDir'], "/RPiTorrents/Complete/Series"))) {
				$torrent = array();
				$torrent['percentage'] = round($data['percentDone'] * 100);
				
				if($data['eta'] == -1) {
					$torrent['eta'] = 'Download is paused';
				} elseif($data['eta'] == -2) {
					$torrent['eta'] = 'Unknown time left';
				} else {
					$minutes = round($data['eta'] / 60);
					$time = $minutes . ' minute(s) remaining';
					if($minutes > 60) {
						$hours = floor($minutes / 60);
						$minutes = $minutes - $hours * 60;
						$time = $hours . ' hour(s) & ' . $minutes . ' minute(s) remaining';
					}
					$torrent['eta'] = $time;
				}
				
				$torrent['name'] = $data['name'];
				$torrent['currentSize'] = round(($data['totalSize'] - $data['leftUntilDone']) / 1048576, 2) . " MB";
				$torrent['fullSize'] = round($data['totalSize'] / 1048576, 2) . " MB";
				$torrent['status'] = $data['status'];
				
				array_push($torrents, $torrent);
			}
		}
		
		$this->page_data['header_data']['page_title'] = 'Shows';
		$this->page_data['template'] = 'downloads';
		$this->page_data["template_data"]["torrents"] = $torrents;
		$this->load_view('main', $this->page_data);
	}
	
}
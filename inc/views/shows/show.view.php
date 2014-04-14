<?php if(isset($show)) : ?>
<div class="container-fluid show-data">
	<div class="row">
	
		<div class="col-xs-12 col-sm-3 show-item">
			<img class="show-poster hidden-xs" src="<?php echo Routing::base_url("shows/poster/" . Routing::get_segment(2)); ?>.img" />
			<img class="show-poster visible-xs" src="<?php echo Routing::base_url("shows/banner/" . Routing::get_segment(2)); ?>.img" />
		</div>
		
		<div class="col-xs-12 col-sm-9 show-item">
			<h1 class="show-title"><?php echo $show['show_name']; ?></h1>
			<div class="table-responsive">
				<table class="table">
					<tr>
						<td>Originally airs:</td>
						<td><?php echo $show['airs']; ?> on <?php echo $show['network']; ?></td>
					</tr>
					<tr>
						<td>Status:</td>
						<td><?php echo $show['status']; ?></td>
					</tr>
					<tr>
						<td>Seasons:</td>
						<td><?php echo count($show['season_list']); ?></td>
					</tr>
					<tr>
						<td>Quality:</td>
						<td>
							<?php if($show['quality'] == "SD") : ?>
								<span class="glyphicon glyphicon-sd-video icon-tooltip" title="Medium quality video. Not 1080p. (The quality SickBeard is searching for)"></span>
							<?php else : ?>
								<span class="glyphicon glyphicon-hd-video icon-tooltip" data-toggle="tooltip" data-placement="top" title="High quality video. 1080p. (The quality SickBeard is searching for)"></span>
							<?php endif; ?>
						</td>

					</tr>
					<tr>
						<td>Active:</td>
						<td>
							<?php if(!$show['paused']) : ?>
								<span class="glyphicon glyphicon-ok icon-tooltip" title="SickBeard will automatically search for new episodes to download. These episodes will be downloaded a couple of hours after they aired."></span>
							<?php else : ?>
								<span class="glyphicon glyphicon-remove icon-tooltip" data-toggle="tooltip" data-placement="top" title="SickBeard will not automatically search for new episodes to download."></span>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td>
							<a target="_blank" href="http://www.tvrage.com/shows/id-<?php echo $show['tvrage_id']; ?>">More info</a>
						</td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
	
	</div>
	
	<?php
		$seasons = array_reverse($seasons);
		$count = count($seasons);
		foreach($seasons as $k => $season) :
		$number = $count;
		$count--;
	?>
		<h2>Season <?php echo $number; ?></h2>
		<table class="table">
			<thead>
				<tr>
					<th style="width: 110px;">Airdate</th>
					<th>Name</th>
					<th style="width: 115px;">Status</th>
					<th style="width: 115px;">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				$season = array_reverse($season);
				$count_episodes = count($season);
				foreach($season as $e => $episode) :
				$number_episode = $count_episodes;
				$count_episodes--;
			?>
				<tr class="<?php if(stristr($episode['status'], "Downloaded") || stristr($episode['status'], "Archived")) echo 'success'; if(stristr($episode['status'], "Unaired")) echo 'warning'; if(stristr($episode['status'], "Skipped")) echo 'danger'; if(stristr($episode['status'], "Snatched")) echo 'info'; ?>">
					<td>
						<?php echo $episode['airdate']; ?>
					</td>
					<td>
						<a href="<?php echo Routing::base_url("shows/episode/" . Routing::get_segment(2) . "/" . $number . "/" . $number_episode); ?>">
							<?php echo $episode['name']; ?>
						</a>
					</td>
					<td>
						<?php echo $episode['status']; ?>
					</td>
					<td>
						<a href="<?php echo Routing::base_url("shows/episode/" . Routing::get_segment(2) . "/" . $number . "/" . $number_episode); ?>">
							Show details
						</a>
					</td>
				</tr>
				</a>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php endforeach; ?>
</div>
<?php endif; ?>
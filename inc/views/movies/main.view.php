<div class="alert alert-info" style="margin-top:10px;">Searching for some fancy movies? And you want to be able to watch them on the fly without any downloads to our system? Then take a look at <a href="http://popcorn.cdnjd.com/">Popcorn Time</a>, the best movie streaming application for your computer.</div>

<div class="container-fluid">

<?php
	$processed = array();
	foreach($movies as $k => $movie) {
		if($movie['status_id'] == 7 || file_exists('/media/hdd/RPiTorrents/Films/' . $movie['library']['info']['original_title'] . ' (' . $movie['library']['info']['year'] . ').mp4') || file_exists('/media/hdd/RPiTorrents/Films/' . $movie['library']['info']['original_title'] . ' (' . $movie['library']['info']['year'] . ').mkv') || file_exists('/media/hdd/RPiTorrents/Films/' . $movie['library']['info']['original_title'] . ' (' . $movie['library']['info']['year'] . ').avi'))
		$processed[$k] = $movie;
	}
	
	$movies = $processed;
	
	$count = count($movies);
	$i = 0;
	$row = 0;
	foreach($movies as $k => $movie) :
?>

	<?php if(!($i % 4)) : ?>
		<div class="row shows-overview row-<?php echo $row; ?>">
	<?php endif;?>
	
		<div class="col-xs-6 col-sm-3 shows-item">
			<?php if($movie['status_id'] !== 7) : ?>
				<a href="<?php echo Routing::base_url("movies/movie/" . $movie['library_id']); ?>" class="link">
			<?php else: ?>
				<div class="link">
			<?php endif; ?>
				<div class="shows-overlay">				
					<div class="shows-title"><?php echo $movie['library']['info']['original_title']; ?></div>
					<div class="shows-status"><?php echo $movie['library']['info']['year']; ?></div>
					<div class="shows-next"><?php echo implode(", ", $movie['library']['info']['genres']); ?></div>
				</div>
				<?php if(isset($movie['library']['info']['images']['poster_original'][0])) : ?>
				<img class="shows-poster" src="<?php echo $movie['library']['info']['images']['poster_original'][0]; ?>" />
				<?php else : ?>
				<img class="shows-poster" src="<?php echo Routing::base_url('assets/img/poster.png'); ?>" />
				<?php endif; ?>
			<?php if($movie['status_id'] !== 7) : ?>
				</a>
			<?php else: ?>
				</div>
			<?php endif; ?>
		</div>
	
		<?php $i++; ?>
		
	<?php if(!($i % 4) || $count == $i) : ?>
		</div>
	<?php
		$row++;
		endif;
	?>	
	
<?php
	
	endforeach;
?>

</div>
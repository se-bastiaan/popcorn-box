<?php if(!empty($episode['location']) && file_exists($episode['location'])) : ?>
	<!--<video class="video-box" controls poster="<?php echo Routing::base_url("shows/banner/" . Routing::get_segment(2)); ?>.img">
		<source src="<?php echo Routing::base_url("files/" . str_ireplace("/media/hdd/RPiTorrents/TV Series/", "", $episode["location"])) ?>" type="video/mp4">
	</video>-->
	
	<div class="video-box" id="jwplayer">Loading the player...</div>
	
	<script type="text/javascript">
	    jwplayer("jwplayer").setup({
	        file: "<?php echo Routing::base_url("files/" . str_ireplace("/media/hdd/RPiTorrents/TV Series/", "", $episode["location"])) ?>",
	        image: "<?php echo Routing::base_url("shows/banner/" . Routing::get_segment(2)); ?>.img",
	        type: "mp4",
	        width: "100%",
	        aspectratio: "16:9"
	    });
	</script>
<?php else : ?>
	<div class="video-box">
		<div class="no-media" style="background-image: url('<?php echo Routing::base_url("shows/banner/" . Routing::get_segment(2)); ?>');">
			<div class="text">No video found</div>
		</div>
	</div>
<?php endif; ?>
<div class="container video-description">
	<h2><?php echo $show['show_name'] . ' - ' . $episode['name']; ?>
	
		<?php if(!empty($episode['location']) && file_exists($episode['location'])) : ?>
			<a href="<?php echo Routing::base_url("files/" . str_ireplace("/media/hdd/RPiTorrents/TV Series/", "", $episode["location"])) ?>" class="btn">Download</a>
		<?php else: ?>
			<a href="#search-episode" data-url="<?php echo Routing::base_url("shows/search_episode/" . Routing::get_segment(2) . "/" . Routing::get_segment(3) . "/" . Routing::get_segment(4)) ?>" class="btn btn-search-episode">Search for video</a>
		<?php endif; ?>	
			<a href="#search-episode" data-url="<?php echo Routing::base_url("shows/refresh_show/" . Routing::get_segment(2)); ?>" class="btn btn-search-episode">Rescan for files</a>
	</h2>
	<table class="table">
		<tr>
			<td>Airdate:</td>
			<td><?php echo $episode['airdate']; ?></td>
		</tr>
		<tr>
			<td>Season:</td>
			<td><?php echo Routing::get_segment(3); ?></td>
		</tr>
		<tr>
			<td>Episode:</td>
			<td><?php echo Routing::get_segment(4); ?></td>
		</tr>
		<tr>
			<td>File size:</td>
			<td><?php echo $episode['file_size_human']; ?></td>
		</tr>
		<tr>
			<td>Quality:</td>
			<td><?php echo $episode['quality']; ?></td>
		</tr>
		<tr>
			<td>Status:</td>
			<td><?php echo $episode['status']; ?></td>
		</tr>
		<tr>
			<td colspan="2">Description:</td>
		</tr>
		<tr>
			<td colspan="2"><?php echo $episode['description']; ?></td>
		</tr>
	
	</table>
</div>
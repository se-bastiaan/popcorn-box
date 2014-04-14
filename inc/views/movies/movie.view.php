<?php
	$exists = isset($movie) && (file_exists('/media/hdd/RPiTorrents/Films/' . $movie['library']['info']['original_title'] . ' (' . $movie['library']['info']['year'] . ').mp4') || file_exists('/media/hdd/RPiTorrents/Films/' . $movie['library']['info']['original_title'] . ' (' . $movie['library']['info']['year'] . ').mkv') || file_exists('/media/hdd/RPiTorrents/Films/' . $movie['library']['info']['original_title'] . ' (' . $movie['library']['info']['year'] . ').avi'));
	
	if($exists) :
	
	$ext = "mp4";
	if(file_exists('/media/hdd/RPiTorrents/Films/' . $movie['library']['info']['original_title'] . ' (' . $movie['library']['info']['year'] . ').mp4')) $ext = "mp4";
	if(file_exists('/media/hdd/RPiTorrents/Films/' . $movie['library']['info']['original_title'] . ' (' . $movie['library']['info']['year'] . ').mkv')) $ext = "mkv";
	if(file_exists('/media/hdd/RPiTorrents/Films/' . $movie['library']['info']['original_title'] . ' (' . $movie['library']['info']['year'] . ').avi')) $ext = "avi";
?>
<!--<video class="video-box" controls poster="<?php echo $movie['library']['info']['images']['poster_original'][0]; ?>">
	<source src="<?php echo Routing::base_url("movie_files/" . $movie['library']['info']['original_title'] . ' (' . $movie['library']['info']['year'] . ').' . $ext) ?>" type="video/mp4">
</video>-->

<div class="video-box" id="jwplayer">Loading the player...</div>
	
<script type="text/javascript">
    jwplayer("jwplayer").setup({
        file: "<?php echo Routing::base_url("movie_files/" . $movie['library']['info']['original_title'] . ' (' . $movie['library']['info']['year'] . ').' . $ext) ?>",
        image: "<?php echo $movie['library']['info']['images']['poster_original'][0]; ?>",
        type: "mp4",
        width: "100%",
        aspectratio: "16:9"
    });
</script>

<div class="container video-description">
	<h2><?php echo $movie['library']['info']['original_title']; ?>
			<?php if($exists) : ?>
			<a href="<?php echo Routing::base_url("movie_files/" . $movie['library']['info']['original_title'] . ' (' . $movie['library']['info']['year'] . ').' . $ext) ?>" class="btn">Download</a>
			<?php endif; ?>
	</h2>
	<table class="table">
		<tr>
			<td>Year:</td>
			<td><?php echo $movie['library']['info']['year']; ?></td>
		</tr>
		<tr>
			<td>Genre:</td>
			<td><?php echo implode(", ", $movie['library']['info']['genres']); ?></td>
		</tr>
		<tr>
			<td>Length:</td>
			<td><?php echo $movie['library']['info']['runtime']; ?> minutes</td>
		</tr>
		<tr>
			<td colspan="2">Plot:</td>
		</tr>
		<tr>
			<td colspan="2"><?php echo $movie['library']['info']['plot']; ?></td>
		</tr>
	
	</table>
</div>
<?php endif; ?>
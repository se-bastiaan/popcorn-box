<?php if(count($torrents) > 0) : ?>
<ul class="download-list">
	<?php foreach($torrents as $torrent) : ?>
	<li>
		<h5><?php echo $torrent['name']; ?></h5>
		<div class="time-remaining"><?php echo $torrent['eta']; ?></div>
		<div class="size-remaining"><?php echo $torrent['currentSize']; ?> / <?php echo $torrent['fullSize']; ?></div>
		<div class="progress <?php echo ($torrent['status'] == 4 ? 'progress-striped active' : ''); ?>">
			<?php
				$progress_bar_class = "";
				if($torrent['status'] == 0) {
					$progress_bar_class = "progress-bar-warning";
				} elseif($torrent['status'] == 4) {
					$progress_bar_class = "progress-bar-success active striped";
				}
			?>
			<div class="progress-bar <?php echo $progress_bar_class; ?>" role="progressbar" aria-valuenow="<?php echo $torrent['percentage']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $torrent['percentage']; ?>%;">
		    <?php echo $torrent['percentage']; ?>%
			</div>
		</div>
	</li>
	<?php endforeach ?>
</ul>

<script type="text/javascript">
	setTimeout(function() { location.reload(); }, 5000);
</script>
<?php else : ?>
<h1>No downloads found.</h1>
<?php endif; ?>
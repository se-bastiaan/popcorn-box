<div class="container-fluid">

<?php
	$count = count($shows);
	$i = 0;
	$row = 0;
	foreach($shows as $k => $show) :
?>

	<?php if(!($i % 4)) : ?>
		<div class="row shows-overview row-<?php echo $row; ?>">
	<?php endif;?>
	
		<div class="col-xs-6 col-sm-3 shows-item">
			<a href="<?php echo Routing::base_url("shows/episode/" . $show['tvdbid'] . "/" . $show['season'] . "/" . $show['episode']); ?>" class="link">
				<div class="shows-overlay">				
					<div class="shows-title"><?php echo $show['show_name']; ?></div>
					<div class="shows-status">Season <?php echo $show['season']; ?> - Episode <?php echo $show['episode']; ?></div>
					<?php if($show['date'] == "") $show['date'] = "unknown"; ?>
					<div class="shows-next"><?php echo $show['date']; ?></div>
				</div>
				<img class="shows-poster" src="<?php echo Routing::base_url("shows/poster/" . $show['tvdbid']); ?>.img" />
			</a>
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
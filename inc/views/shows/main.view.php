<div class="container-fluid">

<?php
	$pages = ceil(count($all_shows) / 8);

	$count = count($shows);
	$i = 0;
	$row = 0;
	foreach($shows as $k => $show) :
?>

	<?php if(!($i % 4)) : ?>
		<div class="row shows-overview row-<?php echo $row; ?>">
	<?php endif;?>
	
		<div class="col-xs-6 col-sm-3 shows-item">
			<a href="<?php echo Routing::base_url("shows/show/" . $show['tvdbid']); ?>" class="link">
				<div class="shows-overlay">				
					<div class="shows-title"><?php echo $show['show_name']; ?></div>
					<div class="shows-status"><?php echo $show['status']; ?></div>
					<?php if($show['next_ep_airdate'] == "") $show['next_ep_airdate'] = "unknown"; ?>
					<div class="shows-next">Next episode: <?php echo $show['next_ep_airdate']; ?></div>
				</div>
				<?php if(!$show['paused']) : ?><span class="glyphicon glyphicon-flash icon-tooltip" data-toggle="tooltip" data-placement="top" title="Active"></span><?php endif; ?>
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
	//all_shows
?>

	<div class="text-center">
		<ul class="pagination">
			<?php if(Routing::get_segment(2) == 1) : ?>
			<li class="disabled"><span>&laquo;</span></li>
			<?php else : ?>
			<li><a href="<?php echo Routing::base_url(Routing::get_segment(0) . '/' . Routing::get_segment(1) . '/' . (Routing::get_segment(2) - 1)); ?>">&laquo;</a></li>
			<?php endif; ?>
			
			<?php for($i = 0; $i < $pages; $i++) : ?>
			<li <?php if($i + 1 == Routing::get_segment(2)) echo 'class="active"'; ?>><a href="<?php echo Routing::base_url(Routing::get_segment(0) . '/' . Routing::get_segment(1) . '/' . ($i + 1)); ?>"><?php echo ($i + 1); ?></a></li>
			<?php endfor; ?>
			
			<?php if(Routing::get_segment(2) == $pages) : ?>
			<li class="disabled"><span>&raquo;</span></li>
			<?php else : ?>
			<li><a href="<?php echo Routing::base_url(Routing::get_segment(0) . '/' . Routing::get_segment(1) . '/' . (Routing::get_segment(2) + 1)); ?>">&raquo;</a></li>
			<?php endif; ?>
		</ul>
	</div>

</div>
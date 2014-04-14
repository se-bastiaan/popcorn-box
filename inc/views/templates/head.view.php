<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Popcorn Box - <?php echo $page_title; ?></title>
		<link rel="stylesheet" href="<?php echo Routing::base_url('assets/css/bootstrap.min.css'); ?>" />
		<link rel="stylesheet" href="<?php echo Routing::base_url('assets/css/style.css'); ?>" />
		<script src="<?php echo Routing::base_url('assets/js/jquery.min.js'); ?>"></script>
		<script src="<?php echo Routing::base_url('assets/js/bootstrap.min.js'); ?>"></script>
		<script src="<?php echo Routing::base_url('assets/js/scripts.js'); ?>"></script>
		
		<script type="text/javascript" src="<?php echo Routing::base_url('assets/jwplayer/jwplayer.js'); ?>"></script>
		<script type="text/javascript">jwplayer.key="unlJDQ5ANJ9zw+bfiofiGmvyDFkkwl6L/NBkng==";</script>

		<!--[if lt IE 9]>
	      <script src="<?php echo Routing::base_url('assets/js/html5shiv.js'); ?>"></script>
	    <![endif]-->
	</head>
	<body>
	
		<div id="wrapper">

			<div class="navbar navbar-default navbar-fixed-top" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">Popcorn Box</a>
					</div>
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<?php
								foreach($menu_data as $menu_item) :
									if(isset($menu_item['dropdown'])) :
							?>
								<li class="dropdown">
									<a href="#dropdown" class="dropdown-toggle" data-toggle="dropdown"><?php echo $menu_item['title']; ?> <b class="caret"></b></a>
									<ul class="dropdown-menu">
							<?php
										foreach($menu_item as $sub_item) :
							?>
										<li <?php if($menu_item['active']) echo 'class="active"'; ?>>
											<?php echo Routing::anchor($menu_item['url'], $menu_item['title']); ?>
										</li>
							<?php
										endforeach;
							?>
									</ul>
								</li>
							<?php
									else :
							?>
								<li <?php if($menu_item['active']) echo 'class="active"'; ?>>
									<?php echo Routing::anchor($menu_item['url'], $menu_item['title']); ?>
								</li>
							<?php
									endif;
								endforeach;
							?>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li><?php echo Routing::anchor('settings', 'Settings'); ?></li>
							<li><?php echo Routing::anchor('auth/signout', 'Sign out', 'btn-signout btn btn-info'); ?></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
	
			<div class="body container">
				<?php if(isset($error_message) && $error_message !== null) : ?>
					<div class="alert alert-<?php echo $error_message[0]; ?> alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<strong><?php echo $error_message[1]; ?></strong> <?php echo $error_message[2]; ?>
					</div>
				<?php endif; ?>
				<?php if(isset($tabs) && is_array($tabs) && count($tabs) > 0) : ?>
					<ul class="nav nav-tabs">
						<?php foreach($tabs as $tab) : ?>
						<li <?php if(isset($tab['class'])) echo 'class="' . $tab['class'] . '"'; ?>>
					  		<?php echo Routing::anchor($tab['url'], $tab['title']); ?>
					  	</li>
					  	<?php endforeach; ?>
					</ul>
				<?php endif; ?>
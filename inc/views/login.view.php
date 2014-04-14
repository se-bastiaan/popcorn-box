<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Popcorn Box - Sign in</title>
		<link rel="stylesheet" href="<?php echo Routing::base_url('assets/css/bootstrap.min.css'); ?>" />
		<link rel="stylesheet" href="<?php echo Routing::base_url('assets/css/signin.css'); ?>" />
		<script src="<?php echo Routing::base_url('assets/js/jquery.min.js'); ?>"></script>
		<script src="<?php echo Routing::base_url('assets/js/bootstrap.min.js'); ?>"></script>

		<!--[if lt IE 9]>
	      <script src="<?php echo Routing::base_url('assets/js/html5shiv.js'); ?>"></script>
	    <![endif]-->
	</head>
	<body>

		<div class="container">
		 
			<form class="form-signin" role="form" action="<?php echo Routing::base_url("auth/signin"); ?>" method="POST">
				<h2 class="form-signin-heading">Popcorn Box</h2>
				<input type="hidden" name="keycode" value="<?php echo $crsf; ?>">
				<input type="text" class="form-control" placeholder="Username" name="username" required autofocus>
				<input type="password" class="form-control" placeholder="Password" name="password" required>
				<button class="btn btn-lg btn-info btn-block" type="submit">Sign in</button>
				<?php if(isset($login_error)) : ?>
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<strong>Error!</strong> Authentication failed. Username or password invalid.
					</div>
				<?php endif; ?>
			</form>
		
		</div>
		 
	</body>
</html>
<ul class="nav nav-tabs">
  <?php if(Auth::is_admin()) : ?><li><?php echo Routing::anchor("settings", "General"); ?></li><?php endif; ?>
  <li class="active"><?php echo Routing::anchor("settings/profile", "Profile"); ?></li>
  <?php if(Auth::is_admin()) : ?><li><?php echo Routing::anchor("settings/users", "Users"); ?></li><?php endif; ?>
</ul>

<div class="content">

	<form class="form-horizontal" action="<?php echo Routing::base_url(Routing::get_segment(0) . "/" . Routing::get_segment(1)); ?>" method="post">
		<div class="form-group">
	    	<label class="control-label col-sm-2" for="inputUsername">Username</label>
			<div class="col-sm-10"><input type="text" class="form-control" id="inputUsername" <?php if(isset($username)) : ?>value="<?php echo $username; ?>" readonly=""<?php else : ?>placeholder="Username"<?php endif; ?>></div> 
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="inputPassword">Password</label>
		  <div class="col-sm-10"><input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password" required=""></div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="inputSecondPassword">Password (repeat)</label>
		  <div class="col-sm-10"><input type="password" class="form-control" id="inputSecondPassword" name="password2" placeholder="Password" required=""></div>
		</div>
		<div class="form-group">
		  <div class="col-sm-offset-2 col-sm-10">
		  	<button type="submit" class="btn btn-default">Save</button>    
		  </div>
		</div>
	</form>

</div>
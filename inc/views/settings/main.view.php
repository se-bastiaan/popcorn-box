<ul class="nav nav-tabs">
  <li class="active"><?php echo Routing::anchor("settings", "General"); ?></li>
  <li><?php echo Routing::anchor("settings/profile", "Profile"); ?></li>
  <?php if(Auth::is_admin()) : ?><li><?php echo Routing::anchor("settings/users", "Users"); ?></li><?php endif; ?>
</ul>

<div class="content">

	<form class="form-horizontal" action="<?php echo Routing::base_url("settings"); ?>" method="post">
		<div class="form-group">
	    	No settings yet.
		</div>
		<div class="form-group">
		  <div class="col-sm-offset-2 col-sm-10">
		  	<button type="submit" class="btn btn-default">Save</button>    
		  </div>
		</div>
	</form>

</div>
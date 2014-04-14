<ul class="nav nav-tabs">
  <li><?php echo Routing::anchor("settings", "General"); ?></li>
  <li><?php echo Routing::anchor("settings/profile", "Profile"); ?></li>
  <li class="active"><?php echo Routing::anchor("settings/users", "Users"); ?></li>
</ul>

<div class="content">

	<form class="form-horizontal" action="<?php echo Routing::base_url(Routing::get_segment()); ?>" method="post">
		<div class="form-group">
	    	<label class="control-label col-sm-2" for="inputUsername">Username</label>
			<div class="col-sm-10"><input type="text" class="form-control" id="inputUsername" name="username" <?php if(isset($username)) : ?>value="<?php echo $username; ?>" readonly=""<?php else : ?>placeholder="Username"<?php endif; ?>></div> 
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
		  <label class="control-label col-sm-2" for="inputLevel">Level</label>
		  <div class="col-sm-10">
		  	<select name="level" class="form-control" id="inputLevel" required>
		  		<option value="0" <?php if(isset($level) && $level == 0) echo "selected"; ?>>Administrator</option>
		  		<option value="1" <?php if(isset($level) && $level == 1) echo "selected"; ?>>User</option>
		  	</select>
		  </div>
		</div>
		<div class="form-group">
		  <div class="col-sm-offset-2 col-sm-10">
		  	<button type="submit" class="btn btn-default">Save</button>   
		  	<?php echo Routing::anchor(Routing::get_segment(0) . "/" . Routing::get_segment(1), "Back to the overview", "btn"); ?> 
		  </div>
		</div>
	</form>

</div>
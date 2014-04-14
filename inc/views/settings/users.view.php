<ul class="nav nav-tabs">
  <li><?php echo Routing::anchor("settings", "General"); ?></li>
  <li><?php echo Routing::anchor("settings/profile", "Profile"); ?></li>
  <li class="active"><?php echo Routing::anchor("settings/users", "Users"); ?></li>
  <li class="pull-right user-add"><?php echo Routing::anchor("settings/users/add", "Add user"); ?></li>
</ul>

<div class="content">
	<table class="table table-striped table-settings">
		<thead>
			<tr>
				<th>Username</th>
				<th>Last sign-in</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<?php if(isset($users)) : ?>
		<tbody>
			<?php foreach($users as $k => $user) : ?>
				<tr>
					<td><?php echo $user['username']; ?></td>
					<td><?php echo (is_null($user['last_login']) ? "Never" : $user['last_login']); ?></td>
					<?php if($user['id'] == Session::get_userdata('id')) : ?>
						<td><i class="glyphicon glyphicon-lock"></i></td>
						<td><i class="glyphicon glyphicon-lock"></i></td>
					<?php else : ?>
						<td><?php echo Routing::anchor("settings/users/edit/".$user['id'], '<i class="glyphicon glyphicon-edit"></i>'); ?></td>
						<td><?php echo Routing::anchor("settings/users/delete/".$user['id'], '<i class="glyphicon glyphicon-remove"></i>'); ?></td>
					<?php endif; ?>
				</tr>			
			<?php endforeach; ?>
		</tbody>
		<?php endif; ?>
  	</table>
</div>
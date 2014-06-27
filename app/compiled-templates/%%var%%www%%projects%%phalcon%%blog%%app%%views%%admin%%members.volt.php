<!DOCTYPE HTML>
<head>
	<meta charset="utf-8" />
	<title>Members</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php echo $this->tag->stylesheetLink('css/bootstrap.min.css'); ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<?php echo $this->tag->javascriptInclude('js/bootstrap.min.js'); ?>
</head>

<body>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span>Toggle Nav</span>
				</button>
				<?php echo $this->tag->linkTo(array('index/index', $settings['websiteName'], 'class' => 'navbar-brand')); ?>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><?php echo $this->tag->linkTo(array('index/index', 'Homepage')); ?></li>
					<?php if ($this->session->get('auth') == false) { ?>
						<li><?php echo $this->tag->linkTo(array('user/signup', 'Signup')); ?></li>
						<li><?php echo $this->tag->linkTo(array('user/login', 'Login')); ?></li>
					<?php } else { ?>
						<li><?php echo $this->tag->linkTo(array('user/', $this->session->get('username'))); ?></li>
						<?php if ($this->session->get('role') == 'Admin') { ?>
							<li><?php echo $this->tag->linkTo(array('admin/', 'Admin')); ?></li>
							<li><?php echo $this->tag->linkTo(array('posts/add', 'Create Post')); ?></li>
							<?php } ?>
						<li><?php echo $this->tag->linkTo(array('user/logout', 'Logout')); ?></li>
					<?php } ?>
				</ul>
			</div>
			</div>
		</div>
	</nav>

	<?php echo $this->getContent(); ?>
	<div id="contentContainer">
		<div class="container-fluid">
			

	<?php echo $this->tag->linkTo(array('admin/index', 'Go Back')); ?>

	<table class="table table-striped">
		<tr>
			<th>ID</th>
			<th>E-Mail</th>
			<th>Username</th>
			<th>Role</th>
			<th>Date Created</th>
			<th>Last Active</th>
		</tr>
		
	<?php foreach ($members as $member) { ?>
		<tr>
			<td><?php echo $member->memberId; ?></td>
			<td><?php echo $member->email; ?></td>
			<td><?php echo $member->username; ?></td>
			<td><?php echo $member->role; ?></td>
			<td><?php echo $member->created; ?></td>
			<td><?php echo $member->lastActive; ?></td>
		</tr>
	<?php } ?>

	</table>

		</div>
	</div>
</body>
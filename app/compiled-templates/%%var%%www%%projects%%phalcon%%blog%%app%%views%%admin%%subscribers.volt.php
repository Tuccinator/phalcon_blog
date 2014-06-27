<!DOCTYPE HTML>
<head>
	<meta charset="utf-8" />
	<title>Subscribers</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>

<body>
	<div id="headerContainer">
		<div id="header">
			<h1><?php echo $settings['websiteName']; ?></h1>
			<ul id="navmenu">
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

	<?php echo $this->getContent(); ?>
	<div id="contentContainer">
		<div id="content">
			

	<?php echo $this->tag->linkTo(array('admin/index', 'Go Back')); ?>

	<table>
		<tr>
			<th>ID</th>
			<th>E-Mail</th>
			<th>Date subscribed</th>
			<th>Receive E-Mails?</th>
		</tr>
		
	<?php foreach ($subscribers as $subscriber) { ?>
		<tr>
			<td><?php echo $subscriber->subscriberId; ?></td>
			<td><?php echo $subscriber->email; ?></td>
			<td><?php echo $subscriber->subscribed; ?></td>
			<td><?php echo $subscriber->accept; ?></td>
		</tr>
	<?php } ?>

	</table>

		</div>
	</div>
</body>
a:5:{i:0;s:57:"<!DOCTYPE HTML>
<head>
	<meta charset="utf-8" />
	<title>";s:5:"title";N;i:1;s:1697:"</title>
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
			";s:7:"content";a:1:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:4:"
			";s:4:"file";s:70:"/var/www/projects/phalcon/blog/public/../app/views/templates/base.volt";s:4:"line";i:44;}}i:2;s:25:"
		</div>
	</div>
</body>";}
<!DOCTYPE HTML>
<head>
	<meta charset="utf-8" />
	<title>Edit Post</title>
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
			

	<?php echo $this->tag->linkTo(array('index/index', 'Go Back')); ?>

	<?php echo $this->tag->form(array('posts/save', 'method' => 'post')); ?>

	<?php echo $this->tag->hiddenField(array('id')); ?>

	<div class="form-group">
		<label for="title">Title</label>
		<?php echo $this->tag->textField(array('title', 'class' => 'form-control')); ?>
	</div>

	<div class="form-group">
		<label for="body">Body</label>
		<?php echo $this->tag->textArea(array('body', 'class' => 'form-control')); ?>
	</div>

	<?php echo $this->tag->submitButton(array('Edit', 'class' => 'btn btn-primary')); ?>
	
	<?php echo $this->tag->endform(); ?>

		</div>
	</div>
</body>
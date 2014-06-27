<!DOCTYPE HTML>
<head>
	<meta charset="utf-8" />
	<title>Welcome</title>
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
			
	<?php foreach ($posts as $post) { ?>
		<div class="col-md-6">
			<h1><?php echo $post->title; ?></h1>
			<p><?php echo substr($post->body, 0, 500); ?>&nbsp;<?php echo $this->tag->linkTo(array('posts/view/' . $post->postId, 'Read More')); ?></p>
			<span><?php echo date('Y/m/d', strtotime($post->created)); ?></span>
			<?php if ($this->session->get('auth') != false) { ?>
				<?php if ($post->likeId != null) { ?>
					<div id="unlike<?php echo $post->postId; ?>">
						<button id="<?php echo $post->postId; ?>" class="unlikeBtn btn btn-default">Unlike</button>
					</div>
				<?php } else { ?>
					<div id="like<?php echo $post->postId; ?>">
						<button id="<?php echo $post->postId; ?>" class="likeBtn btn btn-default">Like</button>
					</div>
				<?php } ?>
				<?php if ($this->session->get('role') == 'Admin') { ?>
					<span><?php echo $this->tag->linkTo(array('posts/edit/' . $post->postId, 'Edit')); ?></span>
					<span><?php echo $this->tag->linkTo(array('posts/delete/' . $post->postId, 'Delete')); ?></span>
				<?php } ?>
			<?php } ?>
		</div>
	<?php } ?>
<script>

	$('.likeBtn').click(function() {
		var id = $(this).attr('id');
		var newBtn = $('#like' + id);

		var request = $.ajax({
			url: "<?php echo $this->url->get('posts/like'); ?>",
			type: 'POST',
			data: {'id': id}
		});

		request.done(function(html) {
			if(html != false) {
				$(newBtn).html('<button id="'+ html +'" class="unlikeBtn btn btn-default">Unlike</button>');
				$(newBtn).attr('id', '#unlike' + id);
			}
		});
	});

	$('.unlikeBtn').click(function() {
		var id = $(this).attr('id');
		var newBtn = $('#unlike' + id);

		var request = $.ajax({
			url: "<?php echo $this->url->get('posts/unlike'); ?>",
			type: 'POST',
			data: {'id': id}
		});

		request.done(function(html){
			if(html != false) {
				$(newBtn).html('<button id="'+ html +'" class="likeBtn btn btn-default">Like</button>');
				$(newBtn).attr('id', '#like' + id);
			}
		});
	});
</script>

		</div>
	</div>
</body>
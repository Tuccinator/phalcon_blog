<!DOCTYPE HTML>
<head>
	<meta charset="utf-8" />
	<title><?php echo $post->title; ?></title>
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
	<h1><?php echo $post->title; ?></h1>
	<p><?php echo $post->body; ?></p>
	<span><?php echo $post->created; ?></span>
	<?php if ($post->lastEdited != null) { ?>
		<span><?php echo $post->lastEdited; ?></span>
	<?php } ?>
	<br />

	<?php if ($images) { ?>
		<?php foreach ($images as $image) { ?>
			<?php echo $this->tag->image(array('images/' . $image->postId . '/' . $image->imageId . '.' . $image->extension, 'class' => 'img-responsive')); ?>
		<?php } ?>
	<?php } ?>

	<?php if ($comments) { ?>
		<?php foreach ($comments as $comment) { ?>
			<span><strong><?php echo $comment->member->username; ?></strong></span>
			<div class="comment" id="comment<?php echo $comment->commentId; ?>">
				<p><?php echo $comment->comment; ?></p>
			</div>
			<div id="commentLinks<?php echo $comment->commentId; ?>">
				<?php if ($this->session->get('id') == $comment->memberId) { ?>
					<a href="#" value="<?php echo $comment->commentId; ?>" class="edit-comment">Edit</a>
					<a href="#" value="<?php echo $comment->commentId; ?>" class="delete-comment">Delete</a>
				<?php } ?>
			</div>
		<?php } ?>
	<?php } ?>

	<?php if ($this->session->get('auth') == true) { ?>
		<?php echo $this->tag->form(array('comment/add', 'method' => 'POST')); ?>

		<div class="form-group">
			<label for="comment">Comment</label>
			<?php echo $this->tag->textArea(array('comment', 'class' => 'form-control')); ?>
		</div>

		<input type="hidden" value="<?php echo $post->postId; ?>" id="id" name="id" />
		<?php echo $this->tag->submitButton(array('Comment', 'class' => 'btn btn-primary')); ?>
		<?php echo $this->tag->endform(); ?>
	<?php } ?>

<script>
	$('.edit-comment').click(function() {
		var id = $(this).attr('value');
		var commentDiv = $('#comment' + id);
		var value = $(commentDiv).find('p').text();
		
		$(commentDiv).html('<input type="text" value="' + value + '" class="comment-input" id="' + id + '" autofocus />');

		$('.comment-input').keypress(function(e) {
			if(e.which == 13) {
				var id = $(this).attr('id');
				var commentDiv = $('#comment' + id);
				var value = $(this).val();

				var request = $.ajax({
					url: "<?php echo $this->url->get('comment/edit'); ?>",
					type: 'POST',
					data: {'id': id, 'comment': value}
				});

				request.done(function(html) {
					if(html != false)
						$(commentDiv).html('<p>' + html + '</p>');
				});
			}
		});
		return false;
	});

	$('.delete-comment').click(function() {
		var isGood = confirm('Are you sure you would like to delete comment?');

		if(isGood == true) {
			var id = $(this).attr('value');

			var request = $.ajax({
				url: "<?php echo $this->url->get('comment/delete'); ?>",
				type: 'POST',
				data: {'id': id}
			});

			request.done(function(html) {
				if(html != false) {
					$('#comment' + id).remove();
					$('#commentLinks' + id).remove();
				}
			});
		}
		return false;
	});
</script>


		</div>
	</div>
</body>
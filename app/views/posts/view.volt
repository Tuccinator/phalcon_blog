{% extends 'templates/base.volt' %}

{% block title %}{{ post.title }}{% endblock %}

{% block content %}
	{{ link_to('index/index', 'Go Back') }}
	<h1>{{ post.title }}</h1>
	<p>{{ post.body }}</p>
	<span>{{ post.created }}</span>
	{% if post.lastEdited != null %}
		<span>{{ post.lastEdited }}</span>
	{% endif %}
	<br />

	{% if images %}
		{% for image in images %}
			{{ image('images/'~image.postId~'/'~image.imageId~'.'~image.extension, 'class': 'img-responsive') }}
		{% endfor %}
	{% endif %}

	{% if comments %}
		{% for comment in comments %}
			<span><strong>{{ comment.member.username }}</strong></span>
			<div class="comment" id="comment{{ comment.commentId }}">
				<p>{{ comment.comment }}</p>
			</div>
			<div id="commentLinks{{ comment.commentId }}">
				{% if session.get('id') == comment.memberId %}
					<a href="#" value="{{ comment.commentId }}" class="edit-comment">Edit</a>
					<a href="#" value="{{ comment.commentId }}" class="delete-comment">Delete</a>
				{% endif %}
			</div>
		{% endfor %}
	{% endif %}

	{% if session.get('auth') == true %}
		{{ form('comment/add', 'method': 'POST') }}

		<div class="form-group">
			<label for="comment">Comment</label>
			{{ text_area('comment', 'class': 'form-control') }}
		</div>

		<input type="hidden" value="{{ post.postId }}" id="id" name="id" />
		{{ submit_button('Comment', 'class': 'btn btn-primary') }}
		{{ endform() }}
	{% endif %}

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
					url: "{{ url('comment/edit') }}",
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
				url: "{{ url('comment/delete') }}",
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

{% endblock %}
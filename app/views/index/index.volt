{% extends 'templates/base.volt' %}

{% block title %}Welcome{% endblock %}

{% block content %}
	{% for post in posts %}
		<div class="col-md-6">
			<h1>{{ post.title }}</h1>
			<p>{{ shrink(post.body, 0, 500) }}&nbsp;{{ link_to('posts/view/'~post.postId, 'Read More') }}</p>
			<span><?php echo date('Y/m/d', strtotime($post->created)); ?></span>
			{% if session.get('auth') != false %}
				{% if post.likeId != null %}
					<div id="unlike{{ post.postId }}">
						<button id="{{ post.postId }}" class="unlikeBtn btn btn-default">Unlike</button>
					</div>
				{% else %}
					<div id="like{{ post.postId }}">
						<button id="{{ post.postId }}" class="likeBtn btn btn-default">Like</button>
					</div>
				{% endif %}
				{% if session.get('role') == 'Admin' %}
					<span>{{ link_to('posts/edit/'~post.postId, 'Edit') }}</span>
					<span>{{ link_to('posts/delete/'~post.postId, 'Delete') }}</span>
				{% endif %}
			{% endif %}
		</div>
	{% endfor %}
<script>

	$('.likeBtn').click(function() {
		var id = $(this).attr('id');
		var newBtn = $('#like' + id);

		var request = $.ajax({
			url: "{{ url('posts/like') }}",
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
			url: "{{ url('posts/unlike') }}",
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
{% endblock %}

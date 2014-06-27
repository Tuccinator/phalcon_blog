{% extends 'templates/base.volt' %}

{% block title %}Edit Post{% endblock %}

{% block content %}

	{{ link_to('index/index', 'Go Back') }}

	{{ form('posts/save', 'method' : 'post') }}

	{{ hidden_field('id') }}

	<div class="form-group">
		<label for="title">Title</label>
		{{ text_field('title', 'class': 'form-control') }}
	</div>

	<div class="form-group">
		<label for="body">Body</label>
		{{ text_area('body', 'class': 'form-control') }}
	</div>

	{{ submit_button('Edit', 'class': 'btn btn-primary') }}
	
	{{ endform() }}
{% endblock %}
{% extends 'templates/base.volt' %}

{% block title %}Add Post{% endblock %}

{% block content %}
{{ form('posts/add', 'method':'post', 'enctype': 'multipart/form-data') }}

	<div class="form-group">
		<label for="title">Title</label>
		{{ text_field('title', 'class': 'form-control') }}
	</div>

	<div class="form-group">
		<label for="body">Body</label>
		{{ text_area('body', 'class': 'form-control') }}
	</div>

	<div class="form-group">
		<label for="images">Images (Optional)</label>
		<input type="file" name="images[]" multiple />
	</div>

	{{ submit_button('Add', 'class': 'btn btn-default') }}
{{ endform() }}
{% endblock %}
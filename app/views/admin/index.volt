{% extends 'templates/base.volt' %}

{% block title %}Admin{% endblock %}

{% block content %}
	
	{{ form('admin/index', 'method': 'post') }}

	<div class="form-group">
		<label>Website Name</label>
		{{ text_field('websiteName', 'value': settings['websiteName'], 'class': 'form-control') }}
	</div>
	{{ submit_button('Edit') }}

	{{ link_to('admin/members', 'View Members') }}

{% endblock %}
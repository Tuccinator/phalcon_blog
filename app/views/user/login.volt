{% extends 'templates/base.volt' %}

{% block title %}Login{% endblock %}

{% block content %}
	{{ form('user/login', 'method': 'post') }}

	<div class="form-group">
		<label for="email">E-mail</label>
		{{ text_field('email', 'maxlength': '100', 'class': 'form-control') }}
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		{{ password_field('password', 'class': 'form-control') }}
	</div>
	{{ submit_button('Login', 'class': 'btn btn-default') }}
{% endblock %}
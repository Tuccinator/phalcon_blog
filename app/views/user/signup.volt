{% extends 'templates/base.volt' %}

{% block title %}Sign up{% endblock %}

{% block content %}
	{{ form('user/signup', 'method' : 'post') }}

	<div class="form-group">
		<label for="email">E-mail</label>
		{{ email_field('email', 'maxlength': '100', 'class': 'form-control') }}
	</div>
	<div class="form-group">
		<label for="username">Username</label>
		{{ text_field('username', 'maxlength': '15', 'class': 'form-control') }}
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		{{ password_field('password', 'class': 'form-control') }}
	</div>
	{{ submit_button('Signup', 'class': 'btn btn-default') }}

	{{ endform() }}
{% endblock %}
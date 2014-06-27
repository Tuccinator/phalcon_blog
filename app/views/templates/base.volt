<!DOCTYPE HTML>
<head>
	<meta charset="utf-8" />
	<title>{% block title %}{% endblock %}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	{{ stylesheet_link('css/bootstrap.min.css') }}
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	{{ javascript_include('js/bootstrap.min.js') }}
</head>

<body>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span>Toggle Nav</span>
				</button>
				{{ link_to('index/index', settings['websiteName'], 'class': 'navbar-brand') }}
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li>{{ link_to('index/index', 'Homepage') }}</li>
					{% if session.get('auth') == false %}
						<li>{{ link_to('user/signup', 'Signup') }}</li>
						<li>{{ link_to('user/login', 'Login') }}</li>
					{% else %}
						<li>{{ link_to('user/', session.get('username')) }}</li>
						{% if session.get('role') == 'Admin' %}
							<li>{{ link_to('admin/', 'Admin') }}</li>
							<li>{{ link_to('posts/add', 'Create Post') }}</li>
							{% endif %}
						<li>{{ link_to('user/logout', 'Logout') }}</li>
					{% endif %}
				</ul>
			</div>
			</div>
		</div>
	</nav>

	{{ content() }}
	<div id="contentContainer">
		<div class="container-fluid">
			{% block content %}
			{% endblock %}
		</div>
	</div>
</body>
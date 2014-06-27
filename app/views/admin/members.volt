{% extends 'templates/base.volt' %}

{% block title %}Members{% endblock %}

{% block content %}

	{{ link_to('admin/index', 'Go Back') }}

	<table class="table table-striped">
		<tr>
			<th>ID</th>
			<th>E-Mail</th>
			<th>Username</th>
			<th>Role</th>
			<th>Date Created</th>
			<th>Last Active</th>
		</tr>
		
	{% for member in members %}
		<tr>
			<td>{{ member.memberId }}</td>
			<td>{{ member.email }}</td>
			<td>{{ member.username}}</td>
			<td>{{ member.role }}</td>
			<td>{{ member.created }}</td>
			<td>{{ member.lastActive }}</td>
		</tr>
	{% endfor %}

	</table>
{% endblock %}
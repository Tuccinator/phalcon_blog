<?php

class Members extends Phalcon\Mvc\Model
{

	public $memberId;

	public $email;

	public $username;

	public $password;

	public $role;

	public $created;

	public $lastActive = null;

	public function initialize()
	{
		$this->setSource('blog_members');
	}
}
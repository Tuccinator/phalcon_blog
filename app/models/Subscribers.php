<?php

class Subscribers extends Phalcon\Mvc\Model
{
	public $subscriberId;

	public $email;

	public $subscribed;

	public $accept;

	public function initialize()
	{
		$this->setSource('blog_subscribers');
	}
}
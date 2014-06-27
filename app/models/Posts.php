<?php

class Posts extends Phalcon\Mvc\Model
{

	public $postId;

	public $title;

	public $body;

	public $created;

	public $lastEdited = null;

	public function initialize()
	{
		$this->setSource('blog_posts');
		$this->hasMany('postId', 'Likes', 'postId');
		$this->hasMany('postId', 'Comments', 'postId');
	}

}
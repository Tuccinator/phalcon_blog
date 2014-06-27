<?php

class Likes extends Phalcon\Mvc\Model
{

	public $likeId;

	public $postId;

	public $memberId;

	public function initialize()
	{
		$this->setSource('blog_likes');
		$this->belongsTo('postId', 'Posts', 'postId');
	}
}
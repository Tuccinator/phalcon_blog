<?php

class Images extends Phalcon\Mvc\Model
{

	public $imageId;

	public $postId;

	public $extension;

	public function initialize()
	{
		$this->setSource('blog_images');
		$this->belongsTo('postId', 'Posts', 'postId');
	}
}
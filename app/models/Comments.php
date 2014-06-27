<?php

class Comments extends Phalcon\Mvc\Model
{

	public $commentId;

	public $postId;

	public $memberId;

	public $comment;

	public $created;

	public $lastEdited = null;

	public function initialize()
	{
		$this->setSource('blog_comments');
		$this->hasOne('memberId', 'Members', 'memberId', array('alias' => 'member'));
	}
}
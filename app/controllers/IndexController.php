<?php

class IndexController extends ControllerBase
{
	public function indexAction()
	{
		if($this->session->get('auth')) {
			$userId = $this->session->get('id');
			$phql = "SELECT Posts.title, Posts.body, Posts.postId, Posts.created, Likes.memberId, Likes.likeId FROM Posts LEFT JOIN Likes ON Posts.postId = Likes.postId AND Likes.memberId = :id: ORDER BY Posts.postId DESC";
			$query = $this->modelsManager->createQuery($phql);
			$posts = $query->execute(array('id' => $userId));
		} else {
			$posts = Posts::find(array('order' => 'postId DESC'));
		}

		if(!empty($posts)) {
			$this->view->posts = $posts;
		} else {
			$this->view->posts = 'There are no posts.';
		}
	}
}
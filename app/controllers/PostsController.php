<?php

use Phalcon\Tag as Tag;

class PostsController extends ControllerBase
{
	public function addAction()
	{
		if($this->request->getPost()) {
			$posts = new Posts();
			$posts->title = $this->request->getPost('title');
			$posts->body = $this->request->getPost('body');

			$time = new DateTime();
			$posts->created = $time->format('Y-m-d H:i:s');

			if($posts->save()) {
				if($this->_addImageToPost($posts->postId)) {
					$this->flash->success('Post successfully created.');
					return $this->forward('index/index');
				}
			} else {
				foreach($posts->getMessages() as $message) {
					$this->flash->error($message);
				}
			}

		}
	}

	private function _addImageToPost($postId) {

		if($this->request->hasFiles() == true) {
			mkdir('images/' . $postId, 0777);
			foreach($this->request->getUploadedFiles() as $file) {
				$images = new Images();
				$images->postId = $postId;

				$explodedName = explode('.', $file->getName());
				$extension = end($explodedName);
				$images->extension = $extension;

				if($images->save()) {
					$file->moveTo('images/' . $postId . '/' . $images->imageId . '.' . $extension);
				}
			}
		}

		return true;
		
	}

	public function viewAction($id)
	{
		$id = $this->filter->sanitize($id, array('int'));

		$post = Posts::findFirst(array('postId=:id:', 'bind' => array('id' => $id)));
		$images = Images::find(array('postId=:id:', 'bind' => array('id' => $id)));

		if(!$post) {
			$this->flash->notice('Post does not exist.');
			return;
		} else {
			$this->view->images = $images;
			$this->view->comments = $post->comments;
			$this->view->post = $post;
		}
	}

	public function editAction($id)
	{
		$id = $this->filter->sanitize($id, array('int'));

		$post = Posts::findFirst(array('postId=:id:', 'bind' => array('id' => $id)));
		if(!$post) {
			$this->flash->notice('Post could not be found.');
			return $this->forward('index/index');
		}

		Tag::displayTo('id', $post->postId);
		Tag::displayTo('title', $post->title);
		Tag::displayTo('body', $post->body);
	}

	public function saveAction()
	{
		if(!$this->request->getPost()) {
			return $this->forward('index/index');
		}

		$id = $this->request->getPost('id', 'int');
		$post = Posts::findFirst(array('postId=:id:', 'bind' => array('id' => $id)));
		if(!$post) {
			$this->flash->notice('Post could not be found.');
			return $this->forward('index/index');
		}

		$post->title = $this->request->getPost('title', 'striptags');
		$post->body = $this->request->getPost('body', 'striptags');
		$time = new DateTime();
		$post->lastEdited = $time->format('Y-m-d H:i:s');

		if(!$post->save()) {
			foreach($post->getMessages as $message) {
				$this->flash->error((string) $message);
			}
			return $this->forward('posts/edit/' . $id);
		}

		$this->flash->success('Post successfully changed.');
		return $this->forward('index/index');
	}

	public function deleteAction($id)
	{
		$id = $this->filter->sanitize($id, array('int'));

		$post = Posts::findFirst(array('postId=:id:', 'bind' => array('id' => $id)));
		if(!$post) {
			$this->flash->notice('Post does not exist.');
			return $this->forward('index/index');
		}

		if(!$post->delete()) {
			$this->flash->notice('Post was not deleted.');
			return $this->forward('index/index');
		} else {
			$this->flash->success('Post was successfully deleted.');
			return $this->forward('index/index');
		}
	}

	public function likeAction()
	{

		$request = $this->request;

		if($request->getPost()) {

			$id = $request->getPost('id', 'int');

			$liked = Likes::findFirst(
				array(
					'postId=:id: AND memberId=:uid:',
					'bind' => array(
						'id' => $id,
						'uid' => $this->session->get('id')
					)
				)
			);

			if(!$liked) {
				$like = new Likes();
				$like->likeId = '';
				$like->postId = $id;
				$like->memberId = $this->session->get('id');

				if($like->save()) {
					echo $like->postId;
					return true;
				}
			}
			return false;
		}
	}

	public function unlikeAction()
	{
		$request = $this->request;

		if($request->getPost()) {
			$id = $request->getPost('id', 'int');

			$liked = Likes::findFirst(
				array(
					'postId=:id: AND memberId=:uid:', 
					'bind' => array(
						'id' => $id,
						'uid' => $this->session->get('id')
					)
				)
			);

			if($liked) {
				if($liked->delete()) {
					echo $id;
					return true;
				}
			}

			return false;
		}
	}
}
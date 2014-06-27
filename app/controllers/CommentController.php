<?php

use Phalcon\Tag as Tag;

class CommentController extends ControllerBase
{
	public function addAction()
	{
		$request = $this->request;

		if($request->getPost()) {
			$comment = new Comments();
			$comment->commentId = '';
			$comment->postId = $request->getPost('id', 'int');
			$comment->memberId = $this->session->get('id');
			$comment->comment = $request->getPost('comment', 'striptags');
			$comment->created = new Phalcon\Db\RawValue('now()');

			if(!$comment->save()) {
				$this->flash->error('Comment could not be submitted.');
			} else {
				$this->flashSession->success('Comment successfully posted.');

				Tag::displayTo('comment', '');

				return $this->response->redirect('posts/view/' . $request->getPost('id', 'int'));
			}
		}
	}

	public function deleteAction()
	{
		$request = $this->request;

		if($request->getPost()) {
			$id = $request->getPost('id', 'int');

			$comment = Comments::findFirst(
				array(
					'commentId=:id: AND memberId=:uid:',
					'bind' => array(
						'id' => $id,
						'uid' => $this->session->get('id')
					)
				)
			);

			if($comment) {
				if($comment->delete()) {
					echo true;
					return true;
				}
			}

		}
		return false;
	}

	public function editAction()
	{

		$request = $this->request;

		if($request->getPost()) {
			$id = $request->getPost('id', 'int');
			$newComment = $request->getPost('comment', 'striptags');

			$comment = Comments::findFirst(
				array(
					'commentId=:id: AND memberId=:uid:',
					'bind' => array(
						'id' => $id,
						'uid' => $this->session->get('id')
					)
				)
			);

			if($comment) {
				$comment->comment = $newComment;
				$comment->save();
				echo $newComment;
				return true;
			}
		}

		return true;
	}
}
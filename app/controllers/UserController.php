<?php

class UserController extends ControllerBase
{
	public function signupAction()
	{
		$request = $this->request;

		if($request->getPost()) {
			$user = new Members();

			$user->email = $request->getPost('email', 'email');
			$user->username = $request->getPost('username', 'alphanum');
			$user->password = $this->security->hash($request->getPost('password'));
			$user->role = 'User';
			$user->created = new Phalcon\Db\RawValue('now()');
			$user->lastActive = new Phalcon\Db\RawValue('now()');

			if(!$user->save()) {
				foreach($user->getMessages() as $message) {
					$this->flash->error((string) $message);
				}
			} else {
				$this->flash->success('You have successfully signed up.');
				return $this->dispatcher->forward(
					array(
						'controller' => 'user',
						'action' => 'login'
					)
				);
			}
		}
	}

	public function loginAction()
	{
		$request = $this->request;

		if($request->getPost()) {
			$email = $request->getPost('email', 'email');
			$password = $request->getPost('password');

			$user = Members::findFirst([
				'email=:email:',
				'bind' => [
					'email' => $email
				]
			]);

			if($user) {
				if($this->security->checkHash($password, $user->password)) {
					$this->session->set('auth', true);
					$this->session->set('id', $user->memberId);
					$this->session->set('username', $user->username);
					$this->session->set('role', $user->role);

					$user->lastActive = new Phalcon\Db\RawValue('now()');
					$user->save();

					return $this->response->redirect('index/index');
				}
			}
			$this->flash->error('Wrong email/password.');
		}
	}

	public function logoutAction()
	{
		$this->session->destroy();
		return $this->response->redirect('index/index');
	}
}
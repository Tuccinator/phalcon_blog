<?php

use Phalcon\Events\Event,
	Phalcon\Mvc\User\Plugin,
	Phalcon\Mvc\Dispatcher,
	Phalcon\Acl;

/**
 * Permissions
 *
 * Sets the permissions for all of the pages
 */
class Permissions extends Plugin
{

	public function __construct($di)
	{
		$this->_dependencyInjector = $di;
	}

	public function getAcl()
	{
		if(!isset($this->persistent->acl)) {

			$acl = new Phalcon\Acl\Adapter\Memory();
			$acl->setDefaultAction(Phalcon\Acl::DENY);

			//All roles
			$roles = [
				'admin' => new Phalcon\Acl\Role('Admin'),
				'user' => new Phalcon\Acl\Role('User'),
				'guest' => new Phalcon\Acl\Role('Guest')
			];

			foreach($roles as $role) {
				$acl->addRole($role);
			}

			// Admin roles
			$adminResources = [
				'posts' => ['add', 'edit', 'delete', 'save'],
				'admin' => ['index', 'subscribers', 'members']
			];

			foreach($adminResources as $resource => $actions) {
				$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
			}

			// User roles
			$userResources = [
				'comment' => ['add', 'delete', 'edit'],
				'user' => ['logout'],
				'posts' => ['like', 'unlike']
			];

			foreach($userResources as $resource => $actions) {
				$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
			}

			// Public roles
			$publicResources = [
				'index' => ['index'],
				'posts' => ['view']
			];

			foreach($publicResources as $resource => $actions) {
				$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
			}

			// Guest roles
			$guestResources = [
				'user' => ['signup', 'login']
			];

			foreach($guestResources as $resource => $actions) {
				$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
			}

			//Grant access to everyone
			foreach($roles as $role) {
				foreach($publicResources as $resource => $actions) {
					foreach($actions as $action) {
						$acl->allow($role->getName(), $resource, $action);
					}
				}
			}

			//Grant access to admin
			foreach($adminResources as $resource => $actions) {
				foreach($actions as $action) {
					$acl->allow('Admin', $resource, $action);
				}
			}

			//Grant access to users
			foreach($userResources as $resource => $actions) {
				foreach($actions as $action) {
					$acl->allow('Admin', $resource, $action);
					$acl->allow('User', $resource, $action);
				}
			}		

			//Grant access to guest
			foreach($guestResources as $resource => $actions) {
				foreach($actions as $action) {
					$acl->allow('Admin', $resource, $action);
					$acl->allow('Guest', $resource, $action);
				}
			}

			$this->persistent->acl = $acl;
		}

		return $this->persistent->acl;
	}

	public function beforeDispatch(Event $event, Dispatcher $dispatcher)
	{
		$auth = $this->session->get('role');

		if($auth) {
			if($auth == 'User') {
				$role = 'User';
			} elseif($auth == 'Admin') {
				$role = 'Admin';
			}
		} else {
			$role = 'Guest';
		}

		$controller = $dispatcher->getControllerName();
		$action = $dispatcher->getActionName();

		$acl = $this->getAcl();

		$allowed = $acl->isAllowed($role, $controller, $action);

		if($allowed != Acl::ALLOW) {
			$this->response->redirect('index/index');

			return false;
		}
	}

}
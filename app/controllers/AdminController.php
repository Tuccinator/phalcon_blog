<?php

class AdminController extends ControllerBase
{

	public function indexAction()
	{
		$request = $this->request;

		if($request->getPost()) {
			foreach($request->getPost() as $key => $value) {
				$phql = "UPDATE Settings SET settingValue = :newvalue: WHERE settingName = :setting:";
				$query = $this->modelsManager->createQuery($phql);
				$query->execute(array('newvalue' => $value, 'setting' => $key));
			}
			return $this->response->redirect('admin/index');
		}

	}

	public function membersAction()
	{
		$members = Members::find();

		$this->view->members = $members;
	}
}
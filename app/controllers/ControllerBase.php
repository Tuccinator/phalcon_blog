<?php

class ControllerBase extends Phalcon\Mvc\Controller
{

	protected $settings;

	protected function beforeExecuteRoute($dispatcher)
	{
		$settingsObj = Settings::find();

		$settings = [];

		foreach($settingsObj as $setting) {
			$settings[$setting->settingName] = $setting->settingValue;
		}

		$this->view->settings = $settings;
		$this->settings = $settingsObj;
	}

	protected function forward($route)
	{
		$uri = explode('/', $route);
		return $this->dispatcher->forward(
			array(
			'controller' => $route[0],
			'action' => $route[1]
			)
		);
	}
}
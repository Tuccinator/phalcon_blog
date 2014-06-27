<?php

class Settings extends Phalcon\Mvc\Model
{
	public $settingName;

	public $settingValue;

	public $lastEdited;

	public function initialize()
	{
		$this->setSource('blog_settings');
	}
}
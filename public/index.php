<?php

try {

	/**
	 * Load the configuration file
	 */
	$config = new Phalcon\Config\Adapter\Ini(__DIR__ . '/../app/config/config.ini');

	/**
	 * Create the loader
	 */
	$loader = new Phalcon\Loader();

	/**
	 * Register the directories
	 */
	$loader->registerDirs(array(
		__DIR__ . $config->application->controllersDir,
		__DIR__ . $config->application->pluginsDir,
		__DIR__ . $config->application->modelsDir
	))->register();

	/**
	 * Dependency Injection provided by full-stack framework
	 */
	$di = new Phalcon\DI\FactoryDefault();

	/**
	 * Create the events manager
	 */
	$di->set('dispatcher', function() use($di) {
		$eventsManager = $di->getShared('eventsManager');

		$permissions = new Permissions($di);

		$eventsManager->attach('dispatch', $permissions);

		$dispatcher = new Phalcon\Mvc\Dispatcher();
		$dispatcher->setEventsManager($eventsManager);

		return $dispatcher;
	});

	/**
	 * Set the base URI
	 */
	$di->set('url', function() use($config) {
		$url = new Phalcon\Mvc\Url();
		$url->setBaseUri($config->application->baseUri);

		return $url;
	});

	/**
	 * Setting the views directory
	 */
	$di->set('view', function() use($config) {
		$view = new Phalcon\Mvc\View();
		$view->setViewsDir(__DIR__ . $config->application->viewsDir);

		$view->registerEngines(array(
			'.volt' => 'volt'
		));

		return $view;
	});

	/**
	 * Setting up VOLT
	 */
	$di->set('volt', function($view, $di) {
		$volt = new Phalcon\Mvc\View\Engine\Volt($view, $di);

		$volt->setOptions(array(
			'compiledPath' => '../app/compiled-templates/',
			'compileAlways' => true,
		));

		$volt->getCompiler()->addFunction('shrink', 'substr');

		return $volt;
	});

	/**
	 * Database connection is created based in the parameters defined in the configuration file
	 */
	$di->set('db', function() use ($config) {
		return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
			"host" => $config->database->host,
			"username" => $config->database->username,
			"password" => $config->database->password,
			"dbname" => $config->database->name
		));
	});

	/**
	 * If the configuration specify the use of metadata adapter use it or use memory otherwise
	 */
	$di->set('modelsMetadata', function() use ($config) {
		if (isset($config->models->metadata)) {
			$metaDataConfig = $config->models->metadata;
			$metadataAdapter = 'Phalcon\Mvc\Model\Metadata\\'.$metaDataConfig->adapter;
			return new $metadataAdapter();
		}
		return new Phalcon\Mvc\Model\Metadata\Memory();
	});

	/**
	 * Start the session the first time some component request the session service
	 */
	$di->set('session', function(){
		$session = new Phalcon\Session\Adapter\Files();
		$session->start();
		return $session;
	});

	/**
	 * Register the flash service with custom CSS classes
	 */
	$di->set('flash', function(){
		return new Phalcon\Flash\Direct(array(
			'error' => 'alert alert-error',
			'success' => 'alert alert-success',
			'notice' => 'alert alert-info',
		));
	});

	$application = new \Phalcon\Mvc\Application();
	$application->setDI($di);
	echo $application->handle()->getContent();

} catch (Phalcon\Exception $e) {
	echo $e->getMessage();
} catch (PDOException $e){
	echo $e->getMessage();
}
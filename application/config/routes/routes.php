<?php

if(getenv("APP_MODE") == "PROD" && file_exists(dirname(__DIR__,3).'/var/routes/routes-main')){
	return unserialize(file_get_contents(dirname(__DIR__,3).'/var/routes/routes-main'));
} else {
	$routesCollection = array_map(function ($routesFile){
		return file_get_contents($routesFile).PHP_EOL;
	}, glob(__DIR__."/{*.yaml}", GLOB_BRACE));

	$routes = yaml_parse(implode($routesCollection));

	if (!is_dir(dirname(__DIR__, 3).'/var/routes')) mkdir(dirname(__DIR__, 3).'/var/routes', 0777, true);
	file_put_contents(dirname(__DIR__, 3).'/var/routes/routes-main', serialize($routes));
	return $routes;
}

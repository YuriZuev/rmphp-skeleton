<?php

if(getenv("APP_MODE") == "PROD" && file_exists(dirname(__DIR__,3).'/var/routes/routes')){
	return unserialize(file_get_contents(dirname(__DIR__,3).'/var/routes/routes'));
} else {
	$routesCollection = array_map(function ($routesFile){
		return file_get_contents($routesFile).PHP_EOL;
	}, array_merge(glob(__DIR__."/*/{*.yaml}", GLOB_BRACE), glob(__DIR__."/{*.yaml}", GLOB_BRACE)));

	$routes = yaml_parse(implode($routesCollection));

	if(getenv("APP_MODE") == "PROD") {
		if (!is_dir(dirname(__DIR__, 3).'/var/routes')) mkdir(dirname(__DIR__, 3).'/var/routes', 0777, true);
		file_put_contents(dirname(__DIR__, 3).'/var/routes/routes', serialize($routes));
	}
	return $routes;
}

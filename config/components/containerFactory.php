<?php

use DI\ContainerBuilder;

$containerIni = (getenv("CONTAINER_INI")) ?: "config/container.php";
$containerCache = (getenv("CONTAINER_CACHE")) ?: "var/cache/container";

$dependencies = require dirname(__DIR__,2).'/'.$containerIni;

$dependenciesCollection = array_map(function ($dependenciesFile){
	return require dirname(__DIR__,2)."/".$dependenciesFile;
}, $dependencies);

try {
	$builder = new ContainerBuilder();
	if(getenv("APP_MODE") == "PROD") $builder->enableCompilation(dirname(__DIR__,2)."/".$containerCache);
	$builder->addDefinitions(array_replace_recursive(...$dependenciesCollection));
	return $builder->build();
} catch (Exception $e) {echo $e->getMessage();}

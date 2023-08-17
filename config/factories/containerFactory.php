<?php

use DI\ContainerBuilder;

$containerDir = (getenv("CONTAINER_DIR"))?:"config/container";
$containerCache = (getenv("CONTAINER_CACHE"))?:"var/cache/container";

$dependencies = glob(dirname(__DIR__,2)."/".$containerDir."/*.php");
$dependenciesCollection = array_map(function ($dependenciesFile){
	return require $dependenciesFile;
}, $dependencies);

try {
	$builder = new ContainerBuilder();
	if(getenv("APP_MODE") != "DEV") $builder->enableCompilation(dirname(__DIR__,2)."/".$containerCache);
	$builder->addDefinitions(array_replace_recursive(...$dependenciesCollection));
	return $builder->build();
} catch (Exception $e) {echo $e->getMessage();}

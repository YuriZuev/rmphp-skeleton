<?php

use DI\ContainerBuilder;

$containerDir = (getenv("CONTAINER_DIR"))?:"config/container/";

$dependencies = glob(dirname(__DIR__,2)."/".$containerDir."/*.php");

$dependenciesCollection = array_map(function ($dependenciesFile){
	return require $dependenciesFile;
}, $dependencies);

try {
	$builder = new ContainerBuilder();
	$builder->enableCompilation(__DIR__ . '/../../var/cache/container');
	$builder->addDefinitions(array_replace_recursive(...$dependenciesCollection));
	return $builder->build();
} catch (Exception $e) {echo $e->getMessage();}

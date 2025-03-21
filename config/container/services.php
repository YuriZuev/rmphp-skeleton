<?php

use Rmphp\Storage\Mysql\MysqlStorage;
use Rmphp\Storage\Mysql\MysqlStorageInterface;

return [
	MysqlStorageInterface::class => DI\create(MysqlStorage::class)->constructor(json_decode(getenv("MYSQL_PARAM"))),
	'App\Domain\Repository\*RepositoryInterface' => DI\autowire('App\Infrastructure\Repository\*Repository'),
	'App\*\Domain\Repository\*RepositoryInterface' => DI\autowire('App\*\Infrastructure\Repository\*Repository'),
];

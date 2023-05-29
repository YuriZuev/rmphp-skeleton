<?php

use Rmphp\Storage\MysqlStorage;
use Rmphp\Storage\MysqlStorageInterface;

return [
	MysqlStorageInterface::class => DI\create(MysqlStorage::class)->constructor(json_decode(getenv("MYSQL_PARAM"), true)),
	'App\*\Domain\Repository\*RepositoryInterface' => DI\autowire('App\*\Repository\Mysql\*Repository'),
	'App\*\Services\*\*Service' => DI\autowire('App\*\Services\*\*Service'),
	'App\*\Services\*Service' => DI\autowire('App\*\Services\*Service'),
];
<?php

declare(strict_types = 1);

use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Rmphp\Kernel\App;
use Rmphp\Kernel\ResponseEmitter;

require_once dirname(__DIR__).'/vendor/autoload.php';

(new Symfony\Component\Dotenv\Dotenv())->usePutenv()->loadEnv(dirname(__DIR__).'/.env');

if(getenv("APP_MODE") == 'DEBUG'){
	error_reporting(E_ALL); ini_set('display_errors','On');
} else {
	error_reporting(0); ini_set('display_errors','Off');
}

$request = ServerRequestFactory::fromGlobals();

$app = new App();
$response = $app->handler($request, new Response());
(new ResponseEmitter())->emit($response);

if(($response->getStatusCode() !== 200 && getenv("APP_MODE") == 'DEV') || in_array("Dev", $response->getHeader("App-Mode"))){
	$app->syslogger()->dump("Response", $response);
	addShutdownInfo($app->syslogger()->getLogs());
}

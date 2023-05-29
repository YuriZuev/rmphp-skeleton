<?php

declare(strict_types = 1);

use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Rmphp\Kernel\App;
use Rmphp\Kernel\ResponseEmitter;
use Rmphp\Kernel\Utils;

require_once dirname(__DIR__).'/vendor/autoload.php';

(new Symfony\Component\Dotenv\Dotenv())->usePutenv()->loadEnv(dirname(__DIR__).'/.env');

error_reporting(0); ini_set('display_errors','Off');
if(getenv("APP_MODE") == 'DEV'){
	error_reporting(E_ALL); ini_set('display_errors','On');
}

$request = ServerRequestFactory::fromGlobals();

$app = new App();
$response = $app->handler($request, (new Response())->withHeader("Content-Type", "text/html; charset=utf-8"));
(new ResponseEmitter())->emit($response);


if(getenv("APP_MODE") == 'DEV' && in_array("Dev", $response->getHeader("App-Mode"))){
	$app->syslogger()->dump("request", $request);
	$app->syslogger()->dump("response", $response);
	$app->syslogger()->dump("globals", [
		"ENV"=>$_ENV,
		"GET"=>$request->getQueryParams(),
		"POST"=>$request->getParsedBody(),
		"COOKIE"=>$request->getCookieParams(),
		"SESSION"=>$_SESSION ?? [],
		"SERVER"=>$request->getServerParams()
	]);
	$app->syslogger()->dump("kernel", $app);
	Utils::addShutdownInfo($app->syslogger()->getLogs());
}

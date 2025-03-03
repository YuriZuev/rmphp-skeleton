<?php

use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Rmphp\Kernel\AppCli;
use Rmphp\Kernel\ResponseEmitter;

require_once dirname(__DIR__,2).'/vendor/autoload.php';
(new Symfony\Component\Dotenv\Dotenv())->usePutenv()->loadEnv(dirname(__DIR__,2).'/.env');

$app = new AppCli();
$response = $app->handler(ServerRequestFactory::fromGlobals(), new Response());
(new ResponseEmitter())->emit($response);

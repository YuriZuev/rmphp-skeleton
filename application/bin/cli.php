<?php

use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;use Rmphp\Kernel\ResponseEmitter;

require_once dirname(__DIR__,2).'/vendor/autoload.php';
(new Symfony\Component\Dotenv\Dotenv())->usePutenv()->loadEnv(dirname(__DIR__,2).'/.env');

/** @var LoggerInterface $logger */
$logger = require_once dirname(__DIR__,2).'/application/config/components/loggerFactory.php';
/** @var Container $container */
$container = require_once dirname(__DIR__,2).'/application/config/components/containerFactory.php';
$container->set(LoggerInterface::class, $logger);

if(str_contains($argv[1], ':')) {
	list($className, $method) = explode(':', $argv[1]);
	if(class_exists($className)) {
		try {
			$controllers = $container->get($className);
			if(method_exists($controllers, $method)) {
				$response = $controllers->$method();
			}
			if(isset($response)) {
				if($response instanceof ResponseInterface) (new ResponseEmitter())->emit($response);
				elseif(!is_bool($response)) echo $response;
			}
		} catch(Throwable $throwable){
			$logger->error($throwable->getMessage()." on ".$throwable->getFile().":".$throwable->getLine());
		}
	}
	else echo "Class $className does not exist";
}

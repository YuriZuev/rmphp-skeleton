<?php

namespace App\Common\Controllers;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Rmphp\Kernel\Main;

abstract class AbstractController extends Main {

	/**
	 * @param \Throwable $throwable
	 * @param array $data
	 * @return void
	 */
	public function logException(\Throwable $throwable, array $data = []) : void {
		$this->logger()->warning($throwable->getMessage()." on ".$throwable->getFile().":".$throwable->getLine(), $data);
	}


	/**
	 * @param string $name
	 * @param string $value
	 * @return void
	 */
	public function addHeader(string $name, string $value) : void {
		$this->globals()->addHeader($name, $value);
	}

	/**
	 * @param $html
	 * @param int $status
	 * @param array $headers
	 * @return ResponseInterface
	 */
	public function htmlResponse($html, int $status = 200, array $headers = []) : ResponseInterface {
		return new HtmlResponse($html, $status, array_merge($this->globals()->response()->getHeaders(), $headers));
	}

	/**
	 * @param $text
	 * @param int $status
	 * @param array $headers
	 * @return ResponseInterface
	 */
	public function textResponse($text, int $status = 200, array $headers = []) : ResponseInterface {
		$this->container()->set("showDebugLogs", false);
		return new TextResponse($text, $status, array_merge($this->globals()->response()->getHeaders(), $headers));
	}

	/**
	 * @param array $array
	 * @param int $status
	 * @param array $headers
	 * @return ResponseInterface
	 */
	public function jsonResponse(array $array, int $status = 200, array $headers = []) : ResponseInterface {
		$this->container()->set("showDebugLogs", false);
		return new JsonResponse($array, $status, array_merge($this->globals()->response()->getHeaders(), $headers), JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
	}

	/**
	 * @param string $url
	 * @param int $status
	 * @param array $headers
	 * @return ResponseInterface
	 */
	public function redirectResponse(string $url, int $status = 302, array $headers = []) : ResponseInterface {
		$this->container()->set("showDebugLogs", false);
		return new RedirectResponse($url, $status, array_merge($this->globals()->response()->getHeaders(), $headers));
	}

}
<?php

namespace App\Common\Controllers;

abstract class AbstractPageController extends AbstractController {

	/**
	 * @param string $point
	 * @param string $string
	 */
	public function templateAddValue(string $point, string $string) : void {
		$this->template()->addValue($point, $string);
	}

	/**
	 * @param string $point
	 * @param string $subTempl
	 * @param array $resource
	 */
	public function templateSetSubtemple(string $point, string $subTempl, array $resource = []) : void {
		$this->template()->setSubtemple($point, $subTempl, $resource);
	}

	/**
	 * @param \Exception $exception
	 * @param array $data
	 * @return void
	 */
	public function exceptionPage(\Exception $exception, array $data = []) : void {
		$this->logException($exception, $data);
		$this->syslogger()->warning($exception->getMessage()." on ".$exception->getFile().":".$exception->getLine(), $data);
		$this->templateSetSubtemple("main", "/main/errpage.tpl", [
			"errorText" => "<span style='color:red'>Error: ".$exception->getMessage()." (".$exception->getCode().")"."</span>"
		]);
	}
}
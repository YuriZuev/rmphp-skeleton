<?php

namespace Base\Controllers;

use Base\Domain\DomainException;
use Base\Services\DTOException;
use Base\Services\ServiceException;
use Exception;
use Throwable;

abstract class AbstractPageController extends AbstractController {

	/**
	 * @param Exception $exception
	 * @param array $data
	 * @return void
	 */
	public function exceptionPage(Exception $exception, array $data = []) : void {
		$this->logException($exception, $data);
		$this->syslogger()->warning($exception->getMessage()." on ".$exception->getFile().":".$exception->getLine(), $data);
		$this->template()->setSubtemplate("main", "/templates/error/errpage.tpl", [
			"errorText" => "<span style='color:red'>Error: ".$exception->getMessage()." (".$exception->getCode().")"."</span>"
		]);
	}

	/**
	 * @param Throwable $e
	 * @return string
	 */
	public function checkError(Throwable $e) : string {
		($e instanceof Exception) ? $this->logException($e) : $this->logError($e);
		if($e instanceof DTOException || $e instanceof DomainException || $e instanceof ServiceException) return $e->getMessage();
		return "Ошибка.  Дата и время: ".date("d-m-Y H:i:s");
	}
}
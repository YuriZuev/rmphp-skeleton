<?php

namespace Base\Controllers;

use Base\Application\ApplicationException;
use Base\Domain\DomainException;
use Exception;
use Throwable;

abstract class AbstractPageController extends AbstractController {

	/**
	 * @param Throwable $e
	 * @return string
	 */
	public function checkError(Throwable $e) : string {
		($e instanceof Exception) ? $this->logException($e) : $this->logError($e);
		if($e instanceof DomainException || $e instanceof ApplicationException) return $e->getMessage();
		return "Ошибка.  Дата и время: ".date("d-m-Y H:i:s");
	}
}

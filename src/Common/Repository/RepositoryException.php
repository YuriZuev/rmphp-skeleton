<?php

namespace App\Common\Repository;

use Throwable;

class RepositoryException extends \Exception {

	public array $data;

	public function __construct($message="", $code=0, array $data = [], Throwable $previous=null) {
		parent::__construct($message, $code, $previous);
		$this->data = $data;
	}
}
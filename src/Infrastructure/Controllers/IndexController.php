<?php

namespace App\Infrastructure\Controllers;
use Base\Infrastructure\Controllers\AbstractPageController;
use Psr\Http\Message\ResponseInterface;

class IndexController extends AbstractPageController {

	/**
	 * @return bool|ResponseInterface
	 */
	public function index() : bool|ResponseInterface {
		try {
			//$this->addHeader("App-Mode", "Dev");
			$this->template()->setValue("title", "Главная");
		}
		catch(\Throwable $e){$error = $this->checkError($e);}

		return $this->renderResponse("main", "@main/index.tpl", [
			"date" => (new \DateTime())->format('Y-m-d H:i:s'),
			"error" => $error ?? null
		]);
	}
}

<?php

namespace App\Main\Controllers;
use App\Common\Controllers\AbstractController;
use App\Common\Services\ServiceException;
use Psr\Http\Message\ResponseInterface;


class IndexController extends AbstractController {

	/**
	 * @return bool|ResponseInterface
	 */
	public function index() : bool|ResponseInterface {
		try {
			$this->addHeader("App-Mode", "Dev");
			$this->template()->setValue("title", "Главная");
			$this->template()->setSubtemple("main", "main/index.tpl", [
			]);
		}
		catch(ServiceException $exception){}
		return true;
	}

}
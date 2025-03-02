<?php
/**
 * Created by PhpStorm.
 * User: Zuev Yuri
 * Date: 02.03.2025
 * Time: 22:02
 */

namespace App\Infrastructure\Handlers;

use Base\Controllers\AbstractHandler;
use Psr\Http\Message\ResponseInterface;

class IndexHandler extends AbstractHandler {

	public function index() : bool|ResponseInterface {

		return $this->textResponse((new \DateTime())->format('Y-m-d H:i:s'));

	}

}

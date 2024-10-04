<?php
/**
 * Created by PhpStorm.
 * User: Zuev Yuri
 * Date: 23.04.2024
 * Time: 3:58
 */

namespace App\Infrastructure\Base\Domain;

interface EntityInterface {

	/**
	 * @return int|null
	 */
	public function getId(): mixed;

}

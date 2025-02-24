<?php

namespace Base\Application;

use Exception;
use ReflectionClass;
use Rmphp\Storage\Component\AbstractDataObject;

abstract class AbstractDTO extends AbstractDataObject {

	/**
	 * @param array|object ...$data
	 * @return static
	 * @throws Exception
	 */
	public static function fromData(array|object ...$data) : static {
		$array = array_map(function($item) {
			return (is_object($item)) ? get_object_vars($item) : $item;
		}, $data);
		return self::fromArray(array_merge(...$array));
	}

	/**
	 * @param object $data
	 * @return static
	 * @throws Exception
	 */
	public static function fromObject(object $data) : static {
		return self::fromArray(get_object_vars($data));
	}


	/**
	 * @param array $data
	 * @return static
	 * @throws Exception
	 */
	public static function fromArray(array $data) : static {
		return self::fillObject(new ReflectionClass(static::class), new static(), $data);
	}
}

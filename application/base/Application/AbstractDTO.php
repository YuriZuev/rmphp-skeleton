<?php

namespace Base\Application;

use ReflectionClass;

abstract class AbstractDTO {

	/**
	 * @param object $data
	 * @return static
	 */
	static function fromObject(object $data) : static {
		return static::fromArray(get_object_vars($data));
	}


	/**
	 * @param array|object ...$data
	 * @return static
	 */
	static function fromData(array|object ...$data) : static {
		$array = array_map(function($item) {
			return (is_object($item)) ? get_object_vars($item) : $item;
		}, $data);
		return static::fromArray(array_merge(...$array));
	}


	/**
	 * @param array $data
	 * @return static
	 */
	static function fromArray(array $data) : static {
		$class = new ReflectionClass(static::class);
		$self = new static();
		foreach ($class->getProperties() as $property) {
			$propertyNameSnakeCase = strtolower(preg_replace("'([A-Z])'", "_$1", $property->getName()));
			// data[propertyName] ?? data[property_name] ?? null
			$value = $data[$property->getName()] ?? $data[$propertyNameSnakeCase] ?? null;
			// если есть внутренний метод (приоритетная обработка)
			if($class->hasMethod('set'.ucfirst($property->getName()))) $self->{'set'.ucfirst($property->getName())}($value);
			// прямое присовение по умолчанию
			elseif(isset($value)) $self->{$property->getName()} = $value;
		}
		return $self;
	}

}

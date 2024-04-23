<?php

namespace Base\Services;

use Exception;
use ReflectionClass;

abstract class AbstractDTO {

	/**
	 * @throws Exception
	 */
	static function fromArray(array $data) : static {
		$class = new ReflectionClass(static::class);
		$self = new static();
		foreach ($class->getProperties() as $property) {
			try {
				$propertyNameSnakeCase = strtolower(preg_replace("'([A-Z])'", "_$1", $property->getName()));
				// data[propertyName] ?? data[property_name] ?? null
				$value = $data[$property->getName()] ?? $data[$propertyNameSnakeCase] ?? null;
				// если есть внутренний метод (приоритетная обработка)
				if($class->hasMethod('set'.ucfirst($property->getName()))) $self->{'set'.ucfirst($property->getName())}($value);
				// прямое присовение по умолчанию
				elseif(isset($value)) $self->{$property->getName()} = $value;
			}
			catch (\Error $error) {
				$errorKey[$property->getName()] = $error->getMessage();
			}
			if(!empty($errorKey)) throw new Exception(json_encode(["data"=>$data, "error"=>$errorKey]));
		}
		return $self;
	}
}
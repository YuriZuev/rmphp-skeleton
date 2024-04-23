<?php
/**
 * Created by PhpStorm.
 * User: Zuev Yuri
 */

namespace Base\Domain;

use ReflectionClass;

abstract class AbstractObject {

	/**
	 * @param array $data
	 * @return static
	 * @throws DomainException
	 */
	public static function fromData(array $data) : static {
		$self = new static();
		$self->setProperties($data);
		return $self;
	}

	/**
	 * @param array $data
	 * @return void
	 * @throws DomainException
	 */
	public function setProperties(array $data) : void {
		$class = new ReflectionClass(static::class);
		foreach ($class->getProperties() as $property) {
			$propertyNameSnakeCase = strtolower(preg_replace("'([A-Z])'", "_$1", $property->getName()));
			// data[propertyName] ?? data[property_name] ?? null
			$value = $data[$property->getName()] ?? $data[$propertyNameSnakeCase] ?? null;

			// если есть внутренний метод (приоритетная обработка)
			if($class->hasMethod('set'.ucfirst($property->getName()))) $this->{'set'.ucfirst($property->getName())}($value);
			// Если тип свойства класс (valueObject)
			elseif($property->hasType() && class_exists($property->getType()->getName())) $this->{$property->getName()} = new ($property->getType()->getName())($value);
			// если значения не пустое
			elseif(isset($value)) $this->{$property->getName()} = $value;
		}
	}

	/**
	 * @param callable|null $method
	 * @return array
	 */
	public function getProperties(callable $method = null) : array {
		$objectData = get_object_vars($this);
		foreach ($objectData as $fieldName => $value)
		{
			// to option_id
			$fieldNameSnakeCase = strtolower(preg_replace("'([A-Z])'", "_$1", $fieldName));

			// если есть внутренний метод (приоритетная обработка)
			if(method_exists($this, 'get'.ucfirst($fieldName))) {
				$out[$fieldNameSnakeCase] = $this->{'get'.ucfirst($fieldName)}($value);
			}
			// если тип свойства класс (valueObject)
			elseif($value instanceof ValueObjectInterface && null !== $value->get()) {
				$out[$fieldNameSnakeCase] = $value->get();
			}
			// если передана callable функция через которую нужно пропустить все элементы
			elseif(isset($method) && !is_array($value) && !is_object($value)) {
				$out[$fieldNameSnakeCase] = $method($value);
			}
			// если это логическое значение
			elseif(is_bool($value)){
				$out[$fieldNameSnakeCase] = (int) $value;
			}
			// если это дробное число
			elseif(is_float($value)) {
				$out[$fieldNameSnakeCase] = $value;
			}
			// если это целое число
			elseif(is_int($value)) {
				$out[$fieldNameSnakeCase] = $value;
			}
			// если это строка
			elseif(is_string($value)) {
				$out[$fieldNameSnakeCase] = $value;
			}

		}
		return $out ?? [];
	}
}
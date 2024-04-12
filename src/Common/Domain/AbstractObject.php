<?php
/**
 * Created by PhpStorm.
 * User: Zuev Yuri
 */

namespace App\Common\Domain;

abstract class AbstractObject {

	/**
	 * @param array $data
	 * @return static
	 */
	public static function fromData(array $data) : static {
		$self = new static();
		$self->setProperties($data);
		return $self;
	}

	/**
	 * @param array $data
	 * @return $this
	 */
	public function setProperties(array $data) : self {
		$propArray = array_keys(get_class_vars(get_class($this)));
		foreach ($propArray as $propName)
		{
			$propNameSnakeCase = strtolower(preg_replace("'([A-Z])'", "_$1", $propName));

			// если в переданном массиве ключ и свойство совпадают optionId = optionId
			if(isset($data[$propName])) {
				$this->{$propName} = (method_exists($this, 'set'.ucfirst($propName))) ? $this->{'set'.ucfirst($propName)}($data[$propName]) : $data[$propName];
			}
			// если свойство в снэйккесе совподает с ключем в массиве option_id = optionId
			elseif(isset($data[$propNameSnakeCase])) {
				$this->{$propName} = (method_exists($this, 'set'.ucfirst($propName))) ? $this->{'set'.ucfirst($propName)}($data[$propNameSnakeCase]) : $data[$propNameSnakeCase];
			}
		}
		return $this;
	}

	/**
	 * @param callable|null $method
	 * @return array
	 */
	public function getProperties(callable $method = null) : array {
		$objectData = get_object_vars($this);
		foreach ($objectData as $fieldName => $value)
		{
			$fieldNameSnakeCase = strtolower(preg_replace("'([A-Z])'", "_$1", $fieldName));

			// если есть внутренний метод
			if(method_exists($this, 'get'.ucfirst($fieldName))) {
				$out[$fieldNameSnakeCase] = $this->{'get'.ucfirst($fieldName)}($value);
			}
			// если есть callable функция
			elseif(isset($method) && !is_array($value)) {
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
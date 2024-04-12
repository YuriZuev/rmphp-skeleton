<?php

namespace App\Common\Services;

use Exception;

abstract class AbstractDTO {

	/**
	 * @param array $data
	 * @return static
	 * @throws Exception
	 */
	static function fromArray(array $data) : static {
		$self = new static();

		$propArray = array_keys(get_class_vars(get_class($self)));

		foreach($propArray as $propName){
			$propNameSnakeCase = strtolower(preg_replace("'([A-Z])'", "_$1", $propName));
			if(method_exists($self, "requireAssert".ucfirst($propName))){
				if(isset($data[$propName])) {
					$self->{"requireAssert".ucfirst($propName)}($data[$propName]);
				}
				elseif(isset($data[$propNameSnakeCase])) {
					$self->{"requireAssert".ucfirst($propName)}($data[$propNameSnakeCase]);
				}
				else{
					throw new DTOException("Отсутствует обязательное значение");
				}
			}
		}
		foreach($data as $key => $item){
			try {
				$camelCaseKey = str_replace('_', '', ucwords($key, "_"));
				if(method_exists($self, "assert".$camelCaseKey)) {
					$self->{'assert'.$camelCaseKey}($item);
				} elseif(in_array(lcfirst($camelCaseKey), $propArray)) {
					$self->{lcfirst($camelCaseKey)} = $item;
				}
			}
			catch (\Error $error) {
				$errorKey[$key] = $error->getMessage();
			}
			if(!empty($errorKey)) throw new Exception(json_encode(["data"=>$data, "error"=>$errorKey]));
		}
		return $self;
	}

	/**
	 * @param $value
	 * @return bool
	 */
	public function validateInt($value) : bool {
		return (is_numeric($value));
	}

	/**
	 * @param $value
	 * @return bool
	 */
	public function validateFloat($value) : bool {
		return (is_float((float) $value));
	}

	/**
	 * @param $value
	 * @return bool
	 */
	public function validateBoolean($value) : bool {
		return (is_bool($value));
	}

	/**
	 * @param $value
	 * @return bool
	 */
	public function validateEmail($value) : bool {
		return (filter_var($value, FILTER_VALIDATE_EMAIL));
	}
}
<?php

namespace Base\Repository;

use Base\Domain\AbstractObject;
use Rmphp\Storage\Mysql\MysqlStorageInterface;

abstract class AbstractMysqlRepository {

	public function __construct(
		public readonly MysqlStorageInterface $mysql
	) {}

	/**
	 * @throws RepositoryException
	 */
	public function saveEntity(AbstractObject $object, string $table) : AbstractObject {
		$in = $object->getProperties(function ($value){
			return (is_string($value)) ? $this->mysql->escapeStr($value) : $value;
		});
		try {
			if (!empty($object->id) && !empty($this->mysql->findById($table, $object->id))) {
				$this->mysql->updateById($table, $in, $object->id);
			} else {
				$this->mysql->insert($table, $in);
				$object->id = $this->mysql->mysql()->insert_id;
			}
		} catch (\Throwable $throwable) {throw new RepositoryException($throwable->getMessage());}
		return $object;
	}




}
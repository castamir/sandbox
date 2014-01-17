<?php

namespace Model;

use DibiFluent;
use LeanMapper\Connection;
use LeanMapper\Entity;
use LeanMapper\Exception\InvalidArgumentException;
use LeanMapper\Fluent;
use LeanMapper\IMapper;
use LeanMapper\Repository as LR;

/**
 * @property array $onBeforePersist
 * @property array $onBeforeCreate
 * @property array $onBeforeUpdate
 * @property array $onBeforeDelete
 * @property array $onAfterPersist
 * @property array $onAfterCreate
 * @property array $onAfterUpdate
 * @property array $onAfterDelete
 */
abstract class Repository extends LR
{

	/**
	 * @param Connection $connection
	 * @param IMapper $mapper
	 */
	public function __construct(Connection $connection, IMapper $mapper)
	{
		parent::__construct($connection, $mapper);
//		$this->initFilters();
	}

	/**
	 * @return Query
	 */
	public function createQueryObject()
	{
		return (new Query($this->connection))->select('*')
			->from($this->getTable());
	}

	/**
	 * @param Query $query
	 * @return \DibiResult|int
	 */
	private function prepare(Query $query)
	{
		return $this->connection->query($this->translate($query));
	}

	/**
	 * @param Query $query
	 * @return string
	 */
	private function translate(Query $query)
	{
		$translated = $this->connection->translate($query->_export());

		/** @var Entity $entityClass */
		$entityClass = $this->mapper->getEntityClass($this->getTable());
		$reflection = $entityClass::getReflection($this->mapper);
		foreach ($reflection->getEntityProperties() as $property) {
			$name = $property->getName();
			$column = $property->getColumn();
			$translated = preg_replace("/`$name`/", "`$column`", $translated);
		}

		return $translated;
	}

	/**
	 * @param Query|array $query
	 * @throws \Model\NotFoundException
	 * @throws \LeanMapper\Exception\InvalidArgumentException
	 * @return array|mixed
	 */
	public function findBy($query)
	{
		if (is_array($query)) {
			/** @var Query $query */
			$query = $this->createQueryObject()->where($query);
		} elseif (!$query instanceof DibiFluent) {
			throw new InvalidArgumentException;
		}

		$limit = $query->_export('limit');
		if (is_array($limit) && $limit[1] === 1) {
			$row = $this->prepare($query)->fetch();
			if ($row === FALSE) {
				throw new NotFoundException('Entity not found.');
			}
			return $this->createEntity($row);
		}

		return $this->createEntities($this->prepare($query)->fetchAll());
	}

	/**
	 * @param null $limit
	 * @param null $offset
	 * @return array
	 */
	public function findAll($limit = NULL, $offset = NULL)
	{
		$query = $this->createQueryObject();
		if ($limit) {
			$query->removeClause("limit");
			$query->limit($limit);
		}
		if ($offset) {
			$query->removeClause("offset");
			$query->offset($offset);
		}
		return $this->findBy($query);
	}

	/**
	 * @param Query|array $query
	 * @throws \LeanMapper\Exception\InvalidArgumentException
	 * @return array|mixed
	 */
	public function findOneBy($query)
	{
		if (is_array($query)) {
			$query = $this->createQueryObject()->where($query);
		} elseif (!$query instanceof DibiFluent) {
			throw new InvalidArgumentException;
		}
		$query->removeClause("limit");
		$query->limit(1);
		return $this->findBy($query);
	}

	/**
	 * @param $id
	 * @throws NotFoundException
	 * @return BaseEntity
	 */
	public function get($id)
	{
		$query = $this->createQueryObject();
		$query->where("id = %s", $id);
		return $this->findOneBy($query);
	}

	protected function initFilters()
	{
		$this->connection->registerFilter('depth', array((new ClosureFilter), 'depth'));
	}

}

class ClosureFilter
{
	const DEFAULT_DEPTH = 1;

	public function depth(Fluent $statement, $depth = NULL)
	{
		if ($depth === NULL) {
			$depth = self::DEFAULT_DEPTH;
		}
		$statement->where('[depth] = %s', $depth);
	}
}

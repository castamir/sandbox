<?php


namespace Model;

use LeanMapper\Fluent;

/**
 * @method \Model\Query select($field)
 * @method \Model\Query distinct()
 * @method \Model\Query from($table)
 * @method \Model\Query join($table)
 * @method \Model\Query on($table)
 * @method \Model\Query where($cond)
 * @method \Model\Query groupBy($field)
 * @method \Model\Query having($cond)
 * @method \Model\Query orderBy($field)
 * @method \Model\Query limit(int $limit)
 * @method \Model\Query offset(int $offset)
 */
class Query extends Fluent
{
	public function execute($return = NULL)
	{
		throw new InvalidStateException ("This method is not allowed in a separated query object");
	}

	public function fetch()
	{
		throw new InvalidStateException ("This method is not allowed in a separated query object");
	}

	public function fetchAll($offset = NULL, $limit = NULL)
	{
		throw new InvalidStateException ("This method is not allowed in a separated query object");
	}

	public function fetchSingle()
	{
		throw new InvalidStateException ("This method is not allowed in a separated query object");
	}

	public function fetchAssoc($assoc)
	{
		throw new InvalidStateException ("This method is not allowed in a separated query object");
	}

	public function fetchPairs($key = NULL, $value = NULL)
	{
		throw new InvalidStateException ("This method is not allowed in a separated query object");
	}
}

class InvalidStateException extends \LogicException
{

}

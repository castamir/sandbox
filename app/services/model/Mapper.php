<?php

namespace Model;

use LeanMapper\DefaultMapper;

/**
 * Standard mapper for conventions:
 * - underdash separated names of tables and cols
 * - PK and FK is in [table]_id format
 * - entity repository is named [Entity]Repository
 * - M:N relations are stored in [table1]_[table2] tables
 *
 * @author Jan Nedbal
 * @author Miroslav Paulík
 */
class StandardMapper extends DefaultMapper
{
	/** @var string */
	protected $defaultEntityNamespace = 'Model\Tables';

	private $predefinedPrefixes = array();

	/**
	 * Model\Entity\SomeEntity -> some_entity
	 * @param string $entityClass
	 * @return string
	 */
	public function getTable($entityClass)
	{
		return $this->camelToUnderdash($this->trimNamespace($entityClass));
	}

	/**
	 * some_entity -> Model\Entity\SomeEntity
	 * some_entity -> Model\Entity\Some\Entity if 'some' is a predefined prefix
	 * @param string $table
	 * @param \LeanMapper\Row $row
	 * @return string
	 */
	public function getEntityClass($table, \LeanMapper\Row $row = NULL)
	{
		$namespace = $this->defaultEntityNamespace . '\\';
		$len = strlen($table);
		foreach ($this->predefinedPrefixes as $prefix) {
			if ($len > strlen($prefix) && $prefix.'_' == substr($table, 0, strlen($prefix) + 1)) {
				$namespace .= ucfirst($this->underdashToCamel($prefix)) . '\\';
				$table = substr($table, strlen($prefix) + 1);
				break;
			}
		}
		return $namespace . ucfirst($this->underdashToCamel($table));
	}

	/**
	 * someField -> some_field
	 * @param string $entityClass
	 * @param string $field
	 * @return string
	 */
	public function getColumn($entityClass, $field)
	{
		return $this->camelToUnderdash($field);
	}

	/**
	 * some_field -> someField
	 * @param string $table
	 * @param string $column
	 * @return string
	 */
	public function getEntityField($table, $column)
	{
		return $this->underdashToCamel($column);
	}

	/**
	 * @param string $sourceTable
	 * @param string $targetTable
	 * @return string
	 */
	public function getRelationshipColumn($sourceTable, $targetTable)
	{
		return $targetTable;
	}

	/**
	 * Model\Repository\SomeEntityRepository -> some_entity
	 * @param string $repositoryClass
	 * @return string
	 */
	public function getTableByRepositoryClass($repositoryClass)
	{
		$class = preg_replace('#([a-z0-9]+)Repository$#', '$1', $repositoryClass);
		return $this->camelToUnderdash($this->trimNamespace($class));
	}

	/**
	 * camelCase -> underdash_separated.
	 * @param  string
	 * @return string
	 */
	protected function camelToUnderdash($s)
	{
		$s = preg_replace('#(.)(?=[A-Z])#', '$1_', $s);
		$s = strtolower($s);
		$s = rawurlencode($s);
		return $s;
	}

	/**
	 * underdash_separated -> camelCase
	 * @param  string
	 * @return string
	 */
	protected function underdashToCamel($s)
	{
		$s = strtolower($s);
		$s = preg_replace('#_(?=[a-z])#', ' ', $s);
		$s = substr(ucwords('x' . $s), 1);
		$s = str_replace(' ', '', $s);
		return $s;
	}

	/**
	 * Trims namespace part from fully qualified class name
	 * Handles table prefixes from extended namespaces
	 * Model\Entity\User => User
	 * Model\Entity\Netiso\User  => NetisoUser
	 * \Model\Entity\Netiso\User => NetisoUser
	 *
	 * @param $class
	 * @return string
	 */
	protected function trimNamespace($class)
	{
		if (strlen($class) > 0 && $class[0] == '\\') {
			$class = substr($class, 1);
		}
		$namespaces = explode('\\', $class);
		if (count($namespaces) > 2) {
			$namespaces = array_slice($namespaces, 2);
			return implode("", $namespaces);
		} else {
			return end($class);
		}
	}

}


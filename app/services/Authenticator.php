<?php

use Nette\Security, Nette\Utils\Strings;

/*
CREATE TABLE users (
	id int(11) NOT NULL AUTO_INCREMENT,
	username varchar(50) NOT NULL,
	password char(60) NOT NULL,
	role varchar(20) NOT NULL,
	PRIMARY KEY (id)
);
*/

/**
 * Users authenticator.
 */
class Authenticator extends Nette\Object implements Security\IAuthenticator
{

	/** @var Nette\Database\Connection */
	private $database;

	public function __construct(Nette\Database\Connection $database)
	{
		$this->database = $database;
	}

	/**
	 * Performs an authentication.
	 *
	 * @param array $credentials
	 * @throws Nette\Security\AuthenticationException
	 * @return Nette\Security\Identity
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;
		$row = $this->database->table('users')->where('username', $username)->fetch();

		if (!$row) {
			throw new Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
		}

		if ($row->password !== $this->calculateHash($password, $row->password)) {
			throw new Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
		}

		unset($row->password);

		return new Security\Identity($row->id, $row->role, $row->toArray());
	}

	/**
	 * Computes salted password hash.
	 *
	 * @param  string $password
	 * @return string
	 */
	public static function calculateHash($password)
	{
		return crypt($password, '$2a$07$');
	}

}

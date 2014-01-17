<?php

namespace Services\Security;

use Model\NotFoundException;
use Model\Tables\UserRepository;
use Nette;
use Nette\Utils\Strings;

class Authenticator extends Nette\Object implements Nette\Security\IAuthenticator
{
	/** @var UserRepository */
	private $userRepository;

	function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * Performs an authentication.
	 * @param array $credentials
	 * @throws Nette\Security\AuthenticationException
	 * @return Nette\Security\Identity
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		try {
			$entity = $this->userRepository->findOneBy(array("username" => $username));
		} catch (NotFoundException $e) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
		}

		if (!$this->isPasswordValid($password, $entity->password)) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
		}

		return new Nette\Security\Identity($entity->id, NULL, array());
	}

	/**
	 * Computes salted password hash.
	 * @param string $password
	 * @param  string $salt To generate a new salted password hash, let $salt = NULL
	 * @return string
	 */
	public static function calculateHash($password, $salt = NULL)
	{
		return crypt($password, $salt ? : '$2a$07$' . Strings::random(22));
	}

	/**
	 * @param $password
	 * @param $hash
	 * @return bool
	 */
	private function isPasswordValid($password, $hash)
	{
		return $hash === $this->calculateHash($password, $hash);
	}

}











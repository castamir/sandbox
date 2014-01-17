<?php

use Model\Entity\User;
use Nette\DI\Container;
use Tester\Assert;

$container = require __DIR__ . '/bootstrap.php';

class UserClosureTest extends Tester\TestCase
{
	private $container;
	/** @var \Model\Repository\UserRepository @inject */
	public $userRepository;
	/** @var DibiConnection @inject */
	public $connection;

	function __construct(Container $container)
	{
		$this->container = $container;
	}

	function setUp()
	{
		$this->userRepository = $this->container->getByType('\\Model\\Repository\\UserRepository');
	}

	function testSponsor()
	{
		Assert::equal(1, $this->userRepository->get(2)->sponsor);
		Assert::equal(2, $this->userRepository->get(4)->sponsor);
		Assert::equal(3, $this->userRepository->get(7)->sponsor);
		Assert::equal(4, $this->userRepository->get(8)->sponsor);
	}

}

id(new UserClosureTest($container))->run();

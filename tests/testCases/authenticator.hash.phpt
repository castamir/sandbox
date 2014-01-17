<?php

use Nette\DI\Container;
use Tester\Assert;

$container = require __DIR__ . '/bootstrap.php';

class ExampleTest extends Tester\TestCase
{
	private $container;

//	function __construct(Container $container)
//	{
//		$this->container = $container;
//	}

	function setUp()
	{

	}

	function tearDown()
	{

	}

	function testShowHash()
	{
		echo \Services\Security\Authenticator::calculateHash("159");
	}

}

id(new ExampleTest($container))->run();

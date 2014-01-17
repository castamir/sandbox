<?php

require __DIR__ . '/../../libs/composer/autoload.php';

if (!class_exists('Tester\Assert')) {
	echo "Install Nette Tester using `composer update --dev`\n";
	exit(1);
}

function id($val)
{
	return $val;
}

$configurator = new Nette\Configurator;
$configurator->setDebugMode(TRUE);
//$configurator->setDebugMode(FALSE);
$configurator->enableDebugger(__DIR__ . '/temp');
$configurator->setTempDirectory(__DIR__ . '/temp');
$configurator->createRobotLoader()
	->addDirectory(__DIR__ . '/../../app')
	->addDirectory(__DIR__ . '/../../libs')
	->register();

$configurator->addConfig(__DIR__ . '/../../app/config/config.neon');
$configurator->addConfig(__DIR__ . '/test.config.local.neon');
$container = $configurator->createContainer();

/** @var $connection DibiConnection */
$connection = $container->getByType('\\DibiConnection');
$connection->loadFile(__DIR__ . '/sql/user.start.sql');

return $container;

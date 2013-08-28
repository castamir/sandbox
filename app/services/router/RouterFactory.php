<?php

namespace App;

use Nette,
	Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route,
	Nette\Application\Routers\SimpleRouter;

/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return \Nette\Application\IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList();
		$router[] = $module = new RouteList('Admin');
		$module[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
		$router[] = $module = new RouteList('Front');
		$module[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
		$module[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}

}

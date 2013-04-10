<?php

use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\SimpleRouter;

class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList();

		$router[] = $admin = new RouteList("admin");
		$admin[] = new Route('admin/<presenter>/<action>[/<id>]', 'Homepage:default');

		$router[] = $front = new RouteList("front");
		$front[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
		$front[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

		return $router;
	}

}

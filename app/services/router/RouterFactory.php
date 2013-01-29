<?php

use Nette\Application\Routers\RouteList,
    Nette\Application\Routers\Route,
    Nette\Application\Routers\SimpleRouter;

/**
 * Router factory.
 */
class RouterFactory {

    /**
     * @return Nette\Application\IRouter
     */
    public function createRouter() {
        $router = new RouteList();

        $router[] = $front = new RouteList("Front");
        $front[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
        $front[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
        return $router;
    }

}

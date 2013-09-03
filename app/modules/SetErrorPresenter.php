<?php

namespace QOP\Application;

use Nette;

/*
 * Usage
 *
$container->application->onRequest[] = function($application, $request) {
	//$application->catchExceptions = true;
	QOP\Application\SetErrorPresenter::setErrorPresenter($application, $request);
};
 *
 */

class SetErrorPresenter
{

    /**
     * @param Nette\Application\Application $app
     * @param Nette\Application\Request $request
     * @return void
     */
    public static function setErrorPresenter($app, $request)
    {
        $errorPresenter = 'Error';
        $modules = explode(":", $request->getPresenterName());
        unset($modules[count($modules) - 1]);
        while (count($modules) != 0) {
            $catched = FALSE;
            try {
                $errorPresenter = implode(":", $modules) . ':Error';
                $errorPresenterClass = $app->getPresenterFactory()->getPresenterClass($errorPresenter);
            } catch (Nette\Application\InvalidPresenterException $e) {
                $catched = TRUE;
            }
            if (!$catched) {
                break;
            }
            unset($modules[count($modules) - 1]);
        }
        $app->errorPresenter = $errorPresenter;
    }

}

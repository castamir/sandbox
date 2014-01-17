<?php
namespace App;

use JanTvrdik\Components\DatePicker;
use Nette\Application\InvalidPresenterException;
use Nette\Forms\Container;
use Nette;
use WebLoader\Nette\CssLoader;
use WebLoader\Nette\JavaScriptLoader;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @var Nette\Application\Application @inject */
	public $appl;
	/** @var \WebLoader\LoaderFactory @inject */
	public $webLoader;

	protected function startup()
	{
		parent::startup();

		Container::extensionMethod('addDatePicker', function (Container $container, $name, $label = NULL) {
			return $container[$name] = new DatePicker($label);
		});
		$this->setErrorPresenter();
	}

	protected function setErrorPresenter()
	{
		$errorPresenter = 'Error';
		$modules = explode(":", $this->name);
		unset($modules[count($modules) - 1]);
		while (count($modules) != 0) {
			$catched = FALSE;
			try {
				$errorPresenter = implode(":", $modules) . ':Error';
				$errorPresenterClass = $this->appl->getPresenterFactory()->getPresenterClass($errorPresenter);
			} catch (InvalidPresenterException $e) {
				$catched = TRUE;
			}
			if (!$catched) {
				break;
			}
			unset($modules[count($modules) - 1]);
		}
		$this->appl->errorPresenter = $errorPresenter;
	}

	/** @return CssLoader */
	protected function createComponentCss()
	{
		return $this->webLoader->createCssLoader('default');
	}

	/** @return JavaScriptLoader */
	protected function createComponentJs()
	{
		return $this->webLoader->createJavaScriptLoader('default');
	}
}

<?php

use JanTvrdik\Components\DatePicker;
use Nette\Forms\Container;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @var Nette\Application\Application @inject */
	public $appl;

	public function startup()
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
			} catch (\Nette\Application\InvalidPresenterException $e) {
				$catched = TRUE;
			}
			if (!$catched) {
				break;
			}
			unset($modules[count($modules) - 1]);
		}
		$this->appl->errorPresenter = $errorPresenter;
	}
}

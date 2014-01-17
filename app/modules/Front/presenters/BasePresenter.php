<?php

namespace App\FrontModule;

use App\BasePresenter as Presenter;
use Model\Tables\User;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Presenter
{
	/** @var \Model\Tables\UserRepository @inject */
	public $userRepository;
	/** @var  User */
	protected $profile;

	protected function startup()
	{
		parent::startup();
		if (!$this->user->isLoggedIn()) {
			$this->redirect('Sign:in');
		}
		$this->profile = $this->userRepository->get($this->user->id);
	}

	protected function beforeRender()
	{
		parent::beforeRender();
		$this->template->resources = $this->profile->resources;
		$this->template->profile = $this->profile;
	}
}

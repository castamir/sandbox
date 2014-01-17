<?php

namespace App\FrontModule;

use Model\Entity\User;
use Nette\Application\UI\Form;
use App\BasePresenter as Presenter;
use Services\Security\Authenticator;

class RegistracePresenter extends Presenter
{
	/** @var \Model\Repository\UserRepository @inject */
	public $userRepository;

	/**
	 * @return Form
	 */
	protected function createComponentForm()
	{
		$form = new Form();
		$form->addText('username', 'Login:')
			->setRequired('Zvolte si Vaše uživatelské jméno.');
		$form->addPassword('password', 'Heslo:')->setRequired('Zvolte si prosím heslo.');

		$form->addSubmit("send", "Zaregistrovat");
		$form->onSuccess[] = $this->formSucceeded;

		return $form;
	}

	/**
	 * @param Form $form
	 */
	public function formSucceeded(Form $form)
	{
		$values = $form->values;
		$user = new User();
		$user->username = $values->username;
		$user->password = Authenticator::calculateHash($values->password);

		try {
			$this->userRepository->persist($user);
		} catch (\Exception $e) {
			$this->flashMessage("Tohle uživatelské jméno je již obsazeno, zvolte si prosím jiné");
			return;
		}

		$this->flashMessage("Registrace proběhla úspěšně.");
		$this->redirect("Sign:in");
	}
}

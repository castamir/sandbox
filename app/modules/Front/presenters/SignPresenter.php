<?php

namespace App\FrontModule;

use App\BasePresenter as Presenter;
use LeanMapper\Fluent;
use Nette;
use Model;
use Nette\Application\UI\Form;
use Services\Security\Authenticator;

/**
 * Sign in/out presenters.
 */
class SignPresenter extends Presenter
{
	public function actionIn()
	{
		if ($this->user->isLoggedIn()) {
			$this->redirect("Homepage:");
		}
	}

	public function actionHash()
	{
		dump(Authenticator::calculateHash("mirasman"));
		die;
	}

	/**
	 * Sign-in form factory.
	 *
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new Nette\Application\UI\Form;
		$form->addText('username', 'Login:')->setRequired('Zadejte Vaše uživatelské jméno.');
		$form->addPassword('password', 'Heslo:')->setRequired('Zadejte prosím heslo.');

		$form->addCheckbox('remember', 'Zapamatovat');

		$form->addSubmit('send', 'Přihlásit');

		// call method signInFormSucceeded() on success
		$form->onSuccess[] = $this->signInFormSucceeded;

		return $form;
	}

	public function signInFormSucceeded(Form $form)
	{
		$values = $form->getValues();

		if ($values->remember) {
			$this->getUser()->setExpiration('14 days', FALSE);
		} else {
			$this->getUser()->setExpiration('20 minutes', TRUE);
		}

		try {
			$this->getUser()->login($values->username, $values->password);
			$this->redirect('Homepage:');
		} catch (Nette\Security\AuthenticationException $e) {
			$this->flashMessage($e->getMessage());
		}
	}

	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Odhlášení proběhlo úspěšně.');
		$this->redirect('in');
	}

}

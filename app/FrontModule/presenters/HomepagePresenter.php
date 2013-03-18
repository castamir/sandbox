<?php

namespace FrontModule;

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{


	public $questions = array(
		0 => array(
			"id"           => 2,
			"question"     => "Otázka č.2",
			"answer_1"     => "Špatně",
			"answer_2"     => "Správně",
			"answer_3"     => "Špatně",
			"right_answer" => 2,
			"gender"       => "female",
		),
		1 => array(
			"id"           => 3,
			"question"     => "Otázka č.3",
			"answer_1"     => "Špatně",
			"answer_2"     => "Správně",
			"answer_3"     => "Špatně",
			"right_answer" => 2,
			"gender"       => "female",
		),
		2 => array(
			"id"           => 4,
			"question"     => "Otázka č.4",
			"answer_1"     => "Špatně",
			"answer_2"     => "Správně",
			"answer_3"     => "Špatně",
			"right_answer" => 2,
			"gender"       => "female",
		),
		3 => array(
			"id"           => 5,
			"question"     => "Otázka č.5",
			"answer_1"     => "Špatně",
			"answer_2"     => "Správně",
			"answer_3"     => "Špatně",
			"right_answer" => 2,
			"gender"       => "female",
		),
		4 => array(
			"id"           => 6,
			"question"     => "Otázka č.6",
			"answer_1"     => "Špatně",
			"answer_2"     => "Správně",
			"answer_3"     => "Špatně",
			"right_answer" => 2,
			"gender"       => "female",
		)
	);

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

	protected function createComponentForm()
	{
		$form = new \Nette\Application\UI\Form;
		$container = $form->addContainer('question');

		foreach ($this->questions as $question) {
			$container->addRadioList($question['id'], $question['question'], array(
																				  1 => $question['answer_1'],
																				  2 => $question['answer_2'],
																				  3 => $question['answer_3'],
																			 ))
				->setRequired('Musíte zaškrtnout jednu odpověď u každé otázky!');
		}

		$form->addSubmit('send');

		$form->onSuccess[] = callback($this, 'formSubmitted');

		return $form;
	}

}

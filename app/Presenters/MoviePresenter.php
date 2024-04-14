<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Database\Explorer;

final class MoviePresenter extends Nette\Application\UI\Presenter {

	public function __construct(
		private Explorer $database,
	) {
	}

	public function renderDefault(): void {
		$this->template->movies = $this->database
			->table('movies');
	}

	public function renderShow(int $id): void {
		$this->template->movie = $this->database
			->table('movies')
			->get($id);
	}

	public function renderEdit(int $id): void {
		$post = $this->database
			->table('movies')
			->get($id);

		if( !$post ) {
			$this->error('Movie not found');
		}

		$this->getComponent('movieForm')?->setDefaults($post->toArray());
	}

	public function actionDelete(int $id): void {
		$movie = $this->database
			->table('movies')
			->get($id);

		if( !$movie ) {
			$this->error('Movie not found');
		}

		$movie->delete();

		$this->redirect('Movie:default');
	}

	protected function createComponentMovieForm(): Form {
		$form = new Form;
		$form->addText('title', 'Title:')
			->setRequired();
		$form->addText('year', 'Year:');
		$form->addText('genre', 'Genre:');
		$form->addText('author', 'Author:');
		$form->addTextArea('description', 'Description:');

		$form->addSubmit('send', 'Save');
		$form->onSuccess[] = $this->movieFormSucceeded( ... );

		return $form;
	}

	private function movieFormSucceeded(array $data): void {
		$id = $this->getParameter('id');

		if( $id ) {
			$movie = $this->database
				->table('movies')
				->get($id);
			$movie?->update($data);
		} else {
			$movie = $this->database
				->table('movies')
				->insert($data);
		}

		$this->flashMessage("Movie successfully added", 'success');
		$this->redirect('Movie:show', $movie->id);
	}

}

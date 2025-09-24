<?php
namespace App\Site\Controllers;

use App\Site\Helpers\EditGameHelper;
use App\Site\Models\Game;
use App\Site\Requests\Game\EditionRequestRequest;

class EditGameController extends BaseController
{
	protected $game;
	protected $editGameHelper;

	public function __construct(EditGameHelper $editGameHelper)
	{
		parent::__construct();

		$this->editGameHelper = $editGameHelper;

		$this->middleware(function($request, $next) {
			$this->game = Game::findBySlugOrFail($request->gameSlug);
			
			$this->editGameHelper->setGame($this->game);
			$this->editGameHelper->setUser($request->user('site'));

			return $next($request);
		});
	}

	public function edition()
	{
		$this->head->setTitle('Editar ' . $this->game->name);
		$this->head->setDescription('Editar dados de ' . $this->game->name);
		
		return $this->view('game.edition.index', [
		    'canEdit' => $this->editGameHelper->canEdit(),
			'characteristics' => $this->editGameHelper->getCharacteristics(),
			'developers' => $this->editGameHelper->getDevelopers(),
			'franchises' => $this->editGameHelper->getFranchises(),
			'game' => $this->game,
			'genres' => $this->editGameHelper->getGenres(),
			'modes' => $this->editGameHelper->getModes(),
			'platforms' => $this->editGameHelper->getPlatforms(),
			'publishers' => $this->editGameHelper->getPublishers(),
			'themes' => $this->editGameHelper->getThemes()
		]);
	}
	
	public function editionRequest(EditionRequestRequest $request)
	{
		$redirect = redirect()->route('game.index', $this->game->slug);
		    
	    if($this->editGameHelper->checkForModification($request->except('id', '_token'))) {
			if($this->editGameHelper->checkIfGameAlreadyExists($request->name, $request->release)) {
				return $redirect->with('alert', 'warning|'. $request->name . ' já existe no catálogo!');
			}

            if($this->editGameHelper->canEdit()) {
				$this->editGameHelper->update($request);
                
                return $redirect->with('alert', 'success|Dados do jogo atualizados com sucesso');
            } else {
				$this->editGameHelper->createEditionRequest($request->id, $request->except('id', '_token'));
				$this->editGameHelper->sendEditionRequestMail($this->settings->email);
	            
	            return $redirect->with('alert', 'info|Solicitação de edição enviada com sucesso!|false');
		    }
	    }
		
		return $redirect;
	}
}
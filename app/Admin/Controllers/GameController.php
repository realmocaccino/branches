<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\GameRequest;
use App\Admin\Models\{
	Characteristic,
	Classification,
	Criteria,
	Developer,
	Franchise,
	Game,
	Genre,
	Mode,
	Platform,
	Publisher,
	Theme
};
use App\Common\DTOs\GameDto;
use App\Common\Events\GameAddedEvent;

class GameController extends BaseController
{
	protected $characteristic;
	protected $classification;
	protected $criteria;
	protected $developer;
	protected $franchise;
	protected $game;
	protected $genre;
	protected $mode;
	protected $platform;
	protected $publisher;
	protected $theme;
	
	protected $pathCover;
	protected $pathBackground;

	public function __construct(Characteristic $characteristic,
								Classification $classification,
								Criteria $criteria,
								Developer $developer,
								Franchise $franchise,
								Game $game,
								Genre $genre,
								Mode $mode,
								Platform $platform,
								Publisher $publisher,
								Theme $theme)
	{
		parent::__construct();
		
		$this->characteristic = $characteristic;
		$this->classification = $classification;
		$this->criteria = $criteria;
		$this->developer = $developer;
		$this->franchise = $franchise;
		$this->game = $game;
		$this->genre = $genre;
		$this->mode = $mode;
		$this->platform = $platform;
		$this->publisher = $publisher;
		$this->theme = $theme;
	}

	public function index($relationship = null, $column = null, $value = null)
	{
		$this->head->setTitle('Jogos');
		
		$games = $this->game->filter($relationship, $column, $value);
		
		return $this->view('games.index')->with([
			'games' => $games->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma jogo encontrado']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Jogo');
		
		return $this->view('games.create', [
			'characteristics' => $this->characteristic->orderBy('name_pt')->pluck('name_pt', 'id')->all(),
			'classifications' => $this->classification->orderBy('name')->pluck('name', 'id')->all(),
			'criterias' => $this->criteria->orderBy('name_pt')->pluck('name_pt', 'id')->all(),
			'developers' => $this->developer->orderBy('name')->pluck('name', 'id')->all(),
			'franchises' => $this->franchise->orderBy('name')->pluck('name', 'id')->all(),
			'genres' => $this->genre->orderBy('name_pt')->pluck('name_pt', 'id')->all(),
			'modes' => $this->mode->orderBy('name_pt', 'desc')->pluck('name_pt', 'id')->all(),
			'platforms' => $this->platform->orderBy('name')->pluck('name', 'id')->all(),
			'publishers' => $this->publisher->orderBy('name')->pluck('name', 'id')->all(),
			'themes' => $this->theme->orderBy('name_pt')->pluck('name_pt', 'id')->all(),
		]);
	}
	
	public function store(GameRequest $request)
	{
		$data = new GameDto($request->all());

		$game = $this->game->create($data->asArray() + [
			'slug' => $request->slug,
			'status' => $request->status
		]);
		
		$game->syncRelationships($data->getRelationships());
		
		if($request->cover) $game->uploadFile('cover', $data->getCover());
		if($request->background) $game->uploadFile('background', $data->getBackground());
		
		event(new GameAddedEvent($game));
		
		return redirect(route('games.index'))->with('message', 'success|Jogo criado com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Jogo');
		
		return $this->view('games.edit', [
			'characteristics' => $this->characteristic->orderBy('name_pt')->pluck('name_pt', 'id')->all(),
			'classifications' => $this->classification->orderBy('name')->pluck('name', 'id')->all(),
			'criterias' => $this->criteria->orderBy('name_pt')->pluck('name_pt', 'id')->all(),
			'developers' => $this->developer->orderBy('name')->pluck('name', 'id')->all(),
			'franchises' => $this->franchise->orderBy('name')->pluck('name', 'id')->all(),
			'game' => $this->game->find($id),
			'genres' => $this->genre->orderBy('name_pt')->pluck('name_pt', 'id')->all(),
			'modes' => $this->mode->orderBy('name_pt', 'desc')->pluck('name_pt', 'id')->all(),
			'platforms' => $this->platform->orderBy('name')->pluck('name', 'id')->all(),
			'publishers' => $this->publisher->orderBy('name')->pluck('name', 'id')->all(),
			'themes' => $this->theme->orderBy('name_pt')->pluck('name_pt', 'id')->all(),
		]);
	}
	
	public function update(GameRequest $request, $id)
	{
		$data = new GameDto($request->all());

		$game = $this->game->find($id);

		$game->update($data->asArray() + [
			'slug' => $request->slug,
			'status' => $request->status
		]);
		
		$game->syncRelationships($data->getRelationships());
		
		if($request->cover) {
			$game->uploadFile('cover', $data->getCover());
		} elseif($request->remove_cover) {
			$game->deleteFile('cover');
		}
		
		if($request->background) {
			$game->uploadFile('background', $data->getBackground());
		} elseif($request->remove_background) {
			$game->deleteFile('background');
		}
		
		$game->touch();
		
		return redirect(route('games.index'))->with('message', 'success|Jogo atualizado com sucesso');
	}
	
	public function destroy($id)
	{
		$game = $this->game->find($id);
		
		if($game->cover) $game->deleteFile('cover');
		if($game->background) $game->deleteFile('background');
		
		$game->delete();
		
		return response()->json([
			'message' => 'Jogo excluído com sucesso!',
		]);
	}
}

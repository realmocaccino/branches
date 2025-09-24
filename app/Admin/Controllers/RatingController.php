<?php
namespace App\Admin\Controllers;

use App\Site\Models\Game;
use App\Admin\Requests\RatingRequest;
use App\Admin\Models\Rating;
use App\Common\Helpers\RatingHelper;

class RatingController extends BaseController
{
	protected $rating;

	public function __construct(Rating $rating)
	{
		parent::__construct();
		
		$this->rating = $rating;
	}

	public function index($relationship = null, $column = null, $value = null)
	{
		$this->head->setTitle('Avaliações');
		
		$ratings = $this->rating->filter($relationship, $column, $value);
		
		return $this->view('ratings.index')->with([
			'ratings' => $ratings->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma avaliação encontrada']
		]);
	}
	
	public function edit($id)
	{
		$rating = $this->rating;
	
		$this->head->setTitle('Editar Avaliação');
		$this->head->addScripts(['avaliacoes.js']);
		
		return $this->view('ratings.edit', [
			'rating' => $this->rating->find($id),
			'games' => $this->rating->getGamesForEdit($id),
			'platforms' => $this->rating->getPlatformsForEdit($id),
			'users' => $this->rating->getUsersForEdit($id)
		]);
	}
	
	public function update(RatingRequest $request, $id)
	{
		$this->rating->find($id)->update($request->all());
		
		return redirect(route('ratings.index'))->with('message', 'success|Avaliação atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$rating = $this->rating->find($id);
	
		$RatingHelper = new RatingHelper(Game::findBySlugOrFail($rating->game->slug), $rating->user, $rating);
		$RatingHelper->delete();
		
		return response()->json([
			'message' => 'Avaliação excluída com sucesso!',
		]);
	}
}

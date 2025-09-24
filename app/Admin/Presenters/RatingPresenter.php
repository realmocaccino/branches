<?php
namespace App\Admin\Presenters;

use App\Admin\Models\{Game, User};

trait RatingPresenter
{
	use BasePresenter;
	
	public function getGamesForEdit($id)
	{
		return Game::where(function($query) use($id)
		{
			$query->whereNotIn('id', $this->where('user_id', $this->find($id)->user->id)
										  ->where('game_id', '!=', $this->find($id)->game->id)
										  ->pluck('game_id')
										  ->all());
		})
		->orderBy('name')
		->pluck('name', 'id')
		->all();
	}
	
	public function getPlatformsForEdit($id)
	{
		return $this->find($id)->game->platforms()->orderBy('name')->pluck('platforms.name', 'platforms.id')->all();
	}
		
	public function getUsersForEdit($id)
	{
		return User::where(function($query) use($id)
		{
			$query->whereNotIn('id', $this->where('game_id', $this->find($id)->game->id)
										  ->where('user_id', '!=', $this->find($id)->user->id)
										  ->pluck('user_id')
										  ->all());
		})
		->orderBy('name')
		->pluck('name', 'id')
		->all();
	}
}

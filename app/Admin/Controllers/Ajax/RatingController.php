<?php
namespace App\Admin\Controllers\Ajax;

use App\Admin\Models\Game;

class RatingController extends BaseController
{
	protected $game;

	public function __construct(Game $game)
	{
		parent::__construct();
		
		$this->game = $game;
	}

	public function getPlatformsByGame($game_id)
	{
		$platforms = $this->game->find($game_id)->platforms()->pluck('platforms.name', 'platforms.id')->all();
	
		return $this->view('ratings.platforms', [
			'platforms' => $platforms
		]);
	}
}

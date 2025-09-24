<?php
namespace App\Site\Controllers\Ajax;

use App\Common\Helpers\RatingHelper;
use App\Site\Models\{Game, Platform};
use App\Site\Helpers\Chart;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GameController extends BaseController
{
	protected $game;
	protected $request;
	protected $user;
	protected $userRating;

	public function __construct(Request $request)
	{
		parent::__construct();
		
		$this->game = Game::findBySlugOrFail($request->gameSlug);
		$this->request = $request;
		$this->middleware(function($request, $next) {
			$this->user = Auth::guard('site')->user();
			$this->userRating = RatingHelper::find($this->game, $this->user);
			
			return $next($request);
		});
	}

	public function getCriteriasScoresByPlatform()
	{
		$platformId = optional(Platform::findBySlug($this->request->platform_slug))->id;
        $datasets = Chart::prepareDatasets($this->game, $this->userRating, $platformId);
		
		return [
			'datasets' => $datasets,
			'criteriasScores' => view('site.game.components.index.criteriasScores', [
                'game' => $this->game,
                'userRating' => $this->userRating,
                'platformId' => $platformId
            ])->render()
		];
	}
}
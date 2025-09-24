<?php
namespace App\Site\Controllers;

use App\Site\Controllers\Traits\ForumTrait;
use App\Site\Helpers\GameHelper;
use App\Site\Models\Game;

class GameController extends BaseController
{
	use ForumTrait;

	protected $game;
	protected $gameHelper;

	public function __construct(GameHelper $gameHelper)
	{
		parent::__construct();

		$this->gameHelper = $gameHelper;

		$this->middleware(function($request, $next) {
			$this->game = Game::findBySlugOrFail($request->gameSlug);
			
			$this->gameHelper->setGame($this->game);
			$this->gameHelper->setUser($request->user('site'));
			$this->gameHelper->shareGameToView();
			$this->gameHelper->shareCommonVariablesToView();

			$this->head->setDescription($this->game->description ?? $this->gameHelper->getDefaultDescription());
			if($this->game->cover) {
				$this->head->setImage($this->game->getCover('250x'), '250', '250');
			}

			return $next($request);
		});
	}

	public function index()
	{
		$this->head->setTitle($this->gameHelper->getIndexTitle());

		$this->gameHelper->shareDatasetsToView();
        $this->gameHelper->shareRatersToView();

		return $this->view(!$this->game->isAvailable() ? 'game.not_released' : ($this->game->ratings->count() ? 'game.index' : 'game.no_ratings'));
	}
	
	public function about()
	{
		$this->head->setTitle($this->gameHelper->getAboutTitle());

		return $this->view('game.about');
	}
	
	public function collections()
	{
		$this->head->setTitle($this->gameHelper->getCollectionsTitle());
		
		return $this->view('game.collections', [
		    'collections' => $this->gameHelper->getCollections()
		]);
	}
	
	public function contributions()
	{
		$this->head->setTitle($this->gameHelper->getContributionsTitle());

		return $this->view('game.contributions');
	}
	
	public function ratings($gameSlug, $platformSlug = null)
	{
		$platform = $this->gameHelper->getPlatform($platformSlug);
		
		$this->head->setTitle($this->gameHelper->getRatingsTitle($platform));
		
		return $this->view('game.ratings', [
			'ratings' => $this->gameHelper->getRatings($platform),
			'platformsToFilter' => $this->gameHelper->getPlatformsToFilter(),
			'currentPlatform' => $platform
		]);
	}
	
	public function relateds()
	{
		$this->head->setTitle($this->gameHelper->getRelatedsTitle());
		
		return $this->view('game.relateds', [
			'games' => $this->gameHelper->getRelateds()
		]);
	}
	
	public function review($gameSlug, $userSlug)
	{
		$review = $this->gameHelper->getReview($userSlug);

        $this->head->setTitle($this->gameHelper->getReviewTitle($review));
        $this->head->setDescription($this->gameHelper->getReviewDescription($review));
		
		return $this->view('game.review', [
			'review' => $review,
			'otherReviews' => $this->gameHelper->getOtherReviews($review)
		]);
	}

	public function reviews($gameSlug, $platformSlug = null)
	{
		$platform = $this->gameHelper->getPlatform($platformSlug);
		
		$this->head->setTitle($this->gameHelper->getReviewsTitle($platform));
		
		return $this->view('game.reviews', [
			'reviews' => $this->gameHelper->getReviews($platform),
			'platformsToFilter' => $this->gameHelper->getPlatformsToFilter(),
			'currentPlatform' => $platform
		]);
	}
	
	public function screenshots()
	{
		$this->head->setTitle($this->gameHelper->getScreenshotsTitle());
		
		return $this->view('game.screenshots');
	}
	
	public function trailer()
	{
		$this->head->setTitle($this->gameHelper->getTrailerTitle());

		return $this->view('game.trailer');
	}

	public function warnMe()
	{
		$redirect = redirect()->route('game.index', $this->game->slug);

		if(!$this->gameHelper->getWarnMe()) {
			$this->gameHelper->createWarnMe();
			$this->gameHelper->wishlist();
		
			return $redirect->with('alert', 'info|Te avisaremos por email quando o jogo for lançado');
		}

		return $redirect;
	}

	public function cancelWarnMe()
	{
		$redirect = redirect()->route('game.index', $this->game->slug);
	
		if($warn = $this->gameHelper->getWarnMe()) {
			$warn->delete();
		
			return $redirect->with('alert', 'info|Aviso cancelado');
		}

		return $redirect;
	}

	public function searchForReleaseDate()
    {
		$redirect = redirect()->route('game.index', $this->game->slug);

		if($this->game->isUndated()) {
			$this->gameHelper->searchForReleaseDate();

			return $redirect->with('alert', 'info|Procurando data de lançamento para o jogo');
		}

		return $redirect->with('alert', 'info|Jogo já possui data de lançamento');
	}

    public function touchUp()
    {
		$this->gameHelper->touchUp();

		return redirect()->route('game.index', $this->game->slug)->with('alert', 'info|Os dados do jogo estão sendo atualizados em background');
	}
}
<?php
namespace App\Site\Controllers;

use App\Site\Helpers\{Filter, RankingHelper};

class RankingController extends BaseController
{
	protected $filter;
	protected $perPage;
    protected $rankingHelper;
	protected $startingPosition;

	public function __construct(Filter $filter, RankingHelper $rankingHelper)
	{
		parent::__construct();

		$this->filter = $filter;
		$this->perPage = config('site.ranking_per_page');
        $this->rankingHelper = $rankingHelper;
		$this->startingPosition = $this->rankingHelper->getStartingPosition($currentPage = request()->get('page', 1));
	}

	public function games($year = null)
	{
		$this->head->setTitle($this->rankingHelper->getGamesTitle($year));

		$query = $this->rankingHelper->getGamesRanking($year);
		$this->filter->setQuery($query)->perPage($this->perPage)->disableOrder()->prepare();
	
		return $this->view('ranking.games', [
			'filter' => [
				'actives' => $this->filter->getActives(),
				'filterBars' => $this->filter->getFilterBars(),
				'selectedYear' => $year,
				'years' => $this->rankingHelper->getYearsRange()
			],
			'games' => $this->filter->get(),
			'startingPosition' => $this->startingPosition
		]);
	}
	
	public function users($daysRange = null)
	{
		$this->head->setTitle($this->rankingHelper->getUsersTitle());

        $users = $this->rankingHelper->getAndRememberUsersRanking($daysRange)->paginate($this->perPage)->appends(request()->query());

		return $this->view('ranking.users', [
		    'daysRange' => $daysRange,
			'users' => $users,
			'startingPosition' => $this->startingPosition
		]);
	}
}
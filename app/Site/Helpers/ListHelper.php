<?php
namespace App\Site\Helpers;

use App\Site\Models\Platform;
use App\Site\Repositories\ListRepository;

use Illuminate\Support\Facades\Route;
use Exception;

class ListHelper
{
	protected $filter;
    protected $listRepository;

	protected $furtherExpression;
	protected $limit;
	protected $perPage;
    protected $platform;
	protected $query;
	protected $slug;

	private $trendingDaysFutureGames;
	private $trendingDateGames;
	private $trendingDateFutureGames;
	private $trendingDateGamesReview;
	private $scoreForPraisedGames;
    
	public function __construct(Filter $filter, ListRepository $listRepository)
	{
		$this->filter = $filter;
        $this->listRepository = $listRepository;

		$this->trendingDaysFutureGames = config('site.trending_days_future_games');
        $this->trendingDateGames = now()->subDays(config('site.trending_days_games'));
        $this->trendingDateFutureGames = now()->addDays(config('site.trending_days_future_games'));
        $this->trendingDateGamesReview = now()->subDays(config('site.trending_days_games') * 2);
        $this->scoreForPraisedGames = config('site.list_score_for_praised_games');
	}

	public function setSlug(string $slug)
    {
        $this->slug = $slug;

		return $this;
    }

	public function getSlug()
    {
        return $this->slug;
    }

	public function setPlatform(?string $slug)
    {
        $this->platform = $slug ? Platform::findBySlugOrFail($slug) : null;

		return $this;
    }

	public function resetPlatform()
	{
		$this->platform = null;

		return $this;
	}

    public function getPlatform()
    {
        return $this->platform;
    }

	public function limit(int $limit)
	{
		$this->limit = $limit;

		return $this;
	}

	public function getLimit()
	{
		return $this->limit;
	}

	public function perPage(int $perPage)
	{
		$this->perPage = $perPage;

		return $this;
	}

	public function getPerPage()
	{
		return $this->perPage;
	}

	public function withFurtherExpression($furtherExpression)
	{
		$this->furtherExpression = $furtherExpression;

		return $this;
	}

	public function getFurtherExpression()
	{
		return $this->furtherExpression;
	}

	public function clearOrder()
	{
		return $this->query->getQuery()->orders = null;
	}

	public function count()
    {
		$this->setQuery();

        return count(clone $this->query->get());
    }

	public function first()
	{
		$this->setQuery();

		return (clone $this->query)->first();
	}

    public function get()
    {
		$this->setQuery();

		if($this->perPage) {
			return (clone $this->query)->paginate($this->perPage)->appends(request()->query());
		}

		return (clone $this->query)->when($this->limit, function($query) {
			return $query->take($this->limit);
		})->get();
    }

	public function getCover($size)
	{
		if($game = $this->first()) {
			return $game->getCover($size);
		}

		return null;
	}

	public function getWithFilter()
	{
		$this->setQuery();

		$filter = $this->filter->setQuery(clone $this->query);

		if($this->perPage) {
			$filter->perPage($this->perPage);
		}

		return $filter->prepare();
	}

	public function getQuery()
    {
		$this->setQuery();

        return (clone $this->query);
    }

    public function getTitle()
    {
        return trans('helpers/list/titles.' . $this->slug) . ($this->platform ? ' no ' . $this->platform->name : null);
    }

	public function isExtensiveRelease()
    {
        return in_array($this->slug, ['releases', 'latest-releases', 'next-releases']);
    }

	private function setQuery()
	{
		if(!$this->slug) {
			throw new Exception('List not set.');
		}

		if($this->platform) {
			$this->listRepository->withPlatform($this->platform);
		}

		switch($this->slug) {
		    case 'featured-games':
				$this->query = $this->listRepository->featuredGames(
                    $this->trendingDateGames,
                    $this->trendingDateGamesReview,
					$this->trendingDaysFutureGames
                );
			break;
			case 'popular-games':
				$this->query = $this->listRepository->popularGames(
                    $this->trendingDateGames,
                    $this->trendingDateGamesReview
                );
			break;
			case 'classic-games':
				$this->query = $this->listRepository->classicGames(
                    $this->trendingDateGames,
                    $this->trendingDateGamesReview
                );
			break;
			case 'best-games':
                $this->query = $this->listRepository->bestGames(
                    $this->scoreForPraisedGames
                );
			break;
			case 'acclaimed-games':
                $this->query = $this->listRepository->acclaimedGames(
                    $this->scoreForPraisedGames
                );
			break;
			case 'hidden-gems':
                $this->query = $this->listRepository->hiddenGems(
                    $this->scoreForPraisedGames
                );
			break;
			case 'releases':
				$this->query = $this->listRepository->releases(
                    $this->trendingDateGames,
                    $this->trendingDateFutureGames
                );
			break;	
			case 'latest-releases':
                $this->query = $this->listRepository->latestReleases(
                    $this->trendingDateGames
                );
			break;
			case 'next-releases':
                $this->query = $this->listRepository->nextReleases();
			break;
			case 'recently-rated':
				$this->query = $this->listRepository->recentlyRated(
                    $this->trendingDateGames
                );
			break;
			case 'recently-added':
                $this->query = $this->listRepository->recentlyAdded(
                    $this->trendingDateGames
                );
			break;
			case 'recently-contributed':
                $this->query = $this->listRepository->recentlyContributed(
                    $this->trendingDateGames
                );
			break;
			case 'recently-reviewed':
				$this->query = $this->listRepository->recentlyReviewed(
                    $this->trendingDateGamesReview
                );
			break;
			case 'birthday-today':
				$this->query = $this->listRepository->havingBirthdayToday();
			break;
			case 'in-early-access':
				$this->query = $this->listRepository->inEarlyAccess();
			break;
			case 'most-loved-games':
                $this->query = $this->listRepository->mostLovedGames($this->trendingDateGames);
			break;
			case 'most-desired-games':
                $this->query = $this->listRepository->mostDesiredGames($this->trendingDateGames);
			break;
			case 'most-anticipated-games':
                $this->query = $this->listRepository->mostAnticipatedGames();
			break;
			case 'with-criteria':
				$this->query = $this->listRepository->getGamesWithCriteriasQuery();
			break;
			case 'above-90':
				$this->query = $this->listRepository->byScoreRange('9.0', '10.0');
			break;
			case 'above-95':
				$this->query = $this->listRepository->byScoreRange('9.5', '10.0');
			break;
		}

		if(!$this->query) {
			throw new Exception(sprintf('List "%s" does not exist.', $this->slug));
		}

		$this->query->when($this->furtherExpression, function($query) {
			return $query->where($this->furtherExpression);
		});
	}
}
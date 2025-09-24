<?php
namespace App\Site\Helpers;

use App\Site\Repositories\RankingRepository;

use Illuminate\Cache\Repository as Cache;

class RankingHelper
{
    protected $cache;

    protected $rankingRepository;

    protected $cacheMinutes;
    protected $perPage;
    protected $startingYear;

    public function __construct(Cache $cache, RankingRepository $rankingRepository)
    {
        $this->cache = $cache;
        $this->rankingRepository = $rankingRepository;

        $this->cacheMinutes = config('site.ranking_cache_minutes');
        $this->perPage = config('site.ranking_per_page');
        $this->startingYear = config('site.ranking_starting_year');
    }

    public function getGamesRanking($year = null)
    {
        return $this->rankingRepository->games($year);
    }

    public function getGamesTitle($year = null)
    {
        return trans('ranking/games.title') . ($year ? trans('ranking/games.title_of') . $year : null);
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function getStartingPosition($currentPage)
    {
        return ($this->perPage * $currentPage) - $this->perPage;
    }

    public function getUsersTitle()
    {
        return trans('ranking/users.title');
    }

    public function getUsersRanking($daysRange = null)
    {
        if($daysRange) {
            return $this->rankingRepository->usersByDateLimit(now()->subDays($daysRange));
        } else {
            return $this->rankingRepository->users();
        }
    }

    public function getAndRememberUsersRanking($daysRange = null)
    {
        return $this->cache->remember('rankingUsers' . $daysRange, $this->cacheMinutes, function() use ($daysRange) {
            return $this->getUsersRanking($daysRange);
        });
    }

    public function getYearsRange()
    {
        return range(date('Y'), $this->startingYear);
    }
}
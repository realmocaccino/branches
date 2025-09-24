<?php
namespace App\Site\Helpers;

use App\Site\Helpers\{Filter, ListHelper};
use App\Site\Models\Game;

use Illuminate\Support\Collection;
use Illuminate\Cache\Repository as Cache;

class HomeHelper
{
    private $cache;
	private $filter;
    private $listHelper;
    
    public function __construct(Cache $cache, Filter $filter, ListHelper $listHelper)
    {
		$this->cache = $cache;
        $this->filter = $filter;
        $this->listHelper = $listHelper;
	}

    public function getListFromCacheOrBuildIt($perPage)
    {
        if (!$this->hasFilter() and $gamesIds = $this->getCachedGamesIds()) {
			return $this->filter->setQuery($this->getGamesQuery($gamesIds))->perPage($perPage)->prepare();
		}
		
        return $this->listHelper->setSlug(config('site.home_list_slug'))->perPage($perPage)->getWithFilter();
    }

    private function getCachedGamesIds()
	{
		return $this->cache->get(config('site.home_list_cache_name'));
	}

	private function getGamesQuery(Collection $ids)
    {
        return Game::select('games.*')->whereIn('games.id', $ids)->orderByRaw('FIELD(games.id, ' . $ids->implode(',') . ')');
    }

    private function hasFilter()
    {
		return array_intersect_key(array_flip($this->filter->getFilters()), request()->query());
    }
}
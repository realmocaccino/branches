<?php
namespace App\Site\Services;

use App\Common\Services\CacheService;
use App\Site\Helpers\ListHelper;

class DefaultSearchGamesService
{
    private const CACHE_NAME = 'DefaultSearchGames';
    private const LIST_SLUG = 'popular-games';
    private const LIST_TOTAL_ITEMS = 7;

    private $cache;
    private $listHelper;

    public function __construct(CacheService $cache, ListHelper $listHelper)
    {
        $this->cache = $cache;
        $this->listHelper = $listHelper;
    }

    public function cache()
    {
        $this->cache->forgetThenRememberForever(self::CACHE_NAME, function() {
            return $this->get();
        });
    }

    public function get()
    {
        return $this->listHelper->setSlug(self::LIST_SLUG)->limit(self::LIST_TOTAL_ITEMS)->get();
    }

    public function getFromCache()
    {
        return $this->cache->rememberForever(self::CACHE_NAME, function() {
            return $this->get();
        });
    }
}
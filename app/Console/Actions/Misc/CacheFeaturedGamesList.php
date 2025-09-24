<?php
namespace App\Console\Actions\Misc;

use App\Common\Services\CacheService;
use App\Site\Helpers\ListHelper;

class CacheFeaturedGamesList
{
    private $cache;
	private $listHelper;

    private $cacheName;
    private $listSlug;
    private $totalItems;

    public function __construct(CacheService $cache, ListHelper $listHelper)
    {
        $this->cache = $cache;
        $this->listHelper = $listHelper;

        $this->cacheName = config('site.home_list_cache_name');
        $this->listSlug = config('site.home_list_slug');
        $this->totalItems = config('site.home_list_total_items');
    }

    public function handle()
    {
        $this->cache->forgetThenRememberForever($this->cacheName, function() {
            $list = $this->listHelper->setSlug($this->listSlug)->limit($this->totalItems)->get();

            if ($ids = $list->pluck('id')) {
                return $ids;
            }

            return collect([]);
        });
    }
}
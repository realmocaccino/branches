<?php
namespace App\Site\Helpers;

use Illuminate\Cache\Repository as Cache;

class CategoriesHelper
{
	private $cache;
    private $cachePrefix;

    public function __construct(Cache $cache)
    {
		$this->cache = $cache;
        $this->cachePrefix = config('site.categories_cache_prefix');
	}

    public function getSectionFromCache($section)
	{
		return $this->cache->get(
			sprintf('%s%s', $this->cachePrefix, $section)
		);
	}
}
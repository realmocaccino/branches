<?php
namespace App\Common\Services;

use Closure;
use Illuminate\Contracts\Cache\Repository;

class CacheService
{
    protected $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function forgetThenRememberForever($key, Closure $callback)
    {
        $this->cache->forget($key);

        return $this->cache->rememberForever($key, $callback);
    }

    public function __call($method, $parameters)
    {
        return $this->cache->$method(...$parameters);
    }
}
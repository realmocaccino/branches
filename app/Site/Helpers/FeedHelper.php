<?php
namespace App\Site\Helpers;

use App\Site\Repositories\FeedRepository;

use Illuminate\Support\Facades\Cache;

class FeedHelper
{
    const CACHE_NAME = 'feed';

    private $cache;
    protected $cacheMinutes;
    protected $feedRepository;
    protected $filterBy;

    public function __construct(
        Cache $cache,
        FeedRepository $feedRepository
    ) {
        $this->feedRepository = $feedRepository;
        $this->cache = $cache;
        $this->cacheMinutes = config('site.feed_cache_minutes');
        $this->filterBy = null;
    }

    public function setFilterBy($filterBy)
    {
        $this->filterBy = $filterBy;
    }

    public function getFilterBy()
    {
        return $this->filterBy;
    }

    public function get()
    {
        if($this->getFilterBy()) {
            $methodName = 'get' . ucwords($this->getFilterBy());
            $feed = $this->feedRepository->{$methodName}()->get();
        } else {
            $feed = $this->cache::remember(self::CACHE_NAME, $this->cacheMinutes, function() {
                return $this->feedRepository->getCollections()->get()
                    ->merge($this->feedRepository->getContributions()->get())
                    ->merge($this->feedRepository->getRatings()->get())
                    ->merge($this->feedRepository->getReviews()->get())
                    ->merge($this->feedRepository->getReviewFeedbacks()->get())
                    ->merge($this->feedRepository->getFollows()->get())
                    ->merge($this->feedRepository->getLikes()->get())
                    ->merge($this->feedRepository->getWants()->get());
            });
        }

        return $feed->sortByDesc('created_at');
    }

    public function isReviewPage()
    {
        return in_array($this->getFilterBy(), ['reviews', 'reviewFeedbacks']);
    }
}
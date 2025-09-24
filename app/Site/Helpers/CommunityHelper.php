<?php
namespace App\Site\Helpers;

use App\Site\Helpers\Site;
use App\Site\Repositories\CommunityRepository;

use Detection\MobileDetect;
use Illuminate\Support\Facades\Cache;

class CommunityHelper
{
    private $agent;
    private $cache;
    protected $communityRepository;

    public function __construct(
        Cache $cache,
        CommunityRepository $communityRepository,
        MobileDetect $agent
    ) {
        $this->agent = $agent;
        $this->cache = $cache;
        $this->communityRepository = $communityRepository;
    }

    public function getAnticipatedGames()
    {
        return $this->communityRepository->getAnticipatedGames($daysRange = 45, $total = $this->agent->isMobile() ? 4 : 7);
    }

    public function getCollections()
    {
        return $this->communityRepository->getCollections($total = $this->agent->isMobile() ? 4 : 7);
    }

    public function getContributions()
    {
        return $this->communityRepository->getContributions($total = $this->agent->isMobile() ? 5 : 10);
    }

    public function getDiscussions()
    {
        return $this->communityRepository->getDiscussions($total = $this->agent->isMobile() ? 4 : 6);
    }

    public function getPlayingNowGames()
    {
        return $this->communityRepository->getPlayingNowGames($daysRange = 7, $total = $this->agent->isMobile() ? 4 : 7);
    }

    public function getRatings()
    {
        return $this->communityRepository->getRatings($total = $this->agent->isMobile() ? 3 : 3);
    }

    public function getReviews()
    {
        return $this->communityRepository->getReviews($total = $this->agent->isMobile() ? 4 : 6);
    }

    public function getSpotlightUsers()
    {
        $cacheName = 'communitySpotlightUsers' . $this->agent->isMobile() ? 'Mobile' : 'Desktop';
        $cacheDuration = config('site.community_spotlight_users_cache_duration');

        return $this->cache::remember($cacheName, $cacheDuration, function() {
            $dateRange = now()->subDays(config('site.community_spotlight_users_days_range'));
            $totalUsers = config('site.community_spotlight_users_total' . ($this->agent->isMobile() ? '_mobile' : ''));

		    return $this->communityRepository->getSpotlightUsers($dateRange, $totalUsers, [
                Site::getOfficialUser()->id
            ]);
		});
    }
}
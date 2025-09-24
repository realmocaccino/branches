<?php
namespace App\Site\Helpers;

use App\Common\Dictionaries\FindDictionary;
use App\Common\Helpers\{EntityFinder, Support};
use App\Site\Models\{Characteristic, Criteria, Franchise, Genre, Mode, Platform, Publisher, Theme};
use App\Site\Repositories\DiscoverRepository;
use App\Site\Helpers\ListHelper;

use Illuminate\Cache\Repository as CacheRepository;
use MobileDetect;

class DiscoverHelper
{
    private const CACHE_KEYWORDS_DURATION = 60 * 60 * 24;
	private const CACHE_KEYWORDS_NAME = 'discover_keywords';
    private const DEFAULT_LIST_SLUG = 'hidden-gems';

    private $agent;
    private $cache;
    private $discoverRepository;
    private $entityFinder;
    private $listHelper;

    public function __construct(MobileDetect $agent, CacheRepository $cache, DiscoverRepository $discoverRepository, EntityFinder $entityFinder, ListHelper $listHelper)
    {
        $this->agent = $agent;
        $this->cache = $cache;
        $this->discoverRepository = $discoverRepository;
        $this->entityFinder = $entityFinder;
        $this->listHelper = $listHelper;
    }

    public function getAllKeywords()
    {
        $keywods = $this->cache->remember(self::CACHE_KEYWORDS_NAME, self::CACHE_KEYWORDS_DURATION, function() {
            $characteristics = Characteristic::withMoreThanHundredGames()->pluck(Support::getLocalizatedColumn(Characteristic::class, 'name'), 'slug');
            $genres = Genre::pluck(Support::getLocalizatedColumn(Genre::class, 'name'), 'slug');
            $modes = Mode::pluck(Support::getLocalizatedColumn(Mode::class, 'name'), 'slug');
            $platforms = Platform::withMoreThanHundredGames()->pluck('name', 'slug');
            $themes = Theme::withMoreThanHundredGames()->pluck(Support::getLocalizatedColumn(Theme::class, 'name'), 'slug');
            $words = array_flip(FindDictionary::$words);

            return collect()
            ->merge($characteristics)
            ->merge($genres)
            ->merge($modes)
            ->merge($platforms)
            ->merge($themes)
            ->merge($words);
        });

        return $this->shuffleKeywords($keywods);
    }

    public function getDefaultList($limit)
    {
        return $this->listHelper->setSlug(self::DEFAULT_LIST_SLUG)->limit($limit)->get();
    }

    public function getGamesFromKeywords($keywords, $perPage)
    {
        if(!$entities = $this->getEntitiesFromKeywords($keywords)) {
            return collect();
        }

        return $this->discoverRepository->getGamesFromEntities($entities)->when($this->agent->isMobile(), function($query) use($perPage) {
			return $query->simplePaginate($perPage);
		}, function($query) use($perPage) {
			return $query->paginate($perPage);
        })->appends(request()->query());
    }

    private function getEntitiesFromKeywords(array $keywords)
    {
        $entities = [];

        foreach($keywords as $keyword) {
            if($entity = $this->entityFinder->discover($keyword)) {
                $entities[$entity->getTable()][] = $entity->slug;
            }
        }

        return $entities;
    }

    public function getUserList($user)
    {
        $discoverableGames = $user->getDiscoverableGames();

        if ($discoverableGames->count()) {
            return $discoverableGames;
        }

        return null;
    }

    private function shuffleKeywords($keywords)
    {
        $keywords = $keywords->toArray();

        uksort($keywords, function() {
            return rand() - rand();
        });

        return collect($keywords);
    }
}
<?php
namespace App\Console\Actions\Misc;

use App\Common\Services\CacheService;
use App\Site\Models\{Criteria, Characteristic, Genre, Theme, Mode, Platform};
use App\Site\Helpers\{ListHelper, Site, TagHelper};

class CacheCategories
{
    private const EXCLUDED_THEMES = [
        'abstract'
    ];
    private const GAME_COVER_SIZE = '250x';

    private $cache;
    private $listHelper;
    private $tagHelper;

    private $cachePrefix;
    private $cacheThumbnailPrefix;
    private $totalYears;

    public function __construct(CacheService $cache, ListHelper $listHelper, TagHelper $tagHelper)
    {
        $this->cache = $cache;
        $this->listHelper = $listHelper;
        $this->tagHelper = $tagHelper;

        $this->cachePrefix = config('site.categories_cache_prefix');
        $this->cacheThumbnailPrefix = config('site.categories_thumbnail_cache_prefix');
        $this->totalYears = config('site.categories_total_years');
    }

    public function handle()
    {
        foreach ($this->getDefaultLists() as $slug => $name) {
            $this->cache->forgetThenRememberForever($this->createThumbnailCacheName('list', $slug), function() use ($slug) {
                return $this->getCover('list', $slug);
            });
        }

        foreach ($this->getYears() as $year) {
            $this->cache->forgetThenRememberForever($this->createThumbnailCacheName('year', $year), function() use ($year) {
                return $this->getCover('year', $year);
            });
        }

        foreach ($this->getByScore() as $slug => $score) {
            $this->cache->forgetThenRememberForever($this->createThumbnailCacheName('byScore', $slug), function() use ($slug) {
                return $this->getCover('list', $slug);
            });
        }

        foreach ($this->getCriterias() as $criteria) {
            $this->cache->forgetThenRememberForever($this->createThumbnailCacheName('criteria', $criteria->slug), function() use ($criteria) {
                return $this->getCover('criteria', $criteria->slug);
            });
        }

        foreach ($this->getCharacteristics() as $characteristic) {
            $this->cache->forgetThenRememberForever($this->createThumbnailCacheName('characteristic', $characteristic->slug), function() use ($characteristic) {
                return $this->getCover('characteristic', $characteristic->slug);
            });
        }

        foreach ($this->getGenres() as $genre) {
            $this->cache->forgetThenRememberForever($this->createThumbnailCacheName('genre', $genre->slug), function() use ($genre) {
                return $this->getCover('genre', $genre->slug);
            });
        }

        foreach ($this->getThemes() as $theme) {
            $this->cache->forgetThenRememberForever($this->createThumbnailCacheName('theme', $theme->slug), function() use ($theme) {
                return $this->getCover('theme', $theme->slug);
            });
        }

        foreach ($this->getModes() as $mode) {
            $this->cache->forgetThenRememberForever($this->createThumbnailCacheName('mode', $mode->slug), function() use ($mode) {
                return $this->getCover('mode', $mode->slug);
            });
        }

        foreach ($this->getPlatforms() as $platform) {
            $this->cache->forgetThenRememberForever($this->createThumbnailCacheName('platform', $platform->slug), function() use ($platform) {
                return $this->getCover('platform', $platform->slug);
            });
        }

        foreach ($this->getDefaultCollections() as $slug => $name) {
            $this->cache->forgetThenRememberForever($this->createThumbnailCacheName('collection', $slug), function() use ($slug) {
                return $this->getCover('collection', $slug);
            });
        }
    }

    private function getDefaultLists()
    {
        return $this->cache->forgetThenRememberForever($this->createCacheName('lists'), function() {
            return [
                'featured-games' => 'Jogos em Alta',
                'latest-releases' => 'Últimos Lançamentos',
                'next-releases' => 'Próximos Lançamentos',
                'most-anticipated-games' => 'Mais Aguardados',
                'best-games' => 'Mais Bem Avaliados',
                'acclaimed-games' => 'Jogos Renomados',
                'hidden-gems' => 'Jóias Inexploradas',
                'popular-games' => 'Jogos Populares',
                'classic-games' => 'Jogos Clássicos',
                'recently-added' => 'Incluídos Recentemente',
                'birthday-today' => 'Aniversário Hoje'
            ];
        });
    }

    private function getYears()
    {
        return $this->cache->forgetThenRememberForever($this->createCacheName('years'), function() {
            return range(date('Y'), date('Y') - $this->totalYears);
        });
    }

    private function getByScore()
    {
        return $this->cache->forgetThenRememberForever($this->createCacheName('byScore'), function() {
            return [
                'above-90' => 'Jogos Acima de 9.0',
                'above-95' => 'Jogos Acima de 9.5'
            ];
        });
    }

    private function getCriterias()
    {
        return $this->cache->forgetThenRememberForever($this->createCacheName('criterias'), function() {
            return Criteria::orderBy('name_pt')->get();
        });
    }

    private function getCharacteristics()
    {
        return $this->cache->forgetThenRememberForever($this->createCacheName('characteristics'), function() {
            return Characteristic::withMoreThanHundredGames()->orderBy('name_pt')->get();
        });
    }

    private function getGenres()
    {
        return $this->cache->forgetThenRememberForever($this->createCacheName('genres'), function() {
            return Genre::orderBy('name_pt')->get();
        });
    }

    private function getThemes()
    {
        return $this->cache->forgetThenRememberForever($this->createCacheName('themes'), function() {
            return Theme::withMoreThanHundredGames()->whereNotIn('slug', self::EXCLUDED_THEMES)->orderBy('name_pt')->get();
        });
    }

    private function getModes()
    {
        return $this->cache->forgetThenRememberForever($this->createCacheName('modes'), function() {
            return Mode::orderBy('name_pt', 'desc')->get();
        });
    }

    private function getPlatforms()
    {
        return $this->cache->forgetThenRememberForever($this->createCacheName('platforms'), function() {
            return Platform::withMoreThanHundredGames()->inRelevantOrder()->get();
        });
    }

    private function getDefaultCollections()
    {
        return $this->cache->forgetThenRememberForever($this->createCacheName('collections'), function() {
            return Site::getOfficialUser()->collections()->notPrivate()->pluck('name', 'slug')->all();
        });
    }

    private function createCacheName($item)
    {
        return sprintf('%s%s', $this->cachePrefix, $item);
    }

    private function createThumbnailCacheName($tag, $slug)
    {
        return sprintf('%s%s_%s', $this->cacheThumbnailPrefix, $tag, $slug);
    }

	private function getCover($tag, $slug)
	{
        if ($tag == 'collection') {
            $collection = Site::getOfficialUser()->collections()->onlyCustom()->whereSlug($slug)->first();

            if ($collection and $collection->games()->count()) {
                return $collection->games()->first()->getCover(self::GAME_COVER_SIZE);
            }

            return null;
        } elseif ($tag == 'list') {
            $list = $this->listHelper->setSlug($slug)->perPage(1);
        } else {
            $list = $this->tagHelper->getList($tag, $slug, $perPage = 1);
        }

		if($cover = $list->getCover(self::GAME_COVER_SIZE)) {
			return $cover;
		}

		return null;
	}
}
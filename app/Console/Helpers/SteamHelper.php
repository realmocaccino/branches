<?php
namespace App\Console\Helpers;

use App\Console\Crawlers\{SteamCrawler, SteamSpyCrawler};
use App\Console\Services\SteamCatalogService;
use App\Site\Models\Game;

use Carbon;
use InvalidArgumentException, StdClass;

class SteamHelper
{
    private const COVER_URL = 'https://cdn.akamai.steamstatic.com/steam/apps/%APPID%/hero_capsule.jpg';
    private const DEFAULT_LANGUAGE = 'en';
    private const ENTITY_SEPARATOR = ', ';
    private const IGNORE_IN_CLASSIFICATION_URL = [
        'https://store.akamai.steamstatic.com',
        'https://store.cloudflare.steamstatic.com',
        '/public/shared/images/game_ratings/DEJUS/',
        '.png'
    ];
    private const RELEASE_DATE_FORMAT = 'd M, Y';
    private const SCREENSHOT_SIZE_STRING_TO_REMOVE = '.116x65';

    private $steamCatalogService;
    private $steamCrawler;
    private $steamCrawlerLocalized;
    private $steamSpyCrawler;

	public function __construct(
        SteamCatalogService $steamCatalogService,
        SteamCrawler $steamCrawler,
        SteamCrawler $steamCrawlerLocalized,
        SteamSpyCrawler $steamSpyCrawler
    ) {
        $this->steamCatalogService = $steamCatalogService;
        $this->steamCrawler = $steamCrawler->setLanguage(self::DEFAULT_LANGUAGE);
        $this->steamCrawlerLocalized = $steamCrawlerLocalized;
        $this->steamSpyCrawler = $steamSpyCrawler;
	}

    public function setGame(Game $game)
    {
        $this->steamCrawler->fromGame($game);
        $this->steamCrawlerLocalized->fromGame($game);
        $this->steamSpyCrawler->fromGame($game);

        return $this;
    }

    public function setGameByName(string $name)
    {
        $this->steamCrawler->fromName($name);
        $this->steamCrawlerLocalized->fromName($name);
        $this->steamSpyCrawler->fromName($name);

        return $this;
    }

    public function setGameById(int $id)
    {
        $this->steamCrawler->fromAppId($id);
        $this->steamCrawlerLocalized->fromAppId($id);
        $this->steamSpyCrawler->fromAppId($id);

        return $this;
    }

    public function setLanguage(string $language)
    {
        $this->steamCrawlerLocalized->setLanguage($language);

        return $this;
    }

    public function getGame($id, $fields)
    {
        $this->setGameById($id);

        $data = new StdClass;

        foreach($fields as $field) {
            $data->$field = $this->callMethod($field);
        }

        return $data;
    }

    private function callMethod($field)
    {
        $methodName = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));

        return $this->{$methodName}();
    }

    public function getClassification()
    {
        if($classification = $this->steamCrawlerLocalized->getClassification()) {
            $classification = str_replace(self::IGNORE_IN_CLASSIFICATION_URL, '', $classification);

            return SteamTagsHelper::matchClassification($classification);
        }

        return null;
    }

    public function getCover()
    {
        return str_replace('%APPID%', $this->steamCrawler->getAppId(), self::COVER_URL);
    }

    public function getDescription()
    {
        return $this->steamCrawlerLocalized->getDescription();
    }

    public function getDevelopers()
    {
        return explode(self::ENTITY_SEPARATOR, $this->steamSpyCrawler->getDevelopers());
    }

    public function getModes()
    {
        return SteamTagsHelper::matchModes($this->steamCrawler->getFeatures());
    }

    public function getName()
    {
        return $this->steamCrawler->getName();
    }

    public function getPlatforms()
    {
        return SteamTagsHelper::matchPlatforms($this->steamCrawler->getPlatforms());
    }

    public function getPublishers()
    {
        return explode(self::ENTITY_SEPARATOR, $this->steamSpyCrawler->getPublishers());
    }

    public function getReleaseDate()
    {
        try {
            if($dateString = $this->steamCrawler->getReleaseDate()) {
                return Carbon::createFromFormat(self::RELEASE_DATE_FORMAT, $dateString);
            }
        } catch(InvalidArgumentException $exception) {}

        return null;
    }

    public function getScreenshots()
    {
        return array_map(function($screenshot) {
            return str_replace(self::SCREENSHOT_SIZE_STRING_TO_REMOVE, null, $screenshot);
        }, $this->steamCrawler->getScreenshots());
    }

    public function getTags()
    {
        $tags = [];

        if($tags = $this->steamSpyCrawler->getTags()) {
            $tags = SteamTagsHelper::filterIrrelevantTagsByScore($tags); 
        } elseif($tags = $this->steamCrawler->getTags()) {
            $tags = SteamTagsHelper::filterIrrelevantTagsByPosition($tags);
        }

        return (object) [
            'characteristics' => SteamTagsHelper::matchCharacteristics($tags),
            'collections' => SteamTagsHelper::matchCollections($tags),
            'genres' => SteamTagsHelper::matchGenres($tags),
            'themes' => SteamTagsHelper::matchThemes($tags)
        ];
    }

    public function provideGamesToChoose($term, $total)
    {
        return $this->steamCatalogService->provideGamesToChoose($term, $total);
    }
}
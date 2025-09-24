<?php
namespace App\Console\Crawlers;

use App\Console\Services\SteamCatalogService;
use App\Site\Models\Game;

class SteamCrawler
{
    const BASE_URL = 'https://store.steampowered.com/app/';

    private $appId;
    private $crawler;
    private $steamCatalogService;

    public function __construct(BaseCrawler $crawler, SteamCatalogService $steamCatalogService)
    {
        $this->crawler = $crawler;
        $this->steamCatalogService = $steamCatalogService;
    }

    private function buildUrl(int $appId)
    {
        $this->appId = $appId;

        return self::BASE_URL . $appId;
    }

    public function fromAppId(int $appId)
    {
        $this->setAppId($appId);

        $this->crawler->setUrl($this->buildUrl($this->appId));

        return $this;
    }

    public function fromGame(Game $game)
    {
        $this->setAppId($this->steamCatalogService->getAppIdByName($game->name));

        $this->crawler->setUrl($this->buildUrl($this->appId));

        return $this;
    }

    public function fromName(string $name)
    {
        $this->setAppId($this->steamCatalogService->getAppIdByName($name));

        $this->crawler->setUrl($this->buildUrl($this->appId));

        return $this;
    }

    private function setAppId(int $appId)
    {
        $this->appId = $appId;
    }

    public function getAppId()
    {
        return $this->appId;
    }

    public function getName()
    {
        $text = $this->crawler->getContentFromElement('#appHubAppName');
        
        return $this->crawler->handleText($text);
    }

    public function getClassification()
    {
        $text = $this->crawler->getContentFromElement('.game_rating_icon img', 'src');
        
        return $this->crawler->handleText($text);
    }

    public function getDescription()
    {
        $text = $this->crawler->getContentFromElement('.game_description_snippet');
        
        return $this->crawler->handleText($text);
    }

    public function getFeatures()
    {
        $text = $this->crawler->getContentFromElement('.game_area_features_list_ctn');

        return $this->crawler->handleText($text);
    }

    public function getPlatforms()
    {
        return $this->crawler->getContentFromAllElements('.sysreq_content', 'data-os');
    }

    public function getReleaseDate()
    {
        $text = $this->crawler->getContentFromElement('.date');

        return $this->crawler->handleText($text);
    }

    public function getScreenshots()
    {
        return $this->crawler->getContentFromAllElements('.highlight_strip_screenshot img', 'src');
    }

    public function getTags()
    {
        $text = $this->crawler->getContentFromElement('.popular_tags');

        return $this->handleTextIntoTags($text);
    }

    private function handleTextIntoTags($text)
    {
        $text = preg_replace('/[\+\r\t ]+/', ' ', $text);

        return array_values(array_filter(array_map('trim', explode("\n", $text))));
    }

    public function setLanguage(string $language)
    {
        $this->crawler->setLanguage($language);

        return $this;
    }
}
<?php
namespace App\Console\Crawlers;

use App\Console\Services\SteamCatalogService;
use App\Site\Models\Game;

class SteamSpyCrawler
{
    const BASE_URL = 'https://steamspy.com/api.php?request=appdetails&appid=';

    private $appId;
    private $crawler;
    private $steamCatalogService;

    public function __construct(JsonCrawler $crawler, SteamCatalogService $steamCatalogService)
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
        return $this->crawler->query('name');
    }

    public function getDevelopers()
    {
        return $this->crawler->query('developer');
    }

    public function getPublishers()
    {
        return $this->crawler->query('publisher');
    }

    public function getTags()
    {
        return (array) $this->crawler->query('tags');
    }
}
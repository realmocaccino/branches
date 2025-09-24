<?php
namespace App\Console\Crawlers;

use App\Site\Models\Game;

class ReleasesCrawler
{
    const BASE_URL = 'https://www.releases.com/p/';

    private $crawler;

    public function __construct(BaseCrawler $crawler)
    {
        $this->crawler = $crawler;
    }

    private function buildUrl(string $slug)
    {
        return self::BASE_URL . $slug;
    }

    public function fromGame(Game $game)
    {
        $url = $this->buildUrl($game->slug);

        $this->crawler->setUrl($url);

        return $this;
    }

    public function getReleaseDate()
    {
        $text = $this->crawler->getContentFromElement('.date');
        
        return $this->crawler->handleText($text);
    }

    public function getStatus()
    {
        $text = $this->crawler->getContentFromElement('.status');
        
        return $this->crawler->handleText($text);
    }
}
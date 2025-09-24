<?php
namespace App\Console\Crawlers;

use App\Console\Dictionaries\MetacriticDictionary;
use App\Site\Models\Game;

class MetacriticCrawler
{
    const BASE_URL = 'https://www.metacritic.com/game/';

    private $crawler;
    private $text;

	public function __construct(BaseCrawler $crawler)
	{
        $this->crawler = $crawler;
	}

    public function fromGame(Game $game)
    {
        $this->crawler->setUrl($this->buildUrl($game));

        return $this;
    }

    public function fromUrl(string $url)
    {
        $this->crawler->setUrl($url);

        return $this;
    }

    public function getScore()
    {
        $score = $this->crawler->getContentFromElement('.c-productHero_scoreInfo .c-siteReviewScore');

        return $this->treatScore($score);
    }

    public function getTotal()
    {
        $totalText = $this->crawler->getContentFromElement('.c-productHero_scoreInfo .c-productScoreInfo_reviewsTotal');

        return $this->getNumberFromText($totalText);
    }

    private function buildUrl(Game $game)
    {
        return self::BASE_URL . $game->slug . '/';
    }

    private function treatScore($score)
    {
        return ctype_digit($score) ? $score / 10 : null;
    }

    private function getNumberFromText($text)
    {
        if (preg_match($pattern = '/\d+/', $text, $matches)) {
            return $matches[0];
        }

        return null;
    }
}
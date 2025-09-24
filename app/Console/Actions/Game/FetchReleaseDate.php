<?php
namespace App\Console\Actions\Game;

use App\Site\Models\Game;
use App\Console\Crawlers\{ReleasesCrawler, SteamCrawler};
use App\Console\Exceptions\{ApiNoResponseException, ReleaseDateNotFoundException};
use App\Console\Helpers\ReleasesHelper;

use Carbon;

class FetchReleaseDate
{
	protected $game;
	protected $date;
	protected $crawler;
    protected $helper;
    protected $steamCrawler;
	
	public function __construct(ReleasesCrawler $crawler, ReleasesHelper $helper, SteamCrawler $steamCrawler)
    {
        $this->crawler = $crawler;
        $this->helper = $helper;
        $this->steamCrawler = $steamCrawler;
    }

    public function setGame(Game $game)
    {
        $this->crawler->fromGame($game);
        $this->steamCrawler->fromGame($game);
        $this->game = $game;

        return $this;
    }
    
    public function crawl()
    {
        $dateString = $this->crawlFromReleases() ?? $this->crawlFromSteam();

        if($dateString) {
            $this->setDate($dateString);
        } else {
            throw new ReleaseDateNotFoundException('Data de lançamento não encontrada ou confirmada');
        }
    }

    private function crawlFromReleases()
    {
        try {
            if($this->helper->isValid($dateString = $this->crawler->getReleaseDate(), $this->crawler->getStatus())) {
                return $dateString;
            }

            return null;
        } catch(ApiNoResponseException $exception) {
            return null;
        }
    }

    private function crawlFromSteam()
    {
        if($this->helper->isValidForSteam($dateString = $this->steamCrawler->getReleaseDate())) {
            return $dateString;
        }

        return null;
    }

    public function getDate($format = 'Y-m-d')
    {
        return $this->date ? $this->date->format($format) : null;
    }
    
    protected function setDate($dateString)
    {
        $this->date = Carbon::parse($dateString);
    }
    
    public function save()
    {
        $this->game->release = $this->getDate();
        $this->game->save();
    }
}
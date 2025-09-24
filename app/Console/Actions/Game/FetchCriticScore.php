<?php
namespace App\Console\Actions\Game;

use App\Console\Crawlers\MetacriticCrawler;
use App\Console\Exceptions\NoGameSetException;
use App\Site\Models\Game;

class FetchCriticScore
{
	private $crawler, $game, $url;

	public function __construct(MetaCriticCrawler $crawler)
	{
		$this->crawler = $crawler;
	}

    public function setGame(Game $game)
    {
        $this->game = $game;

        return $this;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }
	
    public function fetch()
    {
        if(!$this->game) {
            throw new NoGameSetException('Jogo não informado' . PHP_EOL);
        }
        
        if($this->url) {
            $this->crawler->fromUrl($this->url);
        } else {
            $this->crawler->fromGame($this->game);
        }

        if($this->crawler->getScore()) {
            $this->game->timestamps = false;
            $this->game->critic_score = $this->crawler->getScore();
            $this->game->total_critic_ratings = $this->crawler->getTotal();
            $this->game->save();
            return true;
        }

        return false;
    }
}
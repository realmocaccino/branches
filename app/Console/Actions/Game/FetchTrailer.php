<?php
namespace App\Console\Actions\Game;

use App\Common\Helpers\Support;
use App\Console\Exceptions\NoGameSetException;
use App\Console\Helpers\YoutubeHelper;
use App\Site\Models\Game;

class FetchTrailer
{
	private $game;
    private $url;
    private $youtubeHelper;

    const TERMS_TO_SEARCH_ON_YOUTUBE = [
        'launch',
        'release',
        'trailer',
        'game'
    ];

	public function __construct(YoutubeHelper $youtubeHelper)
	{
        $this->youtubeHelper = $youtubeHelper;
	}

    public function setGame(Game $game)
    {
        $this->game = $game;

        return $this;
    }

    public function setUrl(?string $url)
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
            $videoId = Support::extractIdFromYoutubeURL($this->url);
        } else {
            $videoId = $this->searchFromYoutube();
        }

        if($videoId) {
            $this->game->trailer = $videoId;
            $this->game->save();
            return true;
        }
        
        return false;
    }

    private function searchFromYoutube()
    {
        $videos = $this->youtubeHelper->searchVideos(
            [$this->game->name] + self::TERMS_TO_SEARCH_ON_YOUTUBE
        );

        if($video = $this->getRelevantVideo($videos)) {
            return $video['id']['videoId'];
        }

        return null;
    }

    private function getRelevantVideo($videos)
    {
        foreach($videos as $video) {
            if(strstr($video['snippet']['title'], $this->game->name)) {
                return $video;
            }
        }

        return false;
    }
}
<?php
namespace App\Console\Helpers;

use App\Console\Clients\IgdbClient;
use App\Common\Helpers\Support;

class IgdbHelper
{
    private $client;

	public function __construct(IgdbClient $igdbClient)
	{
	    $this->client = $igdbClient;
	}

    public function getGameById($id, $fields = [])
    {
        $limit = 1;

        $game = $this->client->request('games', $fields, $limit, 'id = ' . $id);

        return $game ? $game[0] : null;
    }

    public function getGameBySlug($slug, $fields = [])
    {
        $limit = 1;

        $game = $this->client->request('games', $fields, $limit, 'slug = "' . $slug . '"');

        return $game ? $game[0] : null;
    }

    public function getGameCover($gameSlug)
    {
        $game = $this->getGameBySlug($gameSlug, [
            'cover.url'
        ]);

        if(isset($game->cover->url)) {
            return $this->replaceToLargerCover($game->cover->url);
        }

        return null;
    }

    public function getGameReleaseDate($gameSlug)
    {
        $game = $this->getGameBySlug($gameSlug, [
            'first_release_date'
        ]);

        if(isset($game->first_release_date)) {
            return $game->first_release_date;
        }

        return null;
    }

    public function getGameScreenshots($gameSlug, $total = 20)
    {
        $game = $this->getGameBySlug($gameSlug, [
            'screenshots.url'
        ]);
        
        if(isset($game->screenshots)) {
            return array_slice(array_map(function($screenshot) {
                return $this->replaceToLargerCover($screenshot->url, 't_original');
            }, $game->screenshots), 0, $total);
        }

        return [];
    }

    public function matchModes($modes, $multiplayerModes)
    {
        $slugs = [];

        foreach($modes as $mode) {
            switch($mode) {
                case 'Single player':
                    $slugs[] = 'single-player';
                break;
                case 'Multiplayer':
                    if(empty($multiplayerModes) or !$this->hasCooperativeModes($multiplayerModes)) {
                        $slugs[] = 'online-competitive';
                    }
                break;
                case 'Co-operative':
                    if(empty($multiplayerModes)) {
                        $slugs[] = 'online-co-op';
                    } else {
                        $this->addCooperativeSlugs($multiplayerModes, $slugs);
                    }
                break;
                case 'Split screen':
                    if(empty($multiplayerModes) or !$this->hasCooperativeModes($multiplayerModes)) {
                        $slugs[] = 'online-co-op';
                    }
                break;
                case 'Massively Multiplayer Online (MMO)':
                    $slugs[] = 'mmo';
                break;
            }
        }

        return array_unique($slugs);
    }

    public function provideGamesToChoose($term, $total)
    {
        $games = $this->client->request('games', ['id', 'name', 'first_release_date'], $total, null, '"' . $term . '"');

        if($games) {
            foreach($games as $key => $game) {
                if(property_exists($game, 'first_release_date') and $game->first_release_date) {
                    $releaseYear = Support::unixTimestampToDate($game->first_release_date, 'Y');
                    $game->nameWithReleaseYear = $game->name . ' (' . $releaseYear . ')';
                    unset($game->first_release_date);
                } else {
                    $game->nameWithReleaseYear = $game->name;
                }
            }
            return $games;
        }

        return [];
    }

    public function replaceToLargerCover($url, $newSize = 't_1080p')
    {
        return 'https://' . ltrim(str_replace('t_thumb', $newSize, $url), '//');
    }

    private function addCooperativeSlugs($multiplayerModes, &$slugs)
    {
        foreach($multiplayerModes as $multiplayerMode) {
            if($multiplayerMode->offlinecoop) {
                $slugs[] = 'couch-co-op';
            }
            if($multiplayerMode->onlinecoop) {
                $slugs[] = 'online-co-op';
            }
        }
    }

    private function hasCooperativeModes($multiplayerModes)
    {
        foreach($multiplayerModes as $multiplayerMode) {
            if($multiplayerMode->offlinecoop or $multiplayerMode->onlinecoop) {
                return true;
            }
        }

        return false;
    }
}
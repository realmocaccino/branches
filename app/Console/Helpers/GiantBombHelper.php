<?php
namespace App\Console\Helpers;

use App\Console\Dictionaries\GiantBombDictionary;
use App\Console\Clients\GiantBombClient;
use App\Site\Models\Platform;

use DateTime, DateInterval, DatePeriod;

class GiantBombHelper
{
    private $client;

    private const TOTAL_UPCOMING_GAMES = 20;
    private const TOTAL_UPCOMING_MONTHS = 2;

	public function __construct(GiantBombClient $client)
	{
        $this->client = $client;
	}

    private function fieldsListToQueryString($fields = [])
    {
        return ($fields) ? 'field_list=' . implode(',', $fields) : null;
    }

    private function filtersListToQueryString($filters = [])
    {
        return ($filters) ? 'filter=' . implode(',', array_map(function($filter, $value) {
                return $filter . ':' . $value;
            }, array_keys($filters), $filters)) : null;
    }

    private function sortsListToQueryString($sorts = [])
    {
        return ($sorts) ? 'sort=' . implode(',', array_map(function($sortField, $sortOrder) {
                return $sortField . ':' . $sortOrder;
            }, array_keys($sorts), $sorts)) : null;
    }
	
	public function getUpcomingGames()
    {
        $games = [];

        $now = new DateTime(date('Y-m'));
        $interval = new DateInterval('P1M');
        $period = new DatePeriod($now, $interval, self::TOTAL_UPCOMING_MONTHS);

        $this->client->setLimit(self::TOTAL_UPCOMING_GAMES);

        foreach ($period as $date) {
            $filters = [
                'expected_release_year' => $date->format('Y'),
                'expected_release_month' => ltrim($date->format('m'), 0)
            ];
            $games += $this->client->request('games', $this->filtersListToQueryString($filters) . '&' . $this->sortsListToQueryString(['expected_release_day', 'asc']));
        }

        return $games;
    }
	
	public function getGame($gameId, $fields = [])
	{
		$game = $this->client->request('game/' . $gameId, $this->fieldsListToQueryString($fields));
		
		return $game;
	}
	
	public function getGameReleaseDate($releaseId)
	{
		$release = $this->client->request('release/' . $releaseId);

		return $release->release_date ?? null;
	}

    public function provideGamesToChoose($term, $total)
    {
        $games = $this->searchGames($term, $total, ['id', 'name', 'original_release_date']);

        if($games) {
            foreach($games as $game) {
                if(property_exists($game, 'resource_type'))unset($game->resource_type);
                if(property_exists($game, 'original_release_date') and $game->original_release_date) {
                    $releaseYear = substr($game->original_release_date, 0, 4);
                    $game->nameWithReleaseYear = $game->name . ' (' . $releaseYear . ')';
                    unset($game->original_release_date);
                } else {
                    $game->nameWithReleaseYear = $game->name;
                }
            }
            return $games;
        }

        return [];
    }
	
	public function searchGames($term, $limit, $fields = [])
	{
		$games = $this->client->setLimit($limit)->request('search', 'query=' . urlencode($term) . '&resources=game&' . $this->fieldsListToQueryString($fields));
		
		return $games;
	}

    public function matchCharacteristics($characteristics)
    {
        $slugs = [];

        foreach(array_column($characteristics, 'name') as $name) {
            if(isset(GiantBombDictionary::CHARACTERISTICS[$name])) {
                $slugs[] = GiantBombDictionary::CHARACTERISTICS[$name];
            }
        }

        return $slugs;
    }

    public function matchGenres($genres)
    {
        $slugs = [];

        foreach(array_column($genres, 'name') as $name) {
            if(isset(GiantBombDictionary::GENRES[$name])) {
                $slugs[] = GiantBombDictionary::GENRES[$name];
            }
        }

        return $slugs;
    }

    public function matchPlatforms($platforms)
    {
        $slugs = [];

        $availablePlatforms = array_merge(GiantBombDictionary::PLATFORMS, Platform::pluck('slug', 'name')->toArray());

        foreach(array_column($platforms, 'name') as $name) {
            if(isset($availablePlatforms[$name])) {
                $slugs[] = $availablePlatforms[$name];
            }
        }

        return $slugs;
    }

    public function matchThemes($themes)
    {
        $slugs = [];

        foreach(array_column($themes, 'name') as $name) {
            if(isset(GiantBombDictionary::THEMES[$name])) {
                $slugs[] = GiantBombDictionary::THEMES[$name];
            }
        }

        return $slugs;
    }
}

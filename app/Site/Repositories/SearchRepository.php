<?php
namespace App\Site\Repositories;

use App\Site\Models\{Franchise, Game, User};

class SearchRepository
{
    protected $franchise;
    protected $game;
    protected $user;

    public function __construct(Franchise $franchise, Game $game, User $user)
    {
        $this->franchise = $franchise;
        $this->game = $game;
        $this->user = $user;
    }

    public function getFranchise($termWithoutVersion)
    {
        return $this->franchise
        ->where('name', 'LIKE', '%' . $termWithoutVersion . '%')
        ->orWhere('alias', 'LIKE', '%' . $termWithoutVersion . '%')
        ->first();
    }

    public function getGamesQuery($term, $termInRoman, $termOfFranchise)
    {
        return $this->game
        ->select('games.*')
		->where(function($query) use ($term, $termInRoman, $termOfFranchise) {
			$query
				->where('games.name', 'LIKE', '%' . str_replace(' ', '%', $term) . '%')
				->orWhere('games.alias', 'LIKE', '%' . str_replace(' ', '%', $term) . '%');
			if($termInRoman) {
				$query
					->orWhere('games.name', 'LIKE', '%' . str_replace(' ', '%', $termInRoman) . '%')
					->orWhere('games.alias', 'LIKE', '%' . str_replace(' ', '%', $termInRoman) . '%');
			}
			if($termOfFranchise) {
				$query
					->orWhere('games.name', 'LIKE', '%' . str_replace(' ', '%', $termOfFranchise) . '%')
					->orWhere('games.alias', 'LIKE', '%' . str_replace(' ', '%', $termOfFranchise) . '%');
			}
		})
        ->orderByRaw("
            CASE
                WHEN REPLACE(games.name, '\'', '') = '" . $this->escape($term) . "' THEN 1
                WHEN REPLACE(games.alias, '\'', '') = '" . $this->escape($term) . "' THEN 2
                WHEN REPLACE(games.name, '\'', '') REGEXP '\\\\b" . $this->escape($term) . "\\\\b' THEN 3
                WHEN REPLACE(games.alias, '\'', '') REGEXP '\\\\b" . $this->escape($term) . "\\\\b' THEN 4
                ELSE 5
            END,
            games.`release` DESC, games.name"
        );
    }

    public function getUsersQuery($term)
    {
        return $this->user->where('slug', 'LIKE', '%' . $term . '%');
    }

    private function escape($string)
	{
		return str_replace("'", "\'", $string);
	}
}
<?php
namespace App\Site\Repositories;

use App\Site\Models\Game;

class GameRepository
{
    protected $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function doesItAlreadyExist(string $name, ?int $releaseYear, int $idToExclude = null)
    {
        return $this->game
        ->whereName($name)
        ->when($idToExclude, function ($query) use ($idToExclude) {
            return $query->where('id', '!=', $idToExclude);
        })
        ->when($releaseYear, function ($query) use ($releaseYear) {
            return $query->whereYear('release', $releaseYear);
        }, function ($query) {
            return $query->whereNull('release');
        })
        ->first();
    }

    public function doesItAlreadyExistByName(string $name, int $idToExclude = null)
    {
        return $this->game
        ->whereName($name)
        ->when($idToExclude, function ($query) use ($idToExclude) {
            return $query->where('id', '!=', $idToExclude);
        })
        ->first();
    }
}
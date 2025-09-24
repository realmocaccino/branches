<?php
namespace App\Site\Repositories;

use App\Site\Models\Game;

class DiscoverRepository
{
    protected $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function getGamesFromEntities($entities)
    {
        return $this->game
        ->selectRaw('games.*, total_ratings + total_reviews as popularity')
        ->when(isset($entities['genres']), function ($query) use ($entities) {
            return $query->whereHas('genres', function ($query) use ($entities) {
                return $query
                    ->whereIn('slug', $entities['genres'])
                    ->selectRaw('COUNT(DISTINCT game_genre.id) AS total_genres')->having('total_genres', '=', count($entities['genres']));
            });
        })
        ->when(isset($entities['themes']), function ($query) use ($entities) {
            return $query->whereHas('themes', function ($query) use ($entities) {
                return $query
                    ->whereIn('slug', $entities['themes'])
                    ->selectRaw('COUNT(DISTINCT game_theme.id) AS total_themes')->having('total_themes', '=', count($entities['themes']));
            });
        })
        ->when(isset($entities['characteristics']), function ($query) use ($entities) {
            return $query->whereHas('characteristics', function($query) use($entities) {
                return $query
                    ->whereIn('slug', $entities['characteristics'])
                    ->selectRaw('COUNT(DISTINCT characteristic_game.id) AS total_characteristics')->having('total_characteristics', '=', count($entities['characteristics']));
            });
        })
        ->when(isset($entities['modes']), function ($query) use ($entities) {
            return $query->whereHas('modes', function($query) use($entities) {
                return $query
                    ->whereIn('slug', $entities['modes'])
                    ->selectRaw('COUNT(DISTINCT game_mode.id) AS total_modes')->having('total_modes', '=', count($entities['modes']));
            });
        })
        ->when(isset($entities['platforms']), function ($query) use ($entities) {
            return $query->whereHas('platforms', function($query) use($entities) {
                return $query->whereIn('slug', $entities['platforms']);
            });
        })
        ->when(isset($entities['criterias']), function ($query) use ($entities) {
            return $query->whereHas('criterias', function($query) use($entities) {
                return $query->whereIn('slug', $entities['criterias'])
                    ->where('criteria_game.score', '>=', config('site.list_score_for_criteria'))
                    ->where('total_ratings', '>=', config('site.minimum_ratings_to_rank'))
                    ->where('games.release', '>=', config('site.classic_game_date'));
            });
        })
        ->where('release', '<=', today())
        ->when(isset($entities['criterias']), function ($query) {
            return $query->orderByRaw('score DESC, YEAR(games.release) DESC');
        }, function($query) {
            return $query->orderByRaw('popularity DESC, YEAR(games.release) DESC');
        });
    }
}
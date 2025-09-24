<?php
namespace App\Site\Repositories;

use App\Site\Models\Platform;

use Illuminate\Support\Facades\DB;

class FilterRepository
{
    protected $minimumRatingsToRank;

    public function __construct()
    {
        $this->minimumRatingsToRank = config('site.minimum_ratings_to_rank');
    }

    public function addCharacteristicsToQuery(&$query, $values)
    {
        $query
        ->selectRaw('COUNT(DISTINCT filter_characteristics.id) AS total_characteristics')
        ->join('characteristic_game as filter_characteristic_game', 'filter_characteristic_game.game_id', '=', 'games.id')
        ->join('characteristics as filter_characteristics', 'filter_characteristic_game.characteristic_id', '=', 'filter_characteristics.id')
        ->whereIn('filter_characteristics.slug', $values)
        ->having('total_characteristics', '=', count($values))
        ->groupBy('games.id');
    }

    public function addDevelopersToQuery(&$query, $values)
    {
        $query
        ->join('developer_game as filter_developer_game', 'filter_developer_game.game_id', '=', 'games.id')
        ->join('developers as filter_developers', 'filter_developer_game.developer_id', '=', 'filter_developers.id')
        ->whereIn('filter_developers.slug', $values);
    }

    public function addFranchisesToQuery(&$query, $values)
    {
        $query
        ->join('franchise_game as filter_franchise_game', 'filter_franchise_game.game_id', '=', 'games.id')
        ->join('franchises as filter_franchises', 'filter_franchise_game.franchise_id', '=', 'filter_franchises.id')
        ->whereIn('filter_franchises.slug', $values);
    }

    public function addGenresToQuery(&$query, $values)
    {
        $query
        ->selectRaw('COUNT(DISTINCT filter_genres.id) AS total_genres')
        ->join('game_genre as filter_genre_game', 'filter_genre_game.game_id', '=', 'games.id')
        ->join('genres as filter_genres', 'filter_genre_game.genre_id', '=', 'filter_genres.id')
        ->whereIn('filter_genres.slug', $values)
        ->having('total_genres', '=', count($values))
        ->groupBy('games.id');
    }

    public function addModesToQuery(&$query, $values)
    {
        $query
        ->selectRaw('COUNT(DISTINCT filter_modes.id) AS total_modes')
        ->join('game_mode as filter_mode_game', 'filter_mode_game.game_id', '=', 'games.id')
        ->join('modes as filter_modes', 'filter_mode_game.mode_id', '=', 'filter_modes.id')
        ->whereIn('filter_modes.slug', $values)
        ->having('total_modes', '=', count($values))
        ->groupBy('games.id');
    }

    public function addPlatformsToQuery(&$query, $values)
    {
        $query
        ->join('game_platform as filter_platform_game', 'filter_platform_game.game_id', '=', 'games.id')
        ->join('platforms', 'filter_platform_game.platform_id', '=', 'platforms.id')
        ->whereIn('platforms.slug', $values);
    }

    public function addPlatformsToQueryBasedOnRatings(&$query, $values)
    {
        $query
        ->join('platforms', 'ratings.platform_id', '=', 'platforms.id')
		->whereIn('platforms.slug', $values);
    }

    public function addPublishersToQuery(&$query, $values)
    {
        $query
        ->join('game_publisher as filter_publisher_game', 'filter_publisher_game.game_id', '=', 'games.id')
        ->join('publishers as filter_publishers', 'filter_publisher_game.publisher_id', '=', 'filter_publishers.id')
        ->whereIn('filter_publishers.slug', $values);
    }

    public function addThemesToQuery(&$query, $values)
    {
        $query
        ->selectRaw('COUNT(DISTINCT filter_themes.id) AS total_themes')
        ->join('game_theme as filter_theme_game', 'filter_theme_game.game_id', '=', 'games.id')
        ->join('themes as filter_themes', 'filter_theme_game.theme_id', '=', 'filter_themes.id')
        ->whereIn('filter_themes.slug', $values)
        ->having('total_themes', '=', count($values))
        ->groupBy('games.id');
    }

    public function filterByInitial(&$query, $initial)
    {
        $query->where('games.name', 'LIKE', $initial . '%');
    }

    public function orderBasedOnPlatform(&$query, $values)
    {
        $query
        ->selectRaw('COUNT(DISTINCT platforms.id) AS total_platforms, COUNT(filter_ratings.id) + COUNT(filter_reviews.id) AS popularity')
        ->leftJoin('ratings as filter_ratings', function($join) use($values) {
            $join->on('games.id', '=', 'filter_ratings.game_id');
            $join->whereIn('filter_ratings.platform_id', Platform::whereIn('slug', $values)->pluck('id'));
        })
        ->leftJoin('reviews as filter_reviews', 'filter_ratings.id', '=', 'filter_reviews.rating_id')
        ->orderBy('popularity', 'desc')
        ->orderBy('games.release', 'desc')
        ->having('total_platforms', '=', count($values))
        ->groupBy('games.id');
    }

    public function orderByNameAscendent(&$query)
    {
        $query
        ->orderBy('games.name', 'ASC');
    }

    public function orderByNameDescendent(&$query)
    {
        $query
        ->orderBy('games.name', 'DESC');
    }

    public function orderByReleaseAscendent(&$query)
    {
        $query
        ->orderBy(DB::raw("
            CASE
                WHEN games.release IS NOT NULL THEN 0
                ELSE 1
            END,
            games.release
        "), 'ASC');
    }

    public function orderByReleaseDescendent(&$query)
    {
        $query
        ->orderBy(DB::raw("
            CASE
                WHEN games.release <= CURDATE() AND games.release IS NOT NULL THEN 0
                ELSE 1
            END,
            games.release
        "), 'DESC');
    }

    public function orderByBestRated(&$query)
    {
        $query
        ->orderBy('ratings.score', 'DESC');
    }

    public function orderByWorstRated(&$query)
    {
        $query
        ->orderBy('ratings.score', 'ASC');
    }

    public function orderByBestRatedSettingColumns(&$query, $scoreColumn, $totalColumn)
    {
        $query
        ->orderBy(DB::raw("
            CASE
                WHEN $totalColumn >= " . $this->minimumRatingsToRank . " THEN 0
                ELSE 1
            END,
            $scoreColumn
        "), 'DESC')
        ->orderBy($totalColumn, 'DESC');
    }

    public function orderByWorstRatedSettingColumns(&$query, $scoreColumn, $totalColumn)
    {
        $query
        ->orderBy(DB::raw("
            CASE
                WHEN $scoreColumn != '' AND $totalColumn >= " . $this->minimumRatingsToRank . " THEN 0
                ELSE 1
            END,
            $scoreColumn
        "), 'ASC')
        ->orderBy($totalColumn, 'DESC');
    }
}
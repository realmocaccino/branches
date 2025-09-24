<?php
namespace App\Console\Repositories;

use App\Site\Models\Game;

class AwardsRepository
{
    protected $game;
    protected $limit;
    protected $minimumRatingsToRank;

    public function __construct(Game $game)
    {
        $this->game = $game;

        $this->limit = config('console.award_limit');
        $this->minimumRatingsToRank = config('site.minimum_ratings_to_rank');
    }

    private function baseQuery(string $dateReleaseStart, string $dateReleaseEnd)
    {
        return $this->game
            ->whereBetween('games.release', [$dateReleaseStart, $dateReleaseEnd])
            ->where('games.total_ratings', '>=', $this->minimumRatingsToRank)
            ->where('games.status', '=', 1)
            ->whereNull('games.deleted_at')
            ->take($this->limit);
    }

    public function getGames(string $dateReleaseStart, string $dateReleaseEnd)
    {
        return $this->baseQuery($dateReleaseStart, $dateReleaseEnd)
            ->select('games.*')
            ->orderBy('games.score', 'desc')
            ->orderBy('games.total_ratings', 'desc')
            ->get();
    }

    public function getGamesByCategory(string $dateReleaseStart, string $dateReleaseEnd, string $additionalSql)
    {
        return $this->baseQuery($dateReleaseStart, $dateReleaseEnd)
            ->select('games.*')
            ->leftJoin('characteristic_game', 'games.id', '=', 'characteristic_game.game_id')
            ->leftJoin('characteristics', 'characteristic_game.characteristic_id', '=', 'characteristics.id')
            ->leftJoin('game_genre', 'games.id', '=', 'game_genre.game_id')
            ->leftJoin('genres', 'game_genre.genre_id', '=', 'genres.id')
            ->leftJoin('game_theme', 'games.id', '=', 'game_theme.game_id')
            ->leftJoin('themes', 'game_theme.theme_id', '=', 'themes.id')
            ->leftJoin('game_platform', 'games.id', '=', 'game_platform.game_id')
            ->leftJoin('platforms', 'game_platform.platform_id', '=', 'platforms.id')
            ->leftJoin('game_mode', 'games.id', '=', 'game_mode.game_id')
            ->leftJoin('modes', 'game_mode.mode_id', '=', 'modes.id')
            ->whereRaw($additionalSql)
            ->groupBy('games.id')
            ->orderBy('games.score', 'desc')
            ->orderBy('games.total_ratings', 'desc')
            ->get();
    }

    public function getGamesByCriteria(string $dateReleaseStart, string $dateReleaseEnd, string $criteria)
    {
        return $this->baseQuery($dateReleaseStart, $dateReleaseEnd)
            ->selectRaw('games.*, criteria_game.score as score')
            ->join('criteria_game', 'games.id', '=', 'criteria_game.game_id')
            ->join('criterias', 'criteria_game.criteria_id', '=', 'criterias.id')
            ->where('criterias.slug', '=', $criteria)
            ->groupBy('games.id')
            ->orderBy('criteria_game.score', 'desc')
            ->orderBy('games.total_ratings', 'desc')
            ->get();
    }
}
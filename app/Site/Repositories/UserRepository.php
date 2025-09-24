<?php
namespace App\Site\Repositories;

use App\Site\Models\{Characteristic, Game, Genre, Theme, User};

class UserRepository
{
    public function getActivePremiumUsers()
    {
        return User::whereHas('subscriptions', function($query) {
            $query->where('expires_at', '>', now());
        })->get();
    }

    public static function getDiscoverableGames($userId, $total, $characteristics, $genres, $themes)
    {
        $characteristicsIdsString = $characteristics->isNotEmpty() ? $characteristics->pluck('id')->implode(',') : '0';
        $genresIdsString = $genres->isNotEmpty() ? $genres->pluck('id')->implode(',') : '0';
        $themesIdsString = $themes->isNotEmpty() ? $themes->pluck('id')->implode(',') : '0';

        return Game::select('games.*')
        ->selectRaw('COUNT(DISTINCT CASE WHEN characteristics.id IN (' . $characteristicsIdsString . ') THEN characteristics.id END) + 
                    COUNT(DISTINCT CASE WHEN genres.id IN (' . $genresIdsString . ') THEN genres.id END) +
                    COUNT(DISTINCT CASE WHEN themes.id IN (' . $themesIdsString . ') THEN themes.id END) AS total_occurrences')
        ->leftJoin('characteristic_game', 'games.id', '=', 'characteristic_game.game_id')
        ->leftJoin('characteristics', 'characteristic_game.characteristic_id', '=', 'characteristics.id')
        ->leftJoin('game_genre', 'games.id', '=', 'game_genre.game_id')
        ->leftJoin('genres', 'game_genre.genre_id', '=', 'genres.id')
        ->leftJoin('game_theme', 'games.id', '=', 'game_theme.game_id')
        ->leftJoin('themes', 'game_theme.theme_id', '=', 'themes.id')
        ->whereNotIn('games.id', function ($query) use ($userId) {
            $query->select('game_id')
                ->from('ratings')
                ->where('user_id', $userId);
        })
        ->whereNotIn('games.id', function ($query) use ($userId) {
            $query->select('game_id')
            ->from('collection_game')
            ->join('collections', 'collection_game.collection_id', '=', 'collections.id')
            ->where('collections.user_id', $userId)
            ->where('collections.slug', 'favorites');
        })
        ->where(function ($query) use ($characteristics, $genres, $themes) {
            return $query->whereIn('characteristics.id', $characteristics->pluck('id')->toArray())
                ->orWhereIn('genres.id', $genres->pluck('id')->toArray())
                ->orWhereIn('themes.id', $themes->pluck('id')->toArray());
        })
        ->groupBy('games.id')
        ->havingRaw('total_occurrences >= 3')
        ->orderByDesc('total_occurrences')
        ->orderBy('release', 'desc')
        ->limit($total)
        ->get();
    }

    public static function getFavoriteGenresByFavorites($userId, $total)
	{
		return Genre::selectRaw('genres.*, COUNT(collection_game.game_id) AS total_occurrences')
        ->join('game_genre', 'genres.id', '=', 'game_genre.genre_id')
        ->join('games', 'game_genre.game_id', '=', 'games.id')
        ->join('collection_game', 'games.id', '=', 'collection_game.game_id')
        ->join('collections', 'collection_game.collection_id', '=', 'collections.id')
        ->where('collections.user_id', $userId)
        ->where('collections.slug', 'favorites')
        ->groupBy('genres.id')
        ->orderByRaw('total_occurrences DESC')
        ->limit($total)
        ->get();
	}

    public static function getFavoriteGenresByRatings($userId, $score, $total)
	{
		return Genre::selectRaw('genres.*, COUNT(ratings.id) AS total_occurrences')
        ->join('game_genre', 'genres.id', '=', 'game_genre.genre_id')
        ->join('games', 'game_genre.game_id', '=', 'games.id')
        ->join('ratings', 'games.id', '=', 'ratings.game_id')
		->whereIn('ratings.id', function ($query) use ($userId, $score) {
            $query->select('id')
                ->from('ratings')
                ->where('user_id', $userId)
                ->where('score', '>=', $score);
        })
        ->groupBy('genres.id')
        ->orderByRaw('total_occurrences DESC')
        ->limit($total)
        ->get();
	}

    public static function getFavoriteCharacteristicsByFavorites($userId, $total)
	{
		return Characteristic::selectRaw('characteristics.*, COUNT(collection_game.game_id) AS total_occurrences')
        ->join('characteristic_game', 'characteristics.id', '=', 'characteristic_game.characteristic_id')
        ->join('games', 'characteristic_game.game_id', '=', 'games.id')
        ->join('collection_game', 'games.id', '=', 'collection_game.game_id')
        ->join('collections', 'collection_game.collection_id', '=', 'collections.id')
        ->where('collections.user_id', $userId)
        ->where('collections.slug', 'favorites')
        ->groupBy('characteristics.id')
        ->orderByRaw('total_occurrences DESC')
        ->limit($total)
        ->get();
	}

	public static function getFavoriteCharacteristicsByRatings($userId, $score, $total)
	{
		return Characteristic::selectRaw('characteristics.*, COUNT(ratings.id) AS total_occurrences')
        ->join('characteristic_game', 'characteristics.id', '=', 'characteristic_game.characteristic_id')
        ->join('games', 'characteristic_game.game_id', '=', 'games.id')
        ->join('ratings', 'games.id', '=', 'ratings.game_id')
		->whereIn('ratings.id', function ($query) use ($userId, $score) {
            $query->select('id')
                ->from('ratings')
                ->where('user_id', $userId)
                ->where('score', '>=', $score);
        })
        ->groupBy('characteristics.id')
        ->orderByRaw('total_occurrences DESC')
        ->limit($total)
        ->get();
	}

	public static function getFavoriteThemesByFavorites($userId, $total)
	{
		return Theme::selectRaw('themes.*, COUNT(collection_game.game_id) AS total_occurrences')
        ->join('game_theme', 'themes.id', '=', 'game_theme.theme_id')
        ->join('games', 'game_theme.game_id', '=', 'games.id')
        ->join('collection_game', 'games.id', '=', 'collection_game.game_id')
        ->join('collections', 'collection_game.collection_id', '=', 'collections.id')
        ->where('collections.user_id', $userId)
        ->where('collections.slug', 'favorites')
        ->groupBy('themes.id')
        ->orderByRaw('total_occurrences DESC')
        ->limit($total)
        ->get();
	}

    public static function getFavoriteThemesByRatings($userId, $score, $total)
	{
		return Theme::selectRaw('themes.*, COUNT(ratings.id) AS total_occurrences')
        ->join('game_theme', 'themes.id', '=', 'game_theme.theme_id')
        ->join('games', 'game_theme.game_id', '=', 'games.id')
        ->join('ratings', 'games.id', '=', 'ratings.game_id')
        ->whereIn('ratings.id', function ($query) use ($userId, $score) {
            $query->select('id')
                ->from('ratings')
                ->where('user_id', $userId)
                ->where('score', '>=', $score);
        })
        ->groupBy('themes.id')
        ->orderByRaw('total_occurrences DESC')
        ->limit($total)
        ->get();
	}

    public function getPremiumUsers()
    {
        return User::has('subscriptions')->get();
    }

    public function getSubscribedsWhoNotVisitedIn30Days()
    {
        return User::subscribed()->whereRaw('last_access < CURRENT_DATE - INTERVAL 30 DAY')->get();
    }
}
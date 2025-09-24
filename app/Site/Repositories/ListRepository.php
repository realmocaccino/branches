<?php
namespace App\Site\Repositories;

use App\Site\Models\{Game, Platform};

class ListRepository
{
    protected $game;
    protected $platform;

    protected $classicGameDate;
    protected $minimumOfRatingsToAppear;

    public function __construct(Game $game)
    {
        $this->game = $game;

        $this->classicGameDate = config('site.classic_game_date');
        $this->minimumOfRatingsToAppear = config('site.minimum_ratings_to_rank');
    }

    public function withPlatform(Platform $platform)
    {
        $this->platform = $platform;
    }

    public function getGamesQuery()
    {
        return $this->game
        ->select('games.*')
        ->whereNull('games.deleted_at')
        ->where('games.status', 1)
        ->groupBy('games.id')
        ->when($this->platform, function ($query) {
            return $query->join('game_platform', function ($join) {
                $join
                ->on('game_platform.game_id', '=', 'games.id')
                ->where('game_platform.platform_id', '=', $this->platform->id);
            });
        });
    }

    public function getGamesWithCollectionsQuery()
    {
        return $this->game
        ->selectRaw('games.*, count(games.id) AS total')
        ->join('collection_game', 'collection_game.game_id', '=', 'games.id')
        ->join('collections', 'collections.id', '=', 'collection_game.collection_id')
        ->whereNull('collections.deleted_at')
        ->whereNull('games.deleted_at')
        ->where('games.status', 1)
        ->groupBy('games.id');
    }

    public function getGamesWithCriteriasQuery()
    {
        return $this->getGamesQuery()
        ->join('criteria_game', 'criteria_game.game_id', '=', 'games.id')
        ->join('criterias', 'criterias.id', '=', 'criteria_game.criteria_id')
        ->whereNull('criterias.deleted_at')
        ->where('criterias.status', 1)
        ->orderBy('criteria_game.score', 'desc')
        ->orderBy('games.release', 'desc')
        ->when($this->platform, function ($query) {
            $query->where('game_platform.total', '>=', $this->minimumOfRatingsToAppear);
        }, function($query) {
            $query->where('total_ratings', '>=', $this->minimumOfRatingsToAppear * 3);
        });
    }

    public function getGamesWithGenresAndCharacteristicsQuery()
    {
        return $this->game
        ->select('games.*')
        ->join('game_genre', 'game_genre.game_id', '=', 'games.id')
        ->join('genres', 'genres.id', '=', 'game_genre.genre_id')
        ->join('characteristic_game', 'characteristic_game.game_id', '=', 'games.id')
        ->join('characteristics', 'characteristics.id', '=', 'characteristic_game.characteristic_id')
        ->whereNull('games.deleted_at')
        ->whereNull('genres.deleted_at')
        ->whereNull('characteristics.deleted_at')
        ->where('games.status', 1)
        ->where('genres.status', 1)
        ->where('characteristics.status', 1)
        ->when($this->platform, function ($query) {
            return $query->join('game_platform', function($join) {
                $join
                ->on('game_platform.game_id', '=', 'games.id')
                ->where('game_platform.platform_id', '=', $this->platform->id);
            })
            ->where('game_platform.total', '>=', $this->minimumOfRatingsToAppear);
        }, function($query) {
            return $query->where('total_ratings', '>=', $this->minimumOfRatingsToAppear);
        })
        ->orderBy('games.release', 'desc')
        ->groupBy('games.id');
    }

    public function getGamesWithRatingsQuery()
    {
        return $this->getGamesQuery()
        ->join('ratings', 'ratings.game_id', '=', 'games.id')
        ->whereNull('ratings.deleted_at');
    }

    public function acclaimedGames($scoreForPraisedGames)
    {
        return $this->getGamesQuery()
        ->where('critic_score', '>=', $scoreForPraisedGames)
        ->where('total_critic_ratings', '>=', $this->minimumOfRatingsToAppear)
        ->orderBy('critic_score', 'desc')
        ->orderBy('total_critic_ratings', 'desc');
    }

    public function bestGames($scoreForPraisedGames)
    {
        return $this->getGamesQuery()
        ->when(!$this->platform, function ($query) use ($scoreForPraisedGames) {
            return $query->where('score', '>=', $scoreForPraisedGames)
                ->where('total_ratings', '>=', $this->minimumOfRatingsToAppear)
                ->orderBy('score', 'desc')
                ->orderBy('total_ratings', 'desc');
        }, function ($query) use ($scoreForPraisedGames) {
            return $query->where('game_platform.score', '>=', $scoreForPraisedGames)
                ->where('game_platform.total', '>=', $this->minimumOfRatingsToAppear)
                ->orderBy('game_platform.score', 'desc')
                ->orderBy('game_platform.total', 'desc');
        });
    }

    public function byScoreRange($startRange, $endRange)
    {
        return $this->getGamesQuery()
        ->whereBetween('score', [$startRange, $endRange])
        ->where('total_ratings', '>=', $this->minimumOfRatingsToAppear)
        ->orderBy('total_ratings', 'desc');
    }

    public function classicGames($dateTrendingGames, $dateTrendingReviews)
    {
        return $this->getGamesWithRatingsQuery()
        ->leftJoin('reviews', function ($join) use ($dateTrendingReviews) {
            $join->on('reviews.rating_id', '=', 'ratings.id');
            $join->where('reviews.created_at', '>=', $dateTrendingReviews);
            $join->whereNull('reviews.deleted_at');
        })
        ->where('games.release', '<', $this->classicGameDate)
        ->where('ratings.created_at', '>=', $dateTrendingGames)
        ->orderByRaw('(COUNT(reviews.id) + COUNT(ratings.id)) DESC');
    }

    public function featuredGames($dateTrendingGames, $dateTrendingReviews, $daysTrendingFutureGames)
    {
        return $this->getGamesQuery()
        ->selectRaw(" 
            IF(games.release < '{$dateTrendingGames}',
                (COUNT(reviews.id) + COUNT(ratings.id)) / 3,
                IF(games.release > CURDATE(),
                    CEIL(COALESCE({$daysTrendingFutureGames} / DATEDIFF(games.release, CURDATE()), 0)),
                    IF(games.release = CURDATE(),
                        ((COUNT(reviews.id) + COUNT(ratings.id)) * 10) + {$daysTrendingFutureGames},
                        ((COUNT(reviews.id) + COUNT(ratings.id)) * CEIL(COALESCE({$daysTrendingFutureGames} / DATEDIFF(CURDATE(), games.release), 0))) + CEIL(COALESCE({$daysTrendingFutureGames} / DATEDIFF(CURDATE(), games.release), 0))
                    )
                )
            ) AS total")
        ->leftJoin('ratings', function ($join) use ($dateTrendingGames) {
            $join->on('ratings.game_id', '=', 'games.id');
            $join->where('ratings.created_at', '>=', $dateTrendingGames);
            $join->whereNull('ratings.deleted_at');
            $join->when($this->platform, function ($query) {
                $query->where('ratings.platform_id', $this->platform->id);
            });
        })
        ->leftJoin('reviews', function ($join) use ($dateTrendingReviews) {
            $join->on('reviews.rating_id', '=', 'ratings.id');
            $join->where('reviews.created_at', '>=', $dateTrendingReviews);
            $join->whereNull('reviews.deleted_at');
            $join->when($this->platform, function ($query) {
                $query->where('ratings.platform_id', $this->platform->id);
            });
        })
        ->orderByRaw('
            total DESC,
            CASE
                WHEN games.release <= CURDATE() THEN 1
                ELSE 0
            END DESC, games.release DESC');
    }

    public function havingBirthdayToday()
    {
        return $this->getGamesQuery()
        ->whereDay('games.release', '=', date('d'))
        ->whereMonth('games.release', '=', date('m'))
        ->whereYear('games.release', '<', date('Y'))
        ->orderBy('games.release', 'asc');
    }

    public function hiddenGems($scoreForPraisedGames)
    {
        return $this->getGamesQuery()
        ->where('critic_score', '>=', $scoreForPraisedGames)
        //->where('total_critic_ratings', '>', $this->minimumOfRatingsToAppear)
        ->where('total_ratings', '<', $this->minimumOfRatingsToAppear)
        ->where('games.release', '>=', $this->classicGameDate)
        //->orderBy('critic_score', 'desc')
        //->orderBy('release', 'desc')
        ->inRandomOrder();
    }

    public function inEarlyAccess()
    {
        return $this->getGamesQuery()
        ->whereIsEarlyAccess(true)
        ->orderBy('games.release', 'desc');
    }

    public function latestReleases($dateTrendingGames)
    {
        return $this->getGamesQuery()
        ->whereBetween('games.release', [
            $dateTrendingGames,
            today()
        ])
        ->orderBy('games.release', 'desc');
    }

    public function mostAnticipatedGames()
    {
        return $this->getGamesWithCollectionsQuery()
        ->whereIn('collections.slug', ['favorites', 'wishlist'])
        ->where('games.release', '>', today())
        ->orWhereNull('games.release')
        ->orderBy('total', 'desc');
    }

    public function mostDesiredGames($dateTrendingGames)
    {
        return $this->getGamesWithCollectionsQuery()
        ->where('collections.slug', 'wishlist')
        ->where('collection_game.created_at', '>=', $dateTrendingGames)
        ->where('games.release', '>=', $this->classicGameDate)
        ->orderBy('total', 'desc');
    }

    public function mostLovedGames($dateTrendingGames)
    {
        return $this->getGamesWithCollectionsQuery()
        ->where('collections.slug', 'favorites')
        ->where('collection_game.created_at', '>=', $dateTrendingGames)
        ->orderBy('total', 'desc');
    }

    public function nextReleases()
    {
        return $this->getGamesQuery()
        ->where('games.release', '>', today())
        ->orderBy('games.release', 'asc');
    }

    public function popularGames($dateTrendingGames, $dateTrendingReviews)
    {
        return $this->getGamesQuery()
        ->selectRaw('(COUNT(ratings.id) + COUNT(reviews.id)) AS total')
        ->leftJoin('ratings', function ($join) use ($dateTrendingGames) {
            $join->on('ratings.game_id', '=', 'games.id');
            $join->where('ratings.created_at', '>=', $dateTrendingGames);
            $join->whereNull('ratings.deleted_at');
        })
        ->leftJoin('reviews', function ($join) use ($dateTrendingReviews) {
            $join->on('reviews.rating_id', '=', 'ratings.id');
            $join->where('reviews.created_at', '>=', $dateTrendingReviews);
            $join->whereNull('reviews.deleted_at');
        })
        ->orderBy('total', 'desc')
        ->orderBy('games.release', 'desc');
    }

    public function recentlyAdded($dateTrendingGames)
    {
        return $this->getGamesQuery()
        ->where('games.created_at', '>=', $dateTrendingGames)
        ->orderBy('games.created_at', 'desc');
    }

    public function recentlyContributed($dateTrendingGames)
    {
        return $this->getGamesQuery()
        ->join('contributions', 'contributions.game_id', '=', 'games.id')
        ->where('games.created_at', '>=', $dateTrendingGames)
        ->orderBy('games.created_at', 'desc');
    }

    public function recentlyRated($dateTrendingGames)
    {
        return $this->getGamesWithRatingsQuery()
        ->where('ratings.created_at', '>=', $dateTrendingGames)
        ->orderByRaw('MAX(ratings.created_at) DESC');
    }

    public function recentlyReviewed($dateTrendingReviews)
    {
        return $this->getGamesWithRatingsQuery()
        ->join('reviews', 'reviews.rating_id', '=', 'ratings.id')
        ->whereNull('reviews.deleted_at')
        ->where('reviews.created_at', '>=', $dateTrendingReviews)
        ->orderByRaw('MAX(reviews.created_at) DESC');
    }

    public function releases($dateTrendingGames, $dateTrendingFutureGames)
    {
        return $this->getGamesQuery()
        ->whereBetween('games.release', [$dateTrendingGames, $dateTrendingFutureGames])
        ->orderByRaw('ABS(DATEDIFF(games.release, CURDATE())) ASC');
    }
}
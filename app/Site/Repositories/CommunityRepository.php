<?php
namespace App\Site\Repositories;

use App\Site\Models\{Collection, Contribution, Discussion, Game, Rating, Review, User};

class CommunityRepository
{
    protected $collection;
    protected $contribution;
    protected $discussion;
    protected $game;
    protected $rating;
    protected $review;
    protected $user;

    public function __construct(
        Collection $collection,
        Contribution $contribution,
        Discussion $discussion,
        Game $game,
        Rating $rating,
        Review $review,
        User $user
    ) {
        $this->collection = $collection;
        $this->contribution = $contribution;
        $this->discussion = $discussion;
        $this->game = $game;
        $this->rating = $rating;
        $this->review = $review;
        $this->user = $user;
    }

    private function getBaseCollectionQuery()
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

    public function getAnticipatedGames($daysRange, $total)
    {
        return $this->getBaseCollectionQuery()
        ->whereIn('collections.slug', ['favorites', 'wishlist'])
        ->where(function($query) {
            return $query
            ->where('games.release', '>', today())
            ->orWhereNull('games.release');
        })
        ->where('collection_game.created_at', '>', now()->subDay($daysRange))
        ->orderBy('total', 'desc')
        ->orderBy('games.release', 'desc')
        ->take($total)
        ->get();
    }

    public function getCollections($total)
    {
        return $this->collection->onlyCustom()->notPrivate()->withAtLeastThreeGames()->latest()->take($total)->get();
    }

    public function getContributions($total)
    {
        return $this->contribution->latest()->take($total)->get();
    }

    public function getDiscussions($total)
    {
        return $this->discussion->latest()->take($total)->get();
    }

    public function getPlayingNowGames($daysRange, $total)
    {
        return $this->getBaseCollectionQuery()
        ->where('collections.slug', 'playing')
        ->where('collection_game.created_at', '>', now()->subDay($daysRange))
        ->orderBy('total', 'desc')
        ->orderBy('games.release', 'desc')
        ->take($total)
        ->get();
    }

    public function getRatings($total)
    {
        return $this->rating->latest()->take($total)->get();
    }

    public function getReviews($total)
    {
        return $this->review->latest()->take($total)->get();
    }

    public function getSpotlightUsers($dateRange, $total, $idsToExclude = [])
    {
        return $this->user
		    ::selectRaw('(COUNT(DISTINCT ratings.id) + (COUNT(DISTINCT reviews.id) * 2) + (COUNT(DISTINCT contributions.id) * 2)) AS total, users.*')
		    ->leftJoin('ratings', function($query) use($dateRange) {
		        return $query->on('users.id', '=', 'ratings.user_id')
                             ->where('ratings.created_at', '>', $dateRange)
                             ->whereNull('ratings.deleted_at');
		    })
		    ->leftJoin('reviews', function($query) use($dateRange) {
		        return $query->on('ratings.id', '=', 'reviews.rating_id')
                             ->where('reviews.created_at', '>', $dateRange)
                             ->whereNull('reviews.deleted_at');
		    }) 
		    ->leftJoin('contributions', function($query) use($dateRange) {
		        return $query->on('users.id', '=', 'contributions.user_id')
                             ->where('contributions.created_at', '>', $dateRange)
                             ->whereNull('contributions.deleted_at');
		    })
            ->whereNotIn('users.id', $idsToExclude)
		    ->orderBy('total', 'desc')
		    ->having('total', '>', '0')
		    ->groupBy('users.id')
		    ->take($total)
		    ->get();
    }
}
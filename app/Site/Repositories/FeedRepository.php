<?php
namespace App\Site\Repositories;

use App\Site\Models\{Collection, Contribution, Rating, Review, ReviewFeedback};
use App\Site\Models\Pivots\{CollectionGame, UserFollower};

class FeedRepository
{
    protected $collection;
    protected $collectionGame;
    protected $contribution;
    protected $rating;
    protected $review;
    protected $reviewFeedback;
    protected $userFollower;

    protected $dateRange;

    public function __construct(
        Collection $collection,
        CollectionGame $collectionGame,
        Contribution $contribution,
        Rating $rating,
        Review $review,
        ReviewFeedback $reviewFeedback,
        UserFollower $userFollower
    ) {
        $this->collection = $collection;
        $this->collectionGame = $collectionGame;
        $this->contribution = $contribution;
        $this->rating = $rating;
        $this->review = $review;
        $this->reviewFeedback = $reviewFeedback;
        $this->userFollower = $userFollower;

        $this->dateRange = now()->subMonths(config('site.feed_months_period'));
    }

    public function getCollections()
    {
        return $this->collection->selectRaw("*, 'collection' as entity")->where('created_at', '>=', $this->dateRange)->onlyCustom()->notPrivate()->withAtLeastThreeGames();
    }

    public function getContributions()
    {
        return $this->contribution->selectRaw("*, 'contribution' as entity")->whereHas('game')->where('created_at', '>=', $this->dateRange);
    }

    public function getRatings()
    {
        return $this->rating->selectRaw("*, 'rating' as entity")->where('created_at', '>=', $this->dateRange);
    }

    public function getReviews()
    {
        return $this->review->selectRaw("reviews.*, ratings.user_id, 'review' as entity")->join('ratings', 'ratings.id', 'reviews.rating_id')->where('reviews.created_at', '>=', $this->dateRange);
    }

    public function getReviewFeedbacks()
    {
        return $this->reviewFeedback->selectRaw("*, 'reviewFeedback' as entity")->whereFeedback(true)->where('created_at', '>=', $this->dateRange);
    }
    
    public function getFollows()
    {
        return $this->userFollower->selectRaw("user_follower.*, 'follow' as entity")->where('created_at', '>=', $this->dateRange);
    }
    
    public function getLikes()
    {
        return $this->collectionGame->selectRaw("collection_game.*, collections.user_id, 'like' as entity")->join('collections', 'collections.id', 'collection_game.collection_id')->where('collections.slug', 'favorites')->where('collection_game.created_at', '>=', $this->dateRange);
    }
    
    public function getWants()
    {
        return $this->collectionGame->selectRaw("collection_game.*, collections.user_id, 'want' as entity")->join('collections', 'collections.id', 'collection_game.collection_id')->where('collections.slug', 'wishlist')->where('collection_game.created_at', '>=', $this->dateRange);
    }
}
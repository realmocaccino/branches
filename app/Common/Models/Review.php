<?php
namespace App\Common\Models;

use App\Common\Presenters\ReviewPresenter;

use Znck\Eloquent\Traits\BelongsToThrough;

class Review extends Base
{
	use BelongsToThrough, ReviewPresenter;

	protected $table = 'reviews';
    
    public function feedbacks()
    {
    	return $this->hasMany(ReviewFeedback::class, 'review_id');
    }
    
    public function positiveFeedbacks()
    {
    	return $this->feedbacks()->whereFeedback(1);
    }
    
    public function negativeFeedbacks()
    {
    	return $this->feedbacks()->whereFeedback(0);
    }
    
	public function game()
	{
		return $this->belongsToThrough(Game::class, Rating::class);
	}
	
	public function platform()
	{
		return $this->belongsToThrough(Platform::class, Rating::class);
	}
	
	public function rating()
    {
		return $this->belongsTo(Rating::class, 'rating_id');
	}
	
	public function user()
	{
		return $this->belongsToThrough(User::class, Rating::class);
	}

	public function scopeOrderByCredibility($query)
	{
		return $query
		->select('reviews.*')
		->groupBy('reviews.id')
		->leftJoin('reviews_feedbacks', 'reviews.id', '=', 'reviews_feedbacks.review_id')
		->selectRaw('SUM(CASE WHEN reviews_feedbacks.feedback IS NOT NULL THEN (CASE WHEN reviews_feedbacks.feedback = 1 THEN 1 ELSE -1 END) ELSE 0 END) AS credibility')
		->orderByRaw('credibility DESC, LENGTH(text) DESC');
	}

	public function scopePrioritizeUser($query, $user)
	{
		return $query->when($user, function($query) use($user) {
			$query->orderByRaw('CASE WHEN ratings.user_id = ' . $user->id . ' THEN 0 ELSE 1 END');
		});
	}

	public function scopeRelevant($query)
	{
	    return $query->whereRaw('LENGTH(text) >= ' . config('site.relevant_review_minimum_characters'));
	}
}

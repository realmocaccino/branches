<?php
namespace App\Common\Presenters;

use Illuminate\Support\Facades\{DB, Storage};

trait UserPresenter
{
	use BasePresenter;
	
	public $uploadStorageFolder = [
	    'background' => 'user/background',
		'picture' => 'user/picture',
	];
	
    public $uploadDimensions = [
        'background' => [
			['width' => 1920, 'height' => 1080, 'quality' => 50],
			['width' => 1280, 'height' => 720, 'quality' => 50],
			['width' => 576, 'height' => 324, 'quality' => 72]
		],
    	'picture' => [
    		['width' => 27, 'height' => 18],
			['width' => 34, 'height' => 34],
			['width' => 48, 'height' => 60],
			['width' => 78, 'height' => 90],
			['width' => 150, 'height' => 150],
			['width' => 180],
			['width' => 240]
		]
	];

	public function bestRecentRatings()
	{
		return $this->ratings()->where('created_at', '>', now()->subYear())->where('score', '>', '8.5')->reorder('score', 'desc');
	}

	public function commonRatings($user)
	{
		return $this->ratings()->whereIn('game_id', $user->ratings()->pluck('game_id'));
	}

	public function favoriteTags()
	{
		return $this->getFavoriteGenres()->merge($this->getFavoriteCharacteristics()->merge($this->getFavoriteThemes()))->sortByDesc('total_occurrences');
	}
	
	public function getBackground($dimensionFolder = '1920x1080')
	{
		return ($this->background) ? asset(Storage::url(implode('/', [$this->uploadStorageFolder['background'], $dimensionFolder, $this->background]))) : null;
	}
	
	public function getPicture($dimensionFolder = '78x90')
	{
		return ($this->picture) ? asset(Storage::url(implode('/', [$this->uploadStorageFolder['picture'], $dimensionFolder, $this->picture]))) : asset('img/no-picture.jpg');
	}

	public function hasVisitedInTheLastYear()
	{
		return $this->last_access->diffInYears() < 1;
	}

    public function isNewcomer()
    {
        return $this->level < config('site.newcomer_level_ceil', 1);
    }
	
	public function isPremium()
	{
	    return $this->subscriptions()->whereDate('expires_at', '>', now())->exists();
	}

	public function mostLikedReviews()
	{
		return $this->reviews(false)->orderByCredibility()->having('credibility', '>', 0);
	}

	public function negativeReviewsFeedbacksGiven()
	{
		return $this->reviewsFeedbacks()->whereFeedback(0);
	}

	public function negativeReviewsFeedbacksReceived()
	{
		return DB::table('reviews_feedbacks')
		->join('reviews', 'reviews_feedbacks.review_id', '=', 'reviews.id')
		->join('ratings', 'reviews.rating_id', '=', 'ratings.id')
		->where('ratings.user_id', '=', $this->id)
		->where('feedback', '=', 0)
		->whereNull('ratings.deleted_at')
		->whereNull('reviews.deleted_at');
	}
	
	public function positiveReviewsFeedbacksGiven()
	{
		return $this->reviewsFeedbacks()->whereFeedback(1);
	}

	public function positiveReviewsFeedbacksReceived()
	{
		return DB::table('reviews_feedbacks')
            ->join('reviews', 'reviews_feedbacks.review_id', '=', 'reviews.id')
            ->join('ratings', 'reviews.rating_id', '=', 'ratings.id')
            ->where('ratings.user_id', '=', $this->id)
            ->where('feedback', '=', 1)
			->whereNull('ratings.deleted_at')
            ->whereNull('reviews.deleted_at');
	}

	public function premiumSubscription()
	{
	    return $this->subscriptions()->whereDate('expires_at', '>', now())->first();
	}

	public function relevantReviewsAverage()
	{
		if ($relevantReviewsTotal = $this->reviews()->relevant()->count()) {
			return round($relevantReviewsTotal / $this->reviews()->count(), 1);
		}

		return 0;
	}
	
	public function warnsToSend()
    {
        return $this->warns()->whereNull('sent');
    }
    
    public function warnsAlreadySent()
    {
        return $this->warns()->whereSent(1);
    }
}
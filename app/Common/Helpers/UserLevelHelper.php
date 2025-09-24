<?php
namespace App\Common\Helpers;

class UserLevelHelper
{
    private const DIVIDER = 4;
    
    private $user;

    public function __construct()
    {}

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function update()
	{
		$this->user->level = $this->calculate();

        return $this->user->save();
	}

    private function calculate()
	{
		$collectionMultiplier = config('site.multiplier_collection', 1);
	    $contributionMultiplier = config('site.multiplier_contribution', 1);
		$ratingMultiplier = config('site.multiplier_rating', 1);
		$reviewMultiplier = config('site.multiplier_review', 1);

	    $points = 
            ($this->user->collections()->withAtLeastThreeGames()->count() * $collectionMultiplier) +
            ($this->user->total_contributions * $contributionMultiplier) +
            ($this->user->total_ratings * $ratingMultiplier) +
            ($this->user->total_reviews * $reviewMultiplier) +
            $this->user->positiveReviewsFeedbacksReceived()->count();

        return ceil($points / self::DIVIDER);
	}
}
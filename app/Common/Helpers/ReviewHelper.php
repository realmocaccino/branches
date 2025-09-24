<?php
namespace App\Common\Helpers;

use App\Common\Events\NewReviewEvent;
use App\Common\Models\Review;

class ReviewHelper
{
	protected $isNew;
	protected $rating;
	protected $review;

	public function __construct($rating)
	{
		$this->rating = $rating;
		$this->review = $rating->review ?? new Review;
	}
	
	public function save($request)
	{
		$this->isNew = !$this->review->exists;
		
		$this->saveReview($request);
		$this->incrementTotalizers();
		$this->triggerEvent();
		
		return $this->review;
	}
	
	public function delete()
	{
		if($this->review->exists) {
			$this->deleteReviewFeedbacks();
			$this->deleteReview();
			$this->decrementTotalizers();
		}
	}

	public function isNew()
	{
		return $this->isNew;
	}
	
	protected function decrementTotalizers()
	{
		$this->disableTimestamps($this->rating);
		$this->rating->game->decrement('total_reviews');
		$this->rating->user->decrement('total_reviews');
	}
	
	protected function deleteReview()
	{
		$this->review->delete();
	}
	
	protected function deleteReviewFeedbacks()
	{
		$this->review->feedbacks()->delete();
	}
	
	protected function disableTimestamps($rating)
	{
		$this->rating->game->timestamps = false;
		$this->rating->user->timestamps = false;
	}
	
	protected function incrementTotalizers()
	{
		if($this->isNew) {
			$this->disableTimestamps($this->rating);
			$this->rating->game->increment('total_reviews');
			$this->rating->user->increment('total_reviews');
		}
	}
	
	protected function saveReview($request)
	{
		$this->review->text = $this->treatText($request->text);
		$this->review->has_spoilers = filter_var($request->has_spoilers, FILTER_VALIDATE_BOOLEAN);
		
		$this->rating->review()->save($this->review);
	}
	
	protected function treatText($text)
	{
		return addslashes(strip_tags($text));
	}

	protected function triggerEvent()
	{
		if($this->isNew) event(new NewReviewEvent($this->review));
	}
}
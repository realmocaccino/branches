<?php
namespace App\Common\Presenters;

use Illuminate\Support\Facades\Auth;

trait ReviewPresenter
{
	use BasePresenter;

	public function checkIfLoggedInUserHasFeedbacked($feedback)
	{
		$userLoggedInId = Auth::guard('site')->id();
		
		if($userLoggedInId) {
			return $this->feedbacks()->whereUserId($userLoggedInId)->whereFeedback($feedback)->first();
		}
	}

	public function hasSpoilers()
	{
		return $this->has_spoilers;
	}

	public function isRelevant()
	{
		return strlen($this->text) >= config('site.relevant_review_minimum_characters');
	}
}

<?php
namespace App\Site\Models;

use App\Common\Models\ReviewFeedback as BaseReviewFeedback;

class ReviewFeedback extends BaseReviewFeedback
{
	protected $fillable = [
		'review_id',
		'user_id',
		'feedback'
	];

	public function review()
	{
		return parent::review();
	}
	
	public function user()
	{
		return parent::user();
	}
}

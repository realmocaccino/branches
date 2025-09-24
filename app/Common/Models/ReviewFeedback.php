<?php
namespace App\Common\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewFeedback extends Model
{
	protected $table = 'reviews_feedbacks';
    
	public function review()
	{
		return $this->belongsTo(Review::class, 'review_id');
	}
	
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}

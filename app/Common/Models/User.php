<?php
namespace App\Common\Models;

use App\Site\Models\Game;
use App\Common\Presenters\UserPresenter;
use App\Common\Helpers\RatingHelper;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Base
{
	use UserPresenter, Notifiable, SoftDeletes;

	protected $table = 'users';
    
    public function getFirstNameAttribute()
	{
		return Str::words($this->name, 1, '');
	}
    
    public function answers()
	{
		return $this->hasMany(Answer::class, 'user_id');
	}
	
	public function collections()
	{
		return $this->hasMany(Collection::class, 'user_id');
	}
    
	public function contributions()
	{
		return $this->hasMany(Contribution::class, 'user_id');
	}
	
	public function discussions()
	{
		return $this->hasMany(Discussion::class, 'user_id');
	}
	
	public function platform()
	{
        return $this->belongsTo(Platform::class, 'platform_id');
    }
    
    public function ratings()
	{
		return $this->hasMany(Rating::class, 'user_id');
	}
    
    public function reviews()
    {
		return $this->hasManyThrough(Review::class, Rating::class, 'user_id', 'rating_id');
	}
	
	public function reviewsFeedbacks()
	{
		return $this->hasMany(ReviewFeedback::class, 'user_id');
	}
	
	public function subscriptions()
	{
		return $this->hasMany(Subscription::class, 'user_id');
	}
	
	public function warns()
    {
        return $this->hasMany(WarnMe::class);
    }
	
	public function delete()
	{
		foreach($this->ratings as $rating) {
			$ratingHelper = new RatingHelper(Game::findBySlugOrFail($rating->game->slug), $rating->user, $rating);
			$ratingHelper->delete();
		}
		
		$this->answers()->delete();
		$this->collections()->delete();
		$this->contributions()->delete();
		$this->discussions()->delete();
		$this->reviewsFeedbacks()->delete();
		$this->subscriptions()->delete();
		$this->warns()->delete();
		
		parent::delete();
	}
}
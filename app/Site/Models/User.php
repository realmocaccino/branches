<?php
namespace App\Site\Models;

use App\Site\Models\Traits\FollowableTrait;
use App\Site\Presenters\{UserBadgesPresenter, UserCollectionPresenter, UserDiscoverPresenter};
use App\Common\Presenters\UserPresenter;
use App\Common\Helpers\RatingHelper;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
	use SoftDeletes, Notifiable, UserBadgesPresenter, UserCollectionPresenter, UserDiscoverPresenter, UserPresenter, FollowableTrait;
	
	protected $table = 'users';
	
	protected $casts = [
	    'last_access' => 'datetime'
	];
	
	public function getFirstNameAttribute()
	{
		return Str::words($this->name, 1, '');
	}
	
	public function scopeSubscribed($query)
	{
	    return $query->whereNewsletter(1);
	}
	
	public function answers()
	{
		return $this->hasMany(Answer::class, 'user_id')->where('answers.status', 1)->orderBy('answers.created_at', 'desc');
	}
	
	public function collections()
	{
		return $this->hasMany(Collection::class, 'user_id')->orderBy('collections.updated_at', 'desc');
	}
	
    public function contributions()
	{
	    return $this->hasMany(Contribution::class, 'user_id')->orderBy('contributions.updated_at', 'desc');
	}
	
	public function discussions()
	{
		return $this->hasMany(Discussion::class, 'user_id')->where('discussions.status', 1)->orderBy('discussions.created_at', 'desc');
	}
	
	public function platform()
	{
        return $this->belongsTo(Platform::class, 'platform_id')->where('platforms.status', 1);
    }
    
    public function ratings()
	{
		return $this->hasMany(Rating::class, 'user_id')->with('game')->whereHas('game', function($query) {
			$query->where('status', 1);
		})->orderBy('ratings.updated_at', 'desc');
	}
    
    public function reviews($withOrder = true)
    {
		return $this->hasManyThrough(Review::class, Rating::class, 'user_id', 'rating_id')->when($withOrder, function($query) {
			return $query->orderBy('reviews.updated_at', 'desc');
		});
	}
	
	public function reviewsFeedbacks()
	{
		return $this->hasMany(ReviewFeedback::class, 'user_id')->orderBy('updated_at', 'desc');
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
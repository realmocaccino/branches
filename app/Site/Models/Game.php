<?php
namespace App\Site\Models;

use App\Site\Models\{User, WarnMe};
use App\Site\Presenters\GamePresenter;
use App\Common\Models\Game as BaseGame;

class Game extends BaseGame
{
	use GamePresenter;
	
	public function getScoreAttribute($value)
	{
		return $value ?? $this->critic_score;
	}
	
	public function getDescriptionAttribute($value)
	{
	    return (config('site.locale') == 'pt') ? $value : null;
	}
	
	public function getClassificationIdAttribute($value)
	{
	    return (config('site.locale') == 'pt') ? $value : null;
	}
	
	public function getAggregateScoreAttribute()
	{
		return ($this->score and $this->critic_score) ? round(($this->score + $this->critic_score) / 2, 1) : ($this->critic_score ?? $this->score);
	}
	
	public function getTotalAggregateRatingsAttribute()
	{
		return $this->total_ratings + $this->total_critic_ratings;
	}
	
	public function characteristics()
	{
		return $this->belongsToMany(Characteristic::class, 'characteristic_game', 'game_id', 'characteristic_id')->withTimestamps()->where('characteristics.status', 1)->orderBy('characteristics.name' . config('site.locale_column_suffix'));
	}
	
	public function classification()
	{
		return parent::classification()->where('classifications.status', 1);
	}
	
	public function collections()
	{
		return parent::collections()->orderBy('collections.created_at', 'desc');
	}
	
	public function contributions()
	{
		return parent::contributions()->select('contributions.*')->join('users', 'users.id', '=', 'contributions.user_id')->where('users.status', 1)->whereNull('users.deleted_at')->orderBy('users.updated_at', 'desc')->groupBy('contributions.user_id');
	}
	
	public function criterias()
	{
		return $this->belongsToMany(Criteria::class, 'criteria_game', 'game_id', 'criteria_id')->withTimestamps()->withPivot('id', 'score')->where('criterias.status', 1)->orderBy('criterias.order');
	}
    
    public function developers()
    {
		return parent::developers()->where('developers.status', 1)->orderBy('developers.name');
	}
	
	public function discussions()
	{
		return parent::discussions()->has('user')->where('discussions.status', 1)->orderBy('discussions.created_at', 'desc');
	}
	
	public function franchises()
	{
		return parent::franchises()->where('franchises.status', 1)->orderBy('franchises.name');
	}
    
	public function genres()
	{
		return $this->belongsToMany(Genre::class, 'game_genre', 'game_id', 'genre_id')->withTimestamps()->where('genres.status', 1)->orderBy('genres.name' . config('site.locale_column_suffix'));
	}
	
	public function modes()
	{
		return $this->belongsToMany(Mode::class, 'game_mode', 'game_id', 'mode_id')->withTimestamps()->where('modes.status', 1)->orderBy('modes.name' . config('site.locale_column_suffix'), 'desc');
	}
	
	public function platforms($withOrder = true)
	{
		return parent::platforms()->withPivot('id', 'score', 'total')->where('platforms.status', 1)->when($withOrder, function($query) {
			$query->orderBy('platforms.name');
		});
	}
	
	public function publishers()
	{
		return parent::publishers()->where('publishers.status', 1)->orderBy('publishers.name');
	}
	
	public function ratings($withOrder = true)
	{
		return parent::ratings()->whereHas('user', function($query) {
			$query->where('status', 1);
		})->when($withOrder, function($query) {
			$query->orderBy('created_at', 'desc');
		});
	}
	
	public function reviews()
	{
		return parent::reviews()->whereHas('user', function($query) {
			$query->where('status', 1);
		});
	}
	
	public function scores()
	{
		return parent::scores();
	}
	
	public function screenshots()
	{
		return parent::screenshots();
	}
	
	public function themes()
	{
		return $this->belongsToMany(Theme::class, 'game_theme', 'game_id', 'theme_id')->withTimestamps()->where('themes.status', 1)->orderBy('themes.name' . config('site.locale_column_suffix'));
	}
	
	public function warns()
    {
        return parent::warns();
    }
}
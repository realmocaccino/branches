<?php
namespace App\Common\Models;

use App\Common\Presenters\PlatformPresenter;

class Platform extends Base
{
	use PlatformPresenter;

    protected $table = 'platforms';
    
    public function games()
	{
		return $this->belongsToMany(Game::class, 'game_platform', 'platform_id', 'game_id')->withTimestamps();
	}
	
	public function generation()
	{
		return $this->belongsTo(Generation::class, 'generation_id');
	}
	
	public function manufacturer()
	{
		return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
	}
	
	public function ratings()
	{
		return $this->hasMany(Rating::class, 'platform_id');
	}

	public function scopeClassic($query)
	{
	    return $query->whereStatus(1)->where('release', '<', config('site.classic_platform_year'));
	}

	public function scopeModern($query)
	{
	    return $query->whereStatus(1)->where('release', '>=', config('site.classic_platform_year'));
	}

	public function scopeInRelevantOrder($query)
	{
		return $query->orderByRaw("
			CASE 
				WHEN platforms.slug = 'microsoft-windows' THEN 0
				ELSE 1
			END, platforms.release DESC
		");
	}

	public function scopeWithMoreThanHundredGames($query)
	{
		return $query->has('games', '>=', 100);
	}
}
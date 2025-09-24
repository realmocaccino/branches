<?php
namespace App\Common\Models;

class Collection extends Base
{
    protected $table = 'collections';
    
    public function games()
	{
		return $this->belongsToMany(Game::class, 'collection_game', 'collection_id', 'game_id')->withTimestamps();
	}
	
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
	
	public function scopeNotPrivate($query)
	{
	    return $query->whereNull('private');
	}
	
	public function scopeOnlyCustom($query)
	{
	    return $query->whereNotIn('slug', config('site.default_collections'));
	}
	
	public function scopeWithGames($query)
	{
	    return $query->has('games')->withCount('games');
	}
	
	public function scopeWithAtLeastThreeGames($query)
	{
	    return $query->has('games', '>=', 3)->withCount('games');
	}
}
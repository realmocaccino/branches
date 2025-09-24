<?php
namespace App\Common\Models;

use App\Common\Presenters\GamePresenter;
use App\Common\Helpers\RatingHelper;

class Game extends Base
{
	use GamePresenter;

	protected $table = 'games';

	protected $casts = [
		'release' => 'date',
	];
	
	public function setClassificationIdAttribute($value)
    {
        $this->attributes['classification_id'] = ($value == '' ? null : $value);
    }
	
	public function setReleaseAttribute($value)
    {
        $this->attributes['release'] = ($value) ? implode('-', array_reverse(explode('/', $value))) : null;
    }
    
    public function characteristics()
	{
		return $this->belongsToMany(Characteristic::class, 'characteristic_game', 'game_id', 'characteristic_id')->withTimestamps();
	}
	
	public function classification()
	{
		return $this->belongsTo(Classification::class, 'classification_id');
	}
	
	public function collections()
	{
		return $this->belongsToMany(Collection::class, 'collection_game', 'game_id', 'collection_id')->withTimestamps();
	}
	
	public function contributions()
	{
		return $this->hasMany(Contribution::class, 'game_id');
	}
	
	public function criterias()
	{
		return $this->belongsToMany(Criteria::class, 'criteria_game', 'game_id', 'criteria_id')->withTimestamps();
	}
    
    public function developers()
    {
		return $this->belongsToMany(Developer::class, 'developer_game', 'game_id', 'developer_id')->withTimestamps();
	}
	
	public function discussions()
	{
		return $this->hasMany(Discussion::class, 'game_id');
	}
	
	public function franchises()
	{
		return $this->belongsToMany(Franchise::class, 'franchise_game', 'game_id', 'franchise_id')->withTimestamps();
	}
    
	public function genres()
	{
		return $this->belongsToMany(Genre::class, 'game_genre', 'game_id', 'genre_id')->withTimestamps();
	}
	
	public function modes()
	{
		return $this->belongsToMany(Mode::class, 'game_mode', 'game_id', 'mode_id')->withTimestamps();
	}
	
	public function platforms()
	{
		return $this->belongsToMany(Platform::class, 'game_platform', 'game_id', 'platform_id')->withTimestamps();
	}
	
	public function publishers()
	{
		return $this->belongsToMany(Publisher::class, 'game_publisher', 'game_id', 'publisher_id')->withTimestamps();
	}
	
	public function ratings()
	{
		return $this->hasMany(Rating::class, 'game_id');
	}
	
	public function reviews()
	{
		return $this->hasManyThrough(Review::class, Rating::class, 'game_id', 'rating_id');
	}
	
	public function scores()
	{
		return $this->hasManyThrough(Score::class, Rating::class, 'game_id', 'rating_id');
	}
	
	public function screenshots()
	{
		return $this->hasMany(Screenshot::class, 'game_id');
	}
	
	public function themes()
	{
		return $this->belongsToMany(Theme::class, 'game_theme', 'game_id', 'theme_id')->withTimestamps();
	}
	
	public function warns()
    {
        return $this->hasMany(WarnMe::class);
    }
	
	public function delete()
	{
		foreach($this->ratings as $rating) {
			$ratingHelper = new RatingHelper($rating->game, $rating->user, $rating);
			$ratingHelper->delete();
		}
		
		$this->characteristics()->toBase()->delete(['characteristics.deleted_at'=> now(), 'characteristics.updated_at' => now()]);
		$this->contributions()->toBase()->delete(['contributions.deleted_at'=> now(), 'contributions.updated_at' => now()]);
		$this->criterias()->toBase()->delete(['criterias.deleted_at'=> now(), 'criterias.updated_at' => now()]);
		$this->developers()->toBase()->delete(['developers.deleted_at'=> now(), 'developers.updated_at' => now()]);
		$this->franchises()->toBase()->delete(['franchises.deleted_at'=> now(), 'franchises.updated_at' => now()]);
		$this->genres()->toBase()->delete(['genres.deleted_at'=> now(), 'genres.updated_at' => now()]);
		$this->modes()->toBase()->delete(['modes.deleted_at'=> now(), 'modes.updated_at' => now()]);
		$this->platforms()->toBase()->delete(['platforms.deleted_at'=> now(), 'platforms.updated_at' => now()]);
		$this->publishers()->toBase()->delete(['publishers.deleted_at'=> now(), 'publishers.updated_at' => now()]);
		$this->screenshots()->toBase()->delete(['screenshots.deleted_at'=> now(), 'screenshots.updated_at' => now()]);
		$this->themes()->toBase()->delete(['themes.deleted_at'=> now(), 'themes.updated_at' => now()]);
		
		parent::delete();
	}
}

<?php
namespace App\Console\Actions\Game;

use App\Site\Models\Game;
use App\Common\Helpers\ScoreHelper;

class RepairStats
{
	protected $game;
	
    public function __construct($gameSlug) {
    	$this->game = Game::findBySlugOrFail($gameSlug);
    	$this->game->timestamps = false;
    }
    
    public function repair()
    {
        $this->repairTotalizers();
        $this->repairScore();
        $this->repairPlatformsStats();
        $this->repairCriteriasStats();
    }
    
    public function repairTotalizers()
    {
    	$this->game->total_ratings = $this->game->ratings->count();
    	$this->game->total_reviews = $this->game->reviews->count();
		$this->game->save();
    }
    
    public function repairScore()
    {
    	$this->game->score = ScoreHelper::calculateAverage($this->game->ratings()->sum('score'), $this->game->ratings->count());
		$this->game->save();
    }
    
    public function repairPlatformsStats()
    {
    	foreach($this->game->platforms as $platform) {
    		$sum = $this->game->ratings()->wherePlatformId($platform->id)->sum('score');
    		$total = $this->game->ratings()->wherePlatformId($platform->id)->count();
    		
    		$platform->pivot->total = $total;
    		$platform->pivot->score = ScoreHelper::calculateAverage($sum, $total);
    		$platform->pivot->save();
    	}
    }
    
    public function repairCriteriasStats()
    {
    	foreach($this->game->criterias as $criteria) {
    		$sum = $this->game->scores()->whereCriteriaId($criteria->id)->sum('value');
    		$total = $this->game->scores()->whereCriteriaId($criteria->id)->count();
    		
    		$criteria->pivot->score = ScoreHelper::calculateAverage($sum, $total);
			$criteria->pivot->save();
    	}
    }
}
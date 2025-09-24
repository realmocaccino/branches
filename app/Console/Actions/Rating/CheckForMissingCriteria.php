<?php
namespace App\Console\Actions\Rating;

use App\Console\Actions\Game\RepairStats;
use App\Site\Models\{Rating, Score};

class CheckForMissingCriteria
{
	protected $ratings;
	protected $fillingScore = 10;

	public function __construct() {
    	$this->ratings = Rating::whereHas('game')->whereHas('user')->get();
    }
    
    public function check()
    {
    	foreach($this->ratings as $rating) {
    		if($rating->scores->count() < $rating->game->criterias->count()) {
    			foreach($rating->game->criterias as $criteria) {
    				if(!$rating->scores()->where('criteria_id', $criteria->id)->exists()) {
    					$score = new Score();
                        $score->criteria_id = $criteria->id;
                        $score->value = $this->fillingScore;
                        $score->save();

                        $rating->scores()->save($score);
                        (new RepairStats($rating->game->slug))->repair();
    				}
    			}
    		}
    	}
    }
}

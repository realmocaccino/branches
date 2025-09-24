<?php
namespace App\Site\Presenters;

use App\Site\Models\Criteria;

trait GamePresenter
{
	use BasePresenter, GameLongPresenter;

    public function canRank()
    {
        if(!$characteristicsToExclude = config('site.exclude_characteristics_from_ranking')) return true;

        return $this->characteristics->count() == $this->characteristics->pluck('slug')->diff($characteristicsToExclude)->count();
    }

	public function extensiveDate()
	{
		return ($this->release) ? strftime('%d ' . trans('game/index.extensive_date_separator') . ' %B '. trans('game/index.extensive_date_separator') . ' %Y', strtotime($this->release)) : null;
	}

	public function owner()
	{
		if($this->developers->count()) {
			return $this->developers->first();
		} elseif($this->publishers->count()) {
			return $this->publishers->first();
		}
		
		return false;
	}
	
	public function realName()
	{
		return preg_replace('/ \(\d{4}\)$/', '', $this->name);
	}
	
	public function series()
	{
	    $franchises = $this->franchises()->withCount('games');

	    if($franchises) {
	        $franchises->getQuery()->getQuery()->orders = null;

	        return $franchises->orderBy('games_count')->first();
	    }
	    
	    return null;
	}
}
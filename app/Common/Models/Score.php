<?php
namespace App\Common\Models;

class Score extends Base
{
	protected $table = 'scores';
    
	public function criteria()
	{
		return $this->belongsTo(Criteria::class, 'criteria_id');
	}
	
	public function rating()
    {
		return $this->belongsTo(Rating::class, 'rating_id');
	}
}

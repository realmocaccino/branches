<?php
namespace App\Common\Models;

class Advertisement extends Base
{
	protected $table = 'advertisements';
    
    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class, 'advertiser_id');
    }
}

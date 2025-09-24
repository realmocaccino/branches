<?php
namespace App\Common\Models;

class Advertiser extends Base
{
	protected $table = 'advertisers';

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class, 'advertiser_id');
    }
}

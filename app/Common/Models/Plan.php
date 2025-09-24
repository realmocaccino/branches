<?php
namespace App\Common\Models;

class Plan extends Base
{
	protected $table = 'plans';
    
    protected $fillable = [];
    
    protected $hidden = [];
    
    public function subscriptions()
    {
		return $this->hasMany(Subscription::class, 'plan_id');
	}
}
<?php

namespace App\Common\Models;

class Subscription extends Base
{
    protected $table = 'subscriptions';

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    protected $fillable = [];

    protected $hidden = [];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
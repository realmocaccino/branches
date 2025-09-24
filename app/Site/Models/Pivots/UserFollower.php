<?php
namespace App\Site\Models\Pivots;

use App\Site\Models\User;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserFollower extends Pivot
{
    protected $table = 'user_follower';

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
    
    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }
}
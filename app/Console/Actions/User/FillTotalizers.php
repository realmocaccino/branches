<?php
namespace App\Console\Actions\User;

use App\Site\Models\User;

class FillTotalizers
{
    public function __construct() {}

    public function fill()
    {
        foreach(User::all() as $user) {
			$user->total_ratings = $user->ratings()->count();
			$user->total_reviews = $user->reviews()->count();
			$user->total_contributions = $user->contributions->count();
			$user->timestamps = false;
			$user->save();
		}
    }
}
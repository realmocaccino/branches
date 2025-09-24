<?php
namespace App\Console\Actions\User;

use App\Site\Models\User;
use App\Common\Helpers\Support;

class FillSlugToUsersWithoutOne
{
    public function __construct() {}

    public function fill()
    {
        foreach(User::whereNull('slug')->get() as $user) {
			$user->slug = Support::createUserSlug($user->name);
			$user->timestamps = false;
			$user->save();
		}
    }
}
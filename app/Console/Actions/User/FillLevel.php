<?php
namespace App\Console\Actions\User;

use App\Common\Helpers\UserLevelHelper;
use App\Site\Models\User;

class FillLevel
{
	private $userLevelHelper;

    public function __construct(UserLevelHelper $userLevelHelper)
	{
		$this->userLevelHelper = $userLevelHelper;
	}

    public function fill()
    {
        foreach(User::all() as $user) {
			$this->userLevelHelper->setUser($user)->update();
		}
    }
}
<?php
namespace App\Common\Events\Listeners;

use App\Common\Helpers\UserLevelHelper;

class UpdateUserLevelListener
{
    protected $userLevelHelper;

    public function __construct(UserLevelHelper $userLevelHelper)
    {
        $this->userLevelHelper = $userLevelHelper;
    }

    public function handle($event)
    {
        if ($user = $event->getUser()) {
            $this->userLevelHelper->setUser($user)->update();
        }
    }
}
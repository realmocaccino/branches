<?php
namespace App\Site\Notifications;

use App\Common\Notifications\BaseNotification as CommonBaseNotification;

class BaseNotification extends CommonBaseNotification
{
    public function __construct()
    {
    	parent::__construct();
    }
}

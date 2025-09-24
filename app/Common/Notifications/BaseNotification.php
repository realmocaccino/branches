<?php
namespace App\Common\Notifications;

use App\Common\Models\Settings;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

	protected $settings;

    public function __construct()
    {
    	$this->settings = (new Settings)->get();
    }
}

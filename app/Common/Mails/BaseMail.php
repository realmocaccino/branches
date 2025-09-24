<?php
namespace App\Common\Mails;

use App\Common\Models\Settings;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BaseMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

	protected $settings;

    public function __construct()
    {
    	$this->settings = (new Settings)->get();
    }
}
<?php
namespace App\Console\Mails\Loose;

use App\Console\Mails\BaseMail;

class DiscordMail extends BaseMail
{
	public $user;

    public function __construct($user)
    {
    	parent::__construct();
    
    	$this->user = $user;
    }
    
    public function build()
    {
        return $this
        	->subject(trans('console/mail/loose/discord.title') . ' - ' . $this->settings->name)
        	->view('console.mail.loose.discord');
    }
}
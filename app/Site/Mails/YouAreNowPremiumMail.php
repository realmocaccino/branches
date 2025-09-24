<?php
namespace App\Site\Mails;

class YouAreNowPremiumMail extends BaseMail
{
	public $user, $text;

    public function __construct($user, $text)
    {
    	parent::__construct();
    	
    	$this->user = $user;
    	$this->text = $text;
    }

    public function build()
    {
        return $this
        	->subject('Premium')
        	->view('site.mails.you_are_now_premium');
    }
}
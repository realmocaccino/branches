<?php
namespace App\Console\Mails;

class WeMissYouMail extends BaseMail
{
	public $user, $games;

    public function __construct($user, $games)
    {
    	parent::__construct();
    
    	$this->user = $user;
    	$this->games = $games;
    }
    
    public function build()
    {
        return $this
        	->subject('Sentimos sua falta - ' . $this->settings->name)
        	->view('console.mail.we_miss_you');
    }
}

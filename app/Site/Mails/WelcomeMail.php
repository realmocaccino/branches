<?php
namespace App\Site\Mails;

class WelcomeMail extends BaseMail
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
        	->subject('Bem vindo ao ' . $this->settings->name)
        	->view('site.mails.welcome');
    }
}
<?php
namespace App\Site\Mails;

class NewFollowerMail extends BaseMail
{
	public $user, $text, $follower;

    public function __construct($user, $text, $follower)
    {
    	parent::__construct();
    	
    	$this->user = $user;
    	$this->text = $text;
    	$this->follower = $follower;
    }

    public function build()
    {
        return $this
        	->subject('Novo seguidor')
        	->view('site.mails.new_follower');
    }
}
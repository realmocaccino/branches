<?php
namespace App\Site\Mails;

class RedefinePasswordMail extends BaseMail
{
	protected $user;

    public function __construct($user)
    {
    	parent::__construct();
    
    	$this->user = $user;
    }

    public function build()
    {
        return $this
        	->subject('Redefinir Senha - ' . $this->settings->name)
        	->view('site.mails.redefine_password', [
        		'user' => $this->user
        	]);
    }
}
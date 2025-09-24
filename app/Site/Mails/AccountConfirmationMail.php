<?php
namespace App\Site\Mails;

class AccountConfirmationMail extends BaseMail
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
        	->subject('Confirmação de Conta - ' . $this->settings->name)
        	->view('site.mails.account_confirmation');
    }
}